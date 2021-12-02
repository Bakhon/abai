<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WellEdit extends WellRegister
{
    protected $configurationFileName = 'well_edit';

    public function getResults(): array
    {
        try {
            $rows = $this->getRows();

            $availableActions = $this->getAvailableActions();
            if ($rows->isNotEmpty()) {
                $availableActions = array_filter($availableActions, function ($action) {
                    return !in_array($action, ['create']);
                });
            }

            return [
                'rows' => $rows->values(),
                'columns' => $this->getColumns(),
                'form' => $this->params(),
                'available_actions' => array_values($availableActions)
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    protected function getRows(): Collection
    {
        $wellId = (int)$this->request->get('well_id');

        $rows = Well::query()
            ->where('id', $wellId)
            ->select(
                'uwi',
                'project_date',
                'whc_alt',
                'whc_h',
                'whc',
                'bottom_coord',
                'drill_start_date',
                'drill_end_date',
                'drill_contractor',
                'drill_contract_num',
                'drill_contract_date',
                'project_depth',
                'gas_factor_avg'
            )
            ->get()
            ->map(function ($well) {
                $result = $well->toArray();
                if ($well->spatialObject) {
                    $coords = explode(',', str_replace(['(', ')'], '', $well->spatialObject->coord_point));
                    $result['whc.coord_point.x'] = $coords[0];
                    $result['whc.coord_point.y'] = $coords[1];
                    $result['coord_system'] = $well->spatialObject->coord_system;
                }
                if ($well->spatialObjectBottom) {
                    $coords = explode(',', str_replace(['(', ')'], '', $well->spatialObjectBottom->coord_point));
                    $result['bottom_coord.coord_point.x'] = $coords[0];
                    $result['bottom_coord.coord_point.y'] = $coords[1];
                }
                return $result;
            });

        return $rows;
    }

    protected function submitForm(): array
    {
        $wellId = $this->request->get('well');
        if (empty($wellId)) {
            throw new \Exception('Нет скважины для редактирования');
        }

        $data = $this->request->except(
            [
                'well',
                'coord_system',
                'whc.coord_point.x',
                'whc.coord_point.y',
                'bottom_coord.coord_point.x',
                'bottom_coord.coord_point.y',
            ]
        );
        if (!empty($this->params()['default_values'])) {
            $data = array_merge($this->params()['default_values'], $data);
        }

        $dbQuery = DB::connection('tbd')->table($this->params()['table']);

        $this->checkFormPermission('update');

        $dbQuery = $dbQuery->where('id', $wellId);

        $this->originalData = $dbQuery->first();
        $dbQuery->update($data);

        $this->submittedData['fields'] = $data;
        $this->submittedData['id'] = $wellId;
        $this->updateCoords($wellId);

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $wellId)->first();
    }

}