<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WaterProduction extends TableForm
{
    protected $configurationFileName = 'water_production';

    public function getRows(array $params = []): array
    {
        $filter = json_decode($this->request->get('filter'));
        $wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

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

        return [
            'rows' => $wells->toArray()
        ];
    }

    public function getFormatedFieldValue(array $field, array $rawValue): ?array
    {
        if ($field['code'] === 'worktime') {
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

    private function getOtherUwis($item): array
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

    public function getGeoBreadcrumbs($geo): string
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

    protected function saveSingleFieldInDB(string $field, int $wellId, Carbon $date, $value): void
    {
        $column = $this->getFieldByCode($field);

        $item = $this->getFieldRow($column, $wellId, $date);

        if (empty($item)) {
            $data = [
                'well' => $wellId,
                $column['column'] => $value,
                'dbeg' => $date->toDateTimeString(),
                'dend' => $date->toDateTimeString(),
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
}