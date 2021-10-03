<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Dictionaries\ValueType;
use App\Models\BigData\Dictionaries\WellActivity;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FluidProductionMonth extends MeasLogByMonth
{
    protected $configurationFileName = 'fluid_production_month';
    protected $techMode;
    protected $liquid;
    protected $bsw;
    protected $workTime;

    public function getResults(array $params = []): array
    {
        if ($this->request->get('type') !== 'tech') {
            throw new \Exception(trans('bd.select_gu'));
        }

        $filter = json_decode($this->request->get('filter'));
        $date = Carbon::parse($filter->date)->timezone('Asia/Almaty')->toImmutable();

        $wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

        $rows = $this->getRows($date, $wells);
        $columns = $this->getColumns($date);
        $summary = $this->getSummary($date, $wells);

        return [
            'columns' => $columns,
            'rows' => $rows,
            'summary' => $summary
        ];
    }

    protected function getRows(CarbonImmutable $date, Collection $wells): array
    {
        $wellIds = $wells->pluck('id')->toArray();

        $this->techMode = $this->getTechMode($wellIds, $date);
        $this->liquid = $this->getLiquid($wellIds, $date);
        $this->bsw = $this->getBsw($wellIds, $date);
        $this->workTime = $this->getWorkTime($wellIds, $date);
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
                $row = $this->getIndicatorRowData(
                    $well,
                    $code,
                    $date,
                );
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
            ->where('ml.dend', '<=', $date->endOfDay())
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
            ->where('mwc.dend', '<=', $date->endOfDay())
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
        CarbonImmutable $date
    ): array {
        $workTime = $this->workTime[$well->id] ?? null;

        $row = [
            'id' => $well->id . '|' . $code,
            'indicator' => ['value' => trans('bd.forms.fluid_production_month.' . $code)]
        ];

        switch ($code) {
            case 'liquid':
                $row = array_merge($row, $this->getLiquidRowData($well, $date));
                break;
            case 'bsw':
                $row = array_merge($row, $this->getBswRowData($well, $date));
                break;
            case 'oil':
                $row = array_merge($row, $this->getOilRowData($well, $date));
                break;
            case 'note':
                $monthDay = $date->startOfMonth();
                while ($monthDay <= $date) {
                    $liquidValue = $this->getLiquidValueForDay($well->id, $monthDay->format('j'));
                    $row[$monthDay->format('d.m.Y')] = ['value' => $liquidValue['note'] ?? null];
                    $monthDay = $monthDay->addDay();
                }
                break;
            case 'reason_decline':
                $monthDay = $date->startOfMonth();
                while ($monthDay <= $date) {
                    $liquidValue = $this->getLiquidValueForDay($well->id, $monthDay->format('j'));
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
                while ($monthDay <= $date) {
                    $row[$monthDay->format('d.m.Y')] = $workTime[$monthDay->format('j')];
                    $monthDay = $monthDay->addDay();
                }
                break;
        }
        return $row;
    }

    private function getLiquidRowData($well, CarbonImmutable $date): array
    {
        $row = [];
        $row['tech'] = [
            'value' => $this->techMode->get($well->id) ? $this->techMode->get($well->id)->liquid : null
        ];

        $count = $sum = 0;
        $monthDay = $date->startOfMonth();
        while ($monthDay <= $date) {
            $wellLiquid = $this->liquid->get($well->id);
            if ($wellLiquid) {
                $liquidValue = $wellLiquid->get($monthDay->format('j'));
                $row[$monthDay->format('d.m.Y')] = ['value' => $liquidValue['liquid'] ?? null];

                if (!empty($liquidValue['liquid'])) {
                    $count++;
                    $sum += $liquidValue['liquid'];
                }
            }

            $monthDay = $monthDay->addDay();
        }

        $row['meas_count'] = ['value' => $count];
        $row['avg'] = ['value' => $count > 0 ? round($sum / $count, 2) : 0];
        return $row;
    }

    private function getBswRowData($well, CarbonImmutable $date): array
    {
        $row = [];
        $row['tech'] = [
            'value' => $this->techMode->get($well->id) ? $this->techMode->get($well->id)->wcut : null
        ];

        $count = $sum = 0;
        $monthDay = $date->startOfMonth();
        while ($monthDay <= $date) {
            $wellBsw = $this->bsw->get($well->id);
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
        $row['avg'] = ['value' => $count > 0 ? round($sum / $count, 2) : 0];
        return $row;
    }

    private function getOilRowData(
        $well,
        CarbonImmutable $date
    ) {
        $liquidRow = $this->getLiquidRowData($well, $date);
        $bswRow = $this->getLiquidRowData($well, $date);
        $oilDensity = $this->techMode->get($well->id) ? $this->techMode->get($well->id)->oil_density : 0;

        $count = $sum = 0;
        $monthDay = $date->startOfMonth();
        while ($monthDay <= $date) {
            $day = $monthDay->format('d.m.Y');

            $liquidValue = isset($liquidRow[$day]) ? $liquidRow[$day]['value'] : 0;
            $bswValue = isset($bswRow[$day]) ? $bswRow[$day]['value'] : 0;
            $oil = $liquidValue * (1 - $bswValue / 100) * $oilDensity;

            $row[$day] = [
                'is_editable' => false,
                'value' => $oil
            ];

            if (!empty($oil)) {
                $count++;
                $sum += $bswValue;
            }

            $monthDay = $monthDay->addDay();
        }

        $row['meas_count'] = ['value' => $count];
        $row['avg'] = ['value' => $count > 0 ? round($sum / $count, 2) : 0];

        return $row;
    }

    private function getLiquidValueForDay(int $wellId, string $day)
    {
        $wellLiquid = $this->liquid->get($wellId);
        return $wellLiquid ? $wellLiquid->get($day) : null;
    }

    protected function getColumns(CarbonImmutable $date): array
    {
        $columns = $this->getFields()->toArray();

        $monthDay = $date->startOfMonth();
        while ($monthDay <= $date) {
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

    private function getSummary(CarbonImmutable $date, Collection $wells)
    {
        $tech = Tech::find($this->request->get('id'));

        $workingWells = $this->getWorkingWellsCount($wells);
        dd($this->liquid);
        $result = [
            'org' => $tech ? $tech->name_ru : '',
            'wells' => [
                'total' => $wells->count(),
                'working' => $workingWells,
                'stopped' => $wells->count() - $workingWells,
            ],
            'daily' => [
                'plan' => [
                    'liquid' => 0,
                    'liquid_avg' => 0,
                    'oil' => 0
                ],
                'fact' => [
                    'liquid' => 0,
                    'liquid_avg' => 0,
                    'oil' => 0,
                    'bsw' => 0,
                ],
                'diff' => [
                    'liquid' => 0,
                    'liquid_avg' => 0,
                    'oil' => 0
                ],
            ],
            'monthly' => [
                'plan' => [
                    'liquid' => 0,
                    'liquid_avg' => 0,
                    'oil' => 0
                ],
                'fact' => [
                    'liquid' => 0,
                    'liquid_avg' => 0,
                    'oil' => 0,
                    'bsw' => 0,
                ],
                'diff' => [
                    'liquid' => 0,
                    'liquid_avg' => 0,
                    'oil' => 0
                ],
            ]
        ];
        dd($result);
    }

    private function getWorkingWellsCount(Collection $wells)
    {
        return $wells->filter(function ($well) {
            if (empty($this->workTime[$well->id])) {
                return false;
            }
            $totalTime = 0;
            foreach ($this->workTime[$well->id] as $time) {
                $totalTime += $time['value'];
            }
            return !empty($totalTime);
        })->count();
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

    private function saveField(string $table, string $field, $wellId, CarbonImmutable $date, $value)
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