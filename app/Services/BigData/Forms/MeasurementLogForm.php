<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Helpers\WorktimeHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

abstract class MeasurementLogForm extends TableForm
{

    const WELL_STATUS_WORK = 'WRK';
    const WELL_STATUS_PERIODIC = 'PEXP';
    const WELL_STATUS_ACCUMULATION = 'CNTM';
    const WELL_ACTIVE_STATUSES = [
        self::WELL_STATUS_WORK,
        self::WELL_STATUS_PERIODIC,
        self::WELL_STATUS_ACCUMULATION
    ];

    protected $workTimes;
    protected $otherUwis;

    public function getResults(): array
    {
        $filter = json_decode($this->request->get('filter'));
        $params['filter']['well_category'] = $this->wellCategories;

        $wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

        $date = Carbon::parse($filter->date)->timezone('Asia/Almaty')->toImmutable();
        $this->workTimes = WorktimeHelper::getWorkTime(
            $wells->pluck('id')->toArray(),
            $date->startOfDay(),
            $date->endOfDay()
        );

        $this->otherUwis = $this->getOtherUwis($wells->pluck('id')->toArray());

        $tables = $this->getFields()->pluck('table')->filter()->unique();
        $rowData = $this->fetchRowData(
            $tables,
            $wells->pluck('id')->toArray(),
            Carbon::parse($filter->date)
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

                $result['id'] = $result['uwi']['id'];
                return $result;
            }
        );

        $this->addLimits($wells);

        return [
            'rows' => $wells->toArray()
        ];
    }

    protected function getCustomFieldValue(array $field, array $rowData, Model $item): ?array
    {
        switch ($field['code']) {
            case 'worktime':

                if (!isset($this->workTimes[$item->id])) {
                    return ['value' => 0];
                }
                return ['value' => reset($this->workTimes[$item->id]) * 24];

            case 'density_oil':

                return [
                    'value' => $item->geo->first() ? floatval($item->geo->first()->density_oil) : null
                ];

            case 'other_uwi':

                if (!isset($this->otherUwis[$item->id])) {
                    return ['value' => ''];
                }
                return $this->otherUwis[$item->id];

            case 'geo':

                return [
                    'value' => $this->getGeoBreadcrumbs($item->geo->first())
                ];
        }

        return null;
    }

    private function getOtherUwis(array $wellIds): array
    {
        $uwis = DB::connection('tbd')
            ->table('dict.well')
            ->selectRaw('well.id,well.uwi,array_agg(b.uwi) joint_well')
            ->leftJoin('prod.joint_wells as j', 'well.id', DB::raw("any(j.well_id_arr)"))
            ->leftJoin('dict.well as b', 'b.id', DB::raw('any(array_remove(j.well_id_arr, well.id))'))
            ->whereIn('well.id', $wellIds)
            ->groupBy('well.id', 'well.uwi')
            ->get();

        $result = [];
        foreach ($wellIds as $wellId) {
            $uwi = $uwis->where('id', $wellId)->first();
            $result[$wellId] = [
                'value' => (!$uwi || $uwi->joint_well === '{NULL}') ? null : str_replace(
                    ['{', '}'],
                    '',
                    $uwi->joint_well
                ),
            ];
        }

        return $result;
    }

    private function getGeoBreadcrumbs($geo = null)
    {
        if (empty($geo)) {
            return '';
        }

        if (Cache::has('bd_geo_breadcrumb_' . $geo->id)) {
            return Cache::get('bd_geo_breadcrumb_' . $geo->id);
        }

        $path = [];
        $isFieldFound = false;
        $ancestors = $geo->ancestors()->reverse();
        foreach ($ancestors as $ancestor) {
            if ($ancestor->type->code === 'FLD') {
                $isFieldFound = true;
            }
            if (!$isFieldFound) {
                continue;
            }
            $path[] = $ancestor->name_ru;
        }

        $path[] = $geo->name_ru;

        $breadcrumbs = implode(' / ', $path);
        Cache::put('bd_geo_breadcrumb_' . $geo->id, $breadcrumbs, now()->addMonth());

        return $breadcrumbs;
    }

    public function submitForm(array $fields, array $filter = []): array
    {
        foreach ($fields as $wellId => $wellFields) {
            foreach ($wellFields as $columnCode => $field) {
                $column = $this->getFieldByCode($columnCode);
                if (isset($field['id'])) {
                    DB::connection('tbd')
                        ->table($column['table'])
                        ->where('id', $field['id'])
                        ->update(
                            [
                                $column['column'] => $field['value']
                            ]
                        );
                } else {
                    $this->insertValueInCell(
                        $column['table'],
                        $column['column'],
                        $column['additional_filter'] ?? null,
                        $wellId,
                        $filter['date'],
                        $field['value']
                    );
                }
            }
        }
        return [];
    }
}