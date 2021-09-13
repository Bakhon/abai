<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\ValueType;
use App\Models\BigData\Dictionaries\WellActivity;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FluidProductionMonth extends TableForm
{
    protected $configurationFileName = 'fluid_production_month';

    public function getRows(array $params = []): array
    {
        $filter = json_decode($this->request->get('filter'));
        $date = Carbon::parse($filter->date)->timezone('Asia/Almaty')->toImmutable();

        $wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

        $rows = $this->getRowsData($date, $wells);
        $columns = $this->getColumns($date);

        return [
            'columns' => $columns,
            'rows' => $rows
        ];
    }

    private function getRowsData(CarbonImmutable $date, Collection $wells): array
    {
        $wellIds = $wells->pluck('id')->toArray();

        $techMode = $this->getTechMode($wellIds, $date);
        $liquid = $this->getLiquid($wellIds, $date);
        $bsw = $this->getBsw($wellIds, $date);
        $workTime = $this->getWorkTime($wellIds, $date);
        $otherUwis = $this->getOtherUwis($wellIds);

        $indicators = [
            'liquid',
            'bsw',
            'oil',
            'note',
            'reason_decline',
            'worktime'
        ];

        $rows = [];
        foreach ($wells as $well) {
            $firstRow = [
                'uwi' => ['value' => $well->uwi],
                'other_uwi' => $otherUwis[$well->id],
                'tap' => ['value' => $well->tech ? $well->tech->name_ru : null],
            ];

            $i = 0;
            foreach ($indicators as $code) {
                $row = $this->getIndicatorRowData($well, $code, $techMode, $date, $liquid, $bsw, $workTime[$well->id]);
                if ($i++ === 0) {
                    $row = array_merge($firstRow, $row);
                }
                $rows[] = $row;
            }
            $rows[] = [];
        }
        return $rows;
    }

    private function getTechMode(array $wellIds, CarbonImmutable $date): Collection
    {
        return DB::connection('tbd')
            ->table('prod.tech_mode_prod_oil')
            ->whereIn('well', $wellIds)
            ->where('dbeg', '>=', $date->startOfMonth())
            ->where('dend', '<=', $date->endOfMonth())
            ->get()
            ->groupBy('well')
            ->map(function ($items) {
                return $items->first();
            });
    }

    private function getLiquid(array $wellIds, CarbonImmutable $date): Collection
    {
        return DB::connection('tbd')
            ->table('prod.meas_liq as ml')
            ->select('ml.well', 'ml.liquid', 'ml.dbeg', 'ml.note', 'ml.reason_decline')
            ->join('dict.well_activity as wa', 'ml.activity', 'wa.id')
            ->join('dict.value_type as vt', 'ml.value_type', 'vt.id')
            ->whereIn('ml.well', $wellIds)
            ->where('ml.dbeg', '>=', $date->startOfMonth())
            ->where('ml.dend', '<=', $date)
            ->where('wa.code', 'PMSR')
            ->where('vt.code', 'MNT')
            ->get()
            ->groupBy('well')
            ->map(function ($items) {
                $items = $items->groupBy(function ($item) {
                    return Carbon::parse($item->dbeg)->format('j');
                });
                return $items->map(function ($item) {
                    $item = $item->first();
                    return [
                        'liquid' => round($item->liquid, 2),
                        'note' => $item->note,
                        'reason_decline' => $item->reason_decline
                    ];
                });
            });
    }

    private function getBsw(array $wellIds, CarbonImmutable $date): Collection
    {
        return DB::connection('tbd')
            ->table('prod.meas_water_cut as mwc')
            ->join('dict.well_activity as wa', 'mwc.activity', 'wa.id')
            ->join('dict.value_type as vt', 'mwc.value_type', 'vt.id')
            ->whereIn('mwc.well', $wellIds)
            ->where('mwc.dbeg', '>=', $date->startOfMonth())
            ->where('mwc.dend', '<=', $date)
            ->where('wa.code', 'PMSR')
            ->where('vt.code', 'MNT')
            ->get()
            ->groupBy('well')
            ->map(function ($items) {
                $items = $items->groupBy(function ($item) {
                    return Carbon::parse($item->dbeg)->format('j');
                });
                return $items->map(function ($item) {
                    return $item->first()->water_cut;
                });
            });
    }

    private function getWorkTime(array $wellIds, CarbonImmutable $date): array
    {
        $result = [];

        $wellStatuses = DB::connection('tbd')
            ->table('prod.well_status as s')
            ->select('s.status', 's.dbeg', 's.dend', 's.well')
            ->join('dict.well_status_type', 'dict.well_status_type.id', 's.status')
            ->where('dbeg', '<=', $date->startOfMonth())
            ->where('dend', '>=', $date)
            ->whereIn('well', $wellIds)
            ->whereIn('dict.well_status_type.code', MeasurementLogForm::WELL_ACTIVE_STATUSES)
            ->get()
            ->map(
                function ($item) {
                    $item->dbeg = Carbon::parse($item->dbeg);
                    $item->dend = Carbon::parse($item->dend);
                    return $item;
                }
            );

        $monthDay = $date->startOfMonth();
        while ($monthDay < $date) {
            $startOfDay = $monthDay->startOfDay();
            $endOfDay = $monthDay->endOfDay();
            foreach ($wellIds as $wellId) {
                $result[$wellId][$monthDay->format('j')] = [
                    'value' => $this->getHoursForOneDay($wellStatuses, $endOfDay, $startOfDay, $wellId)
                ];
            }

            $monthDay = $monthDay->addDay();
        }

        return $result;
    }

    private function getHoursForOneDay(
        Collection $wellStatuses,
        CarbonImmutable $endOfDay,
        CarbonImmutable $startOfDay,
        $wellId
    ): int {
        $hours = 0;
        $dailyStatuses = $wellStatuses
            ->where('dbeg', '<=', $endOfDay)
            ->where('dend', '>=', $startOfDay)
            ->where('well', $wellId);

        foreach ($dailyStatuses as $status) {
            if ($status->dbeg <= $startOfDay && $status->dend >= $endOfDay) {
                $hours += 24;
            } elseif ($status->dbeg > $startOfDay) {
                $hours += $status->dbeg->diffInHours($status->dend < $endOfDay ? $status->dend : $endOfDay);
            } elseif ($status->dend < $endOfDay) {
                $hours += $startOfDay->diffInHours($status->dend);
            }
        }
        return $hours;
    }

    private function getOtherUwis(array $wellIds): array
    {
        $uwis = DB::connection('tbd')
            ->table('dict.well')
            ->selectRaw('well.id,well.uwi as other_uwi')
            ->leftJoin('prod.joint_wells as j', 'well.id', DB::raw("any(j.well_id_arr)"))
            ->leftJoin('dict.well as b', 'b.id', DB::raw('any(array_remove(j.well_id_arr, well.id))'))
            ->whereIn('well.id', $wellIds)
            ->groupBy('well.id', 'well.uwi')
            ->get();

        $result = [];
        foreach ($wellIds as $wellId) {
            $uwi = $uwis->where('id', $wellId)->first();
            $result[$wellId] = [
                'value' => (!$uwi || $uwi->other_uwi === '{NULL}') ? null : str_replace(
                    ['{', '}'],
                    '',
                    $uwi->other_uwi
                ),
            ];
        }

        return $result;
    }

    private function getIndicatorRowData(
        $well,
        string $code,
        Collection $techMode,
        CarbonImmutable $date,
        Collection $liquid,
        Collection $bsw,
        $workTime
    ): array {
        $row = [
            'id' => $well->id . '|' . $code,
            'indicator' => ['value' => trans('bd.forms.fluid_production_month.' . $code)]
        ];

        switch ($code) {
            case 'liquid':
                $row = array_merge($row, $this->getLiquidRowData($techMode, $well, $date, $liquid));
                break;
            case 'bsw':
                $row = array_merge($row, $this->getBswRowData($techMode, $well, $date, $bsw));
                break;
            case 'oil':
                continue;
            case 'note':
                $monthDay = $date->startOfMonth();
                while ($monthDay < $date) {
                    $liquidValue = $liquid->get($well->id)->get($monthDay->format('j'));
                    $row[$monthDay->format('d.m.Y')] = ['value' => $liquidValue['note'] ?? null];
                    $monthDay = $monthDay->addDay();
                }
                break;
            case 'reason_decline':
                $monthDay = $date->startOfMonth();
                while ($monthDay < $date) {
                    $liquidValue = $liquid->get($well->id)->get($monthDay->format('j'));
                    $row[$monthDay->format('d.m.Y')] = [
                        'value' => $liquidValue['reason_decline'] ?? null,
                        'is_editable' => true,
                        'type' => 'dict',
                        'dict' => 'reason_rrd'
                    ];
                    $monthDay = $monthDay->addDay();
                }
                break;
            case 'worktime':
                $monthDay = $date->startOfMonth();
                while ($monthDay < $date) {
                    $row[$monthDay->format('d.m.Y')] = $workTime[$monthDay->format('j')];
                    $monthDay = $monthDay->addDay();
                }
                break;
        }
        return $row;
    }

    private function getLiquidRowData(Collection $techMode, $well, CarbonImmutable $date, Collection $liquid): array
    {
        $row = [];
        $row['tech'] = [
            'value' => $techMode->get($well->id) ? $techMode->get($well->id)->liquid : null
        ];

        $count = $sum = 0;
        $monthDay = $date->startOfMonth();
        while ($monthDay < $date) {
            $wellLiquid = $liquid->get($well->id);
            $liquidValue = $wellLiquid->get($monthDay->format('j'));
            $row[$monthDay->format('d.m.Y')] = ['value' => $liquidValue['liquid'] ?? null];

            if (!empty($liquidValue['liquid'])) {
                $count++;
                $sum += $liquidValue['liquid'];
            }

            $monthDay = $monthDay->addDay();
        }

        $row['meas_count'] = ['value' => $count];
        $row['avg'] = ['value' => round($sum / $count, 2)];
        return $row;
    }

    private function getBswRowData(Collection $techMode, $well, CarbonImmutable $date, Collection $bsw): array
    {
        $row = [];
        $row['tech'] = [
            'value' => $techMode->get($well->id) ? $techMode->get($well->id)->wcut : null
        ];

        $count = $sum = 0;
        $monthDay = $date->startOfMonth();
        while ($monthDay < $date) {
            $wellBsw = $bsw->get($well->id);
            $bswValue = $wellBsw ? $wellBsw->get($monthDay->format('j')) : null;
            $row[$monthDay->format('d.m.Y')] = [
                'is_editable' => true,
                'value' => $bswValue ?? null
            ];

            if (!empty($bswValue)) {
                $count++;
                $sum += $bswValue;
            }

            $monthDay = $monthDay->addDay();
        }

        $row['meas_count'] = ['value' => $count];
        $row['avg'] = ['value' => round($sum / $count, 2)];
        return $row;
    }

    private function getColumns(CarbonImmutable $date): array
    {
        $columns = $this->getFields()->toArray();

        $monthDay = $date->startOfMonth();
        while ($monthDay < $date) {
            $columns[] = [
                'code' => $monthDay->format('d.m.Y'),
                'type' => 'text',
                'is_editable' => false,
                'title' => $monthDay->format('j')
            ];
            $monthDay = $monthDay->addDay();
        }

        $columns[] = [
            'code' => 'avg',
            'title' => trans('bd.forms.fluid_production_month.avg'),
            'type' => 'text',
            'is_editable' => false
        ];
        $columns[] = [
            'code' => 'meas_count',
            'title' => trans('bd.forms.fluid_production_month.meas_count'),
            'type' => 'text',
            'is_editable' => false
        ];

        return $columns;
    }

    protected function saveSingleFieldInDB(array $params): void
    {
        list($wellId, $field) = explode('|', $params['wellId']);
        $date = Carbon::parse($params['field'])->timezone('Asia/Almaty')->toImmutable();
        switch ($field) {
            case 'bsw':
                $this->saveField('prod.meas_water_cut', 'water_cut', $wellId, $date, $params['value']);
                break;
            case 'reason_decline':
                $this->saveField('prod.meas_liq', 'reason_decline', $wellId, $date, $params['value']);
                break;
        }
    }

    private function saveField(string $table, string $field, int $wellId, CarbonImmutable $date, float $value)
    {
        $activity = WellActivity::where('code', 'PMSR')->first();
        $valueType = ValueType::where('code', 'MNT')->first();

        $row = DB::connection('tbd')
            ->table($table)
            ->where('activity', $activity->id)
            ->where('value_type', $valueType->id)
            ->where('well', $wellId)
            ->where('dbeg', '>=', $date->startOfDay())
            ->where('dbeg', '<=', $date->endOfDay())
            ->first();

        if (empty($row)) {
            DB::connection('tbd')
                ->table($table)
                ->insert(
                    [
                        'activity' => $activity->id,
                        'value_type' => $valueType->id,
                        'well' => $wellId,
                        $field => $value,
                        'dbeg' => $date->startOfDay(),
                        'dend' => $date->endOfDay()
                    ]
                );
        } else {
            DB::connection('tbd')
                ->table($table)
                ->where('id', $row->id)
                ->update(
                    [
                        $field => $value
                    ]
                );
        }
    }
}