<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Well;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FluidProduction extends TableForm
{

    protected $configurationFileName = 'fluid_production';

    public function getRows(array $params = [])
    {
        $tech = Tech::find($this->request->get('tech'));

        $wellsQuery = Well::query()
            ->with('techs', 'geo')
            ->select('id', 'uwi')
            ->orderBy('uwi')
            ->active(Carbon::parse($this->request->get('date')))
            ->whereHas(
                'techs',
                function ($query) use ($tech) {
                    return $query
                        ->where('dict.tech.id', $tech->id)
                        ->whereDate('dict.tech.dbeg', '<=', $this->request->get('date'))
                        ->whereDate('dict.tech.dend', '>=', $this->request->get('date'));
                }
            );

        if (isset($params['filter']['row_id'])) {
            $wellsQuery->where('id', $params['filter']['row_id']);
        }

        $wells = $wellsQuery->get();

        $tables = $this->getFields()->pluck('table')->filter()->unique();
        $rowData = $this->fetchRowData(
            $tables,
            $wells->pluck('id')->toArray(),
            Carbon::parse($this->request->get('date'))
        );

        $wells->transform(
            function ($item) use ($rowData) {
                $result = [];

                foreach ($this->getFields() as $field) {
                    $fieldValue = $this->getFieldValue($field, $rowData, $item);
                    if (!empty($fieldValue)) {
                        $result[$field['code']] = $fieldValue;
                    }
                }
                return $result;
            }
        );

        $this->addLimits($wells);

        return $wells->toArray();
    }

    public function getGeoBreadcrumbs($geo)
    {
        if (Cache::has('bd_geo_breadcrumb_' . $geo->id)) {
            return Cache::get('bd_geo_breadcrumb_' . $geo->id);
        }

        $ancestors = $geo->ancestors()
            ->reverse()
            ->pluck('name_ru')
            ->toArray();

        $ancestors[] = $geo->name;
        $breadcrumbs = implode(' / ', $ancestors);
        Cache::put('bd_geo_breadcrumb_' . $geo->id, $breadcrumbs, now()->addMonth());

        return $breadcrumbs;
    }

    public function getFormatedFieldValue(array $field, array $rawValue): ?array
    {
        switch ($field['code']) {
            case 'worktime':

                $value = 0;
                if (isset($rawValue['value']) && $rawValue['value'] !== null) {
                    $value = in_array($rawValue['value'], Well::WELL_ACTIVE_STATUSES) ? 1 : 0;
                }

                return [
                    'value' => $value
                ];
        }

        return $rawValue;
    }

    protected function getCustomFieldValue(array $field, array $rowData, Model $item): ?array
    {
        switch ($field['code']) {
            case 'density_oil':

                return [
                    'value' => floatval($item->geo->first()->density_oil)
                ];

            case 'other_uwi':

                return $this->getOtherUwis($item);

            case 'geo':

                return [
                    'value' => $this->getGeoBreadcrumbs($item->geo->first())
                ];
        }

        return null;
    }

    protected function saveSingleFieldInDB(string $field, int $wellId, Carbon $date, $value): void
    {
        $column = $this->getFieldByCode($field);

        $item = $this->getFieldRow($column, $wellId, $date);

        if (empty($item)) {
            $data = [
                'well' => $wellId,
                $column['column'] => $value,
                'dbeg' => $date->toDateTimeString()
            ];

            if (!empty($column['additional_filter'])) {
                foreach ($column['additional_filter'] as $key => $val) {
                    $data[$key] = $val;
                }
            }

            DB::connection('tbd')
                ->table($column['table'])
                ->insert($data);
        } else {
            DB::connection('tbd')
                ->table($column['table'])
                ->where('id', $item->id)
                ->update(
                    [
                        $column['column'] => $value
                    ]
                );
        }
    }

    private function getOtherUwis($item)
    {
        $uwi = DB::connection('tbd')
            ->table('dict.well')
            ->selectRaw('well.id,well.uwi as other_uwi')
            ->leftJoin('prod.joint_wells as j', 'well.id', DB::raw("any(j.well_id_arr)"))
            ->leftJoin('dict.well as b', 'b.id', DB::raw('any(array_remove(j.well_id_arr, well.id))'))
            ->where('well.id', $item->id)
            ->groupBy('well.id', 'well.uwi')
            ->first();

        return [
            'value' => $uwi->other_uwi === '{NULL}' ? null : str_replace(['{', '}'], '', $uwi->other_uwi),
        ];
    }
}