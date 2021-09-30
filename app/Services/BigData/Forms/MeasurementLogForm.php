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

    protected function getCustomFieldValue(array $field, array $rowData, Model $item): ?array
    {
        switch ($field['code']) {
            case 'worktime':

                return $this->getWorktime($item);

            case 'density_oil':

                return [
                    'value' => $item->geo->first() ? floatval($item->geo->first()->density_oil) : null
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

    private function getWorktime(Model $well)
    {
        $filter = json_decode($this->request->get('filter'));
        $date = Carbon::parse($filter->date)->timezone('Asia/Almaty')->toImmutable();
        $startOfDay = $date->startOfDay();
        $endOfDay = $date->endOfDay();

        $wellStatuses = DB::connection('tbd')
            ->table('prod.well_status as s')
            ->select('s.status', 's.dbeg', 's.dend', 's.well')
            ->join('dict.well_status_type', 'dict.well_status_type.id', 's.status')
            ->where('dbeg', '<=', $endOfDay)
            ->where('dend', '>=', $startOfDay)
            ->where('well', $well->id)
            ->whereIn('dict.well_status_type.code', self::WELL_ACTIVE_STATUSES)
            ->get()
            ->map(
                function ($item) {
                    $item->dbeg = Carbon::parse($item->dbeg);
                    $item->dend = Carbon::parse($item->dend);
                    return $item;
                }
            );

        $hours = WorktimeHelper::getHoursForOneDay(
            $wellStatuses,
            $startOfDay,
            $endOfDay,
            $well->id
        );

        return [
            'value' => min($hours, 24)
        ];
    }

    private function getOtherUwis(Model $item)
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

    private function getGeoBreadcrumbs($geo = null)
    {
        if (empty($geo)) {
            return '';
        }

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

    protected function saveSingleFieldInDB(array $params): void
    {
        $column = $this->getFieldByCode($params['field']);

        $item = $this->getFieldRow($column, $params['wellId'], $params['date']);

        if (empty($item)) {
            $data = [
                'well' => $params['wellId'],
                $column['column'] => $params['value'],
                'dbeg' => $params['date']->toDateTimeString()
            ];

            DB::connection('tbd')
                ->table($column['table'])
                ->insert($data);
        } else {
            DB::connection('tbd')
                ->table($column['table'])
                ->where('id', $item->id)
                ->update(
                    [
                        $column['column'] => $params['value']
                    ]
                );
        }
    }
}