<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Dictionaries\ValueType;
use App\Models\BigData\Dictionaries\WellActivity;
use App\Services\BigData\TableFormHeaderService;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FluidProductionMonth extends MeasLogByMonth
{
    protected $configurationFileName = 'fluid_production_month';
    protected $wells;
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

        $params['filter']['well_category'] = ['OIL'];
        $this->wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

        $rows = $this->getRows($date);
        $columns = $this->getColumns($date);


        return [
            'columns' => $columns,
            'rows' => $rows,
            'summary' => [
                'tables' => [
                    [
                        'title' => 'Сводка по узлу',
                        'data' => $this->getSummaryByTech($date)
                    ],
                    [
                        'title' => 'Итоговые показатели',
                        'data' => $this->getTotalValues($date, $rows)
                    ]
                ]
            ]
        ];
    }

    protected function getRows(CarbonImmutable $date): array
    {
        $wellIds = $this->wells->pluck('id')->toArray();

        $this->techMode = $this->getTechMode($wellIds, $date);
        $this->liquid = $this->getLiquid($wellIds, $date);
        $this->bsw = $this->getBsw($wellIds, $date);
        $this->gas = $this->getGas($wellIds, $date);
        $this->workTime = $this->getWorkTime($wellIds, $date);
        $otherUwis = $this->getOtherUwis($wellIds);

        $indicators = [
            'liquid',
            'bsw',
            'oil',
            'gas',
            'note',
            'reason_decline',
            'worktime'
        ];

        $rows = [];
        foreach ($this->wells as $well) {
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
        $gasTechMode = DB::connection('tbd')
            ->table('prod.tech_mode_prod_gas')
            ->whereIn('well', $wellIds)
            ->where('dend', '>=', $date->startOfMonth())
            ->where('dbeg', '<=', $date->endOfMonth())
            ->get()
            ->groupBy('well')
            ->map(function ($items) {
                $item = $items->first();
                return $item ? $item->gas : null;
            });

        return DB::connection('tbd')
            ->table('prod.tech_mode_prod_oil')
            ->whereIn('well', $wellIds)
            ->where('dend', '>=', $date->startOfMonth())
            ->where('dbeg', '<=', $date->endOfMonth())
            ->get()
            ->groupBy('well')
            ->map(function ($items) use ($gasTechMode) {
                $item = $items->first();
                if ($gasTechMode->get($item->well)) {
                    $item->gas = $gasTechMode->get($item->well);
                }
                return $item;
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

    private function getGas(array $wellIds, CarbonImmutable $date): Collection
    {
        return DB::connection('tbd')
            ->table('prod.meas_gas_prod')
            ->whereIn('well', $wellIds)
            ->get()
            ->groupBy('well')
            ->map(function ($items) {
                $items = $items->groupBy(function ($item) {
                    return Carbon::parse($item->dbeg)->format('j');
                });
                return $items->map(function ($item) {
                    return $item->first()->gas_prod_val;
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
            'indicator_code' => $code,
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
            case 'gas':
                $row = array_merge($row, $this->getGasRowData($well, $date));
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

                if (!empty($liquidValue['liquid'])) {
                    $count++;
                    $sum += $liquidValue['liquid'];
                }
            }

            $row[$monthDay->format('d.m.Y')] = [
                'is_editable' => true,
                'value' => $liquidValue['liquid'] ?? null
            ];

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
                'value' => round($oil, 2)
            ];

            if (!empty($oil)) {
                $count++;
                $sum += $oil;
            }

            $monthDay = $monthDay->addDay();
        }

        $row['meas_count'] = ['value' => $count];
        $row['avg'] = ['value' => $count > 0 ? round($sum / $count, 2) : 0];

        return $row;
    }

    private function getGasRowData($well, CarbonImmutable $date): array
    {
        $row = [];
        $row['tech'] = [
            'value' => $this->techMode->get($well->id) ? ($this->techMode->get($well->id)->gas ?? null) : null
        ];

        $count = $sum = 0;
        $monthDay = $date->startOfMonth();
        while ($monthDay <= $date) {
            $wellGas = $this->gas->get($well->id);
            $gasValue = $wellGas ? $wellGas->get($monthDay->format('j')) : null;
            $row[$monthDay->format('d.m.Y')] = [
                'is_editable' => true,
                'value' => $gasValue ?? null
            ];

            if (!empty($gasValue)) {
                $count++;
                $sum += $gasValue;
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

    private function getSummaryByTech(CarbonImmutable $date)
    {
        $tech = Tech::find($this->request->get('id'));

        $workingWells = $this->getWorkingWellsCount();


        $dailyPlanLiquid = $this->getDailyPlanField('liquid');
        $dailyPlanLiquidAvg = $this->getDailyPlanFieldAvg('liquid');
        $dailyPlanOil = $this->getDailyPlanField('oil');

        $dailyFactLiquid = $this->getDailyFactLiquid($date);
        $dailyFactLiquidAvg = $this->getDailyFactLiquidAvg($date);
        $dailyFactBsw = $this->getDailyFactBsw($date);
        $dailyFactOil = $this->getDailyFactOil($date);

        $monthlyPlanFluid = $dailyPlanLiquid * (int)$date->format('j');
        $monthlyPlanFluidAvg = $dailyPlanLiquidAvg;
        $monthlyPlanOil = $dailyPlanOil * (int)$date->format('j');

        $monthlyFactLiquid = $this->getMonthlyFactLiquid($date);
        $monthlyFactBsw = $this->getMonthlyFactBsw($date);
        $monthlyFactOil = $this->getMonthlyFactOil($date);

        $rows = [
            [
                'tech' => $tech ? $tech->name_ru : '',
                'wells_all' => $this->wells->count(),
                'wells_total' => $this->wells->count(),
                'wells_working' => $workingWells,
                'wells_stopped' => $this->wells->count() - $workingWells,
                'daily_plan_liquid' => round($dailyPlanLiquid, 2),
                'daily_plan_liquid_avg' => round($dailyPlanLiquidAvg, 2),
                'daily_plan_oil' => round($dailyPlanOil, 2),
                'daily_fact_liquid' => round($dailyFactLiquid, 2),
                'daily_fact_liquid_avg' => round($dailyFactLiquidAvg, 2),
                'daily_fact_oil' => round($dailyFactOil, 2),
                'daily_fact_bsw' => round($dailyFactBsw, 2),
                'daily_diff_liquid' => round($dailyFactLiquid - $dailyPlanLiquid, 2),
                'daily_diff_liquid_avg' => round($dailyFactLiquidAvg - $dailyPlanLiquidAvg, 2),
                'daily_diff_oil' => round($dailyFactOil - $dailyPlanOil, 2),
                'monthly_plan_liquid' => round($monthlyPlanFluid, 2),
                'monthly_plan_liquid_avg' => round($monthlyPlanFluidAvg, 2),
                'monthly_plan_oil' => round($monthlyPlanOil, 2),
                'monthly_fact_liquid' => round($monthlyFactLiquid, 2),
                'monthly_fact_oil' => round($monthlyFactOil, 2),
                'monthly_fact_bsw' => round($monthlyFactBsw, 2),
                'monthly_diff_liquid' => 0,
                'monthly_diff_liquid_avg' => 0,
                'monthly_diff_oil' => 0
            ]
        ];

        $mergeColumns = $this->getSummaryByTechMergeColumns();
        $columns = $this->getSummaryByTechColumns();

        $tableService = app()->make(TableFormHeaderService::class);

        return [
            'columns' => $columns,
            'merge_columns' => $mergeColumns,
            'complicated_header' => $tableService->getHeader($columns, $mergeColumns),
            'rows' => $rows
        ];
    }

    private function getWorkingWellsCount()
    {
        return $this->wells->filter(function ($well) {
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

    private function getDailyPlanField(string $field)
    {
        return $this->techMode->sum($field);
    }

    private function getDailyPlanFieldAvg(string $field)
    {
        return $this->techMode->avg($field);
    }

    private function getDailyFactLiquid(CarbonImmutable $date)
    {
        return $this->liquid->map(function ($wellLiquid) use ($date) {
            $currentDayLiquid = $wellLiquid->get($date->format('j'));
            if (!$currentDayLiquid) {
                return 0;
            }
            return $currentDayLiquid['liquid'];
        })->sum();
    }

    private function getDailyFactBsw(CarbonImmutable $date)
    {
        return $this->bsw->map(function ($wellBsw) use ($date) {
            $currentDayBsw = $wellBsw->get($date->format('j'));
            return $currentDayBsw ?? 0;
        })->filter()->avg();
    }

    private function getDailyFactOil(CarbonImmutable $date)
    {
        $bswByWell = $this->bsw->map(function ($wellBsw) use ($date) {
            $currentDayBsw = $wellBsw->get($date->format('j'));
            return $currentDayBsw ?? 0;
        });

        return $this->liquid->map(function ($wellLiquid, $wellId) use ($date, $bswByWell) {
            $currentDayLiquid = $wellLiquid->get($date->format('j'));
            if (!$currentDayLiquid) {
                return 0;
            }
            if (empty($bswByWell->get($wellId))) {
                return 0;
            }

            $oilDensity = $this->techMode->get($wellId) ? $this->techMode->get($wellId)->oil_density : 0;
            return $currentDayLiquid['liquid'] * (1 - $bswByWell->get($wellId) / 100) * $oilDensity;
        })->sum();
    }

    private function getDailyFactLiquidAvg(CarbonImmutable $date)
    {
        return $this->liquid->map(function ($wellLiquid) use ($date) {
            return $wellLiquid->take(-3)->avg('liquid');
        })->avg();
    }

    private function getMonthlyFactLiquid(CarbonImmutable $date)
    {
        return $this->liquid->map(function ($wellLiquid) use ($date) {
            return $wellLiquid->map(function ($liquid) {
                return $liquid['liquid'];
            })->sum();
        })->sum();
    }

    private function getMonthlyFactBsw(CarbonImmutable $date)
    {
        $result = $this->bsw->map(function ($wellBsw) use ($date) {
            $wellBsw = $wellBsw->filter();
            return [
                'count' => $wellBsw->count(),
                'sum' => $wellBsw->sum()
            ];
        });
        if ($result->isEmpty()) {
            return 0;
        }
        return $result->sum('sum') / $result->sum('count');
    }

    private function getMonthlyFactOil(CarbonImmutable $date)
    {
        return $this->liquid->map(function ($wellLiquid, $wellId) use ($date) {
            return $wellLiquid->map(function ($liquid, $day) use ($wellId) {
                $wellBsw = $this->bsw->get($wellId);
                if (empty($wellBsw)) {
                    return 0;
                }

                $currentBsw = $wellBsw->get($day);
                if (empty($currentBsw)) {
                    return 0;
                }

                $oilDensity = $this->techMode->get($wellId) ? $this->techMode->get($wellId)->oil_density : 0;
                return $liquid['liquid'] * (1 - $currentBsw / 100) * $oilDensity;
            })->sum();
        })->sum();
    }

    private function getSummaryByTechMergeColumns(): array
    {
        return [
            'wells' => [
                'title' => 'Фонд скважин',
                'code' => 'wells',
            ],
            'work_wells' => [
                'title' => 'Действующий фонд',
                'code' => 'work_wells',
                'parent_column' => 'wells'
            ],
            'daily' => [
                'title' => 'Суточная сводка',
                'code' => 'daily'
            ],
            'daily_plan' => [
                'title' => 'Режим (план)',
                'code' => 'daily_plan',
                'parent_column' => 'daily'
            ],
            'daily_fact' => [
                'title' => 'Факт',
                'code' => 'daily_fact',
                'parent_column' => 'daily'
            ],
            'daily_diff' => [
                'title' => 'Отклонение от режима',
                'code' => 'daily_diff',
                'parent_column' => 'daily'
            ],
            'monthly' => [
                'title' => 'С начала месяца',
                'code' => 'monthly'
            ],
            'monthly_plan' => [
                'title' => 'Режим (план)',
                'code' => 'monthly_plan',
                'parent_column' => 'monthly'
            ],
            'monthly_fact' => [
                'title' => 'Факт',
                'code' => 'monthly_fact',
                'parent_column' => 'monthly'
            ],
            'monthly_diff' => [
                'title' => 'Отклонение от режима',
                'code' => 'monthly_diff',
                'parent_column' => 'monthly'
            ],
        ];
    }

    private function getSummaryByTechColumns(): array
    {
        return [
            [
                'title' => 'Узел',
                'code' => 'tech'
            ],
            [
                'title' => 'Экспл',
                'code' => 'wells_all',
                'parent_column' => 'wells'
            ],
            [
                'title' => 'всего',
                'code' => 'wells_total',
                'parent_column' => 'work_wells'
            ],
            [
                'title' => 'в работе',
                'code' => 'wells_working',
                'parent_column' => 'work_wells'
            ],
            [
                'title' => 'в простое',
                'code' => 'wells_stopped',
                'parent_column' => 'work_wells'
            ],
            [
                'title' => 'Добыча жидкости, м3',
                'code' => 'daily_plan_liquid',
                'parent_column' => 'daily_plan'
            ],
            [
                'title' => 'Добыча жидкости, всего по средним посл. 3 замерам, м3',
                'code' => 'daily_plan_liquid_avg',
                'parent_column' => 'daily_plan'
            ],
            [
                'title' => 'Добыча нефти, т',
                'code' => 'daily_plan_oil',
                'parent_column' => 'daily_plan'
            ],
            [
                'title' => 'Добыча жидкости, м3',
                'code' => 'daily_fact_liquid',
                'parent_column' => 'daily_fact'
            ],
            [
                'title' => 'Добыча жидкости, всего по средним посл. 3 замерам, м3',
                'code' => 'daily_fact_liquid_avg',
                'parent_column' => 'daily_fact'
            ],
            [
                'title' => 'Добыча нефти, т',
                'code' => 'daily_fact_oil',
                'parent_column' => 'daily_fact'
            ],
            [
                'title' => 'Средняя обв-ть, %',
                'code' => 'daily_fact_bsw',
                'parent_column' => 'daily_fact'
            ],
            [
                'title' => 'Добыча жидкости, м3',
                'code' => 'daily_diff_liquid',
                'parent_column' => 'daily_diff'
            ],
            [
                'title' => 'Добыча жидкости, всего по средним посл. 3 замерам, м3',
                'code' => 'daily_diff_liquid_avg',
                'parent_column' => 'daily_diff'
            ],
            [
                'title' => 'Добыча нефти, т',
                'code' => 'daily_diff_oil',
                'parent_column' => 'daily_diff'
            ],
            [
                'title' => 'Добыча жидкости, м3',
                'code' => 'monthly_plan_liquid',
                'parent_column' => 'monthly_plan'
            ],
            [
                'title' => 'Добыча нефти, т',
                'code' => 'monthly_plan_oil',
                'parent_column' => 'monthly_plan'
            ],
            [
                'title' => 'Добыча жидкости, м3',
                'code' => 'monthly_fact_liquid',
                'parent_column' => 'monthly_fact'
            ],
            [
                'title' => 'Добыча нефти, т',
                'code' => 'monthly_fact_oil',
                'parent_column' => 'monthly_fact'
            ],
            [
                'title' => 'Средняя обв-ть, %',
                'code' => 'monthly_fact_bsw',
                'parent_column' => 'monthly_fact'
            ],
            [
                'title' => 'Добыча жидкости, м3',
                'code' => 'monthly_diff_liquid',
                'parent_column' => 'monthly_diff'
            ],
            [
                'title' => 'Добыча нефти, т',
                'code' => 'monthly_diff_oil',
                'parent_column' => 'monthly_diff'
            ],
        ];
    }

    private function getTotalValues(CarbonImmutable $date, array $rows)
    {
        return [
            'rows' => $this->getTotalValuesRows($date, $rows),
            'columns' => $this->getTotalValuesColumns($date),
        ];
    }

    private function getTotalValuesRows(CarbonImmutable $date, array $tableRows): array
    {
        $result = [];
        $indicators = [
            'liquid',
            'bsw',
            'oil'
        ];

        foreach ($indicators as $code) {
            $row = [
                'indicator' => trans('bd.forms.fluid_production_month.' . $code),
                'wells' => $this->wells->count()
            ];

            $indicatorRows = array_filter($tableRows, function ($row) use ($code) {
                return !empty($row['indicator_code']) && $row['indicator_code'] === $code;
            });

            $monthDay = $date->startOfMonth();
            while ($monthDay <= $date) {
                $values = [];

                foreach ($indicatorRows as $indicatorRow) {
                    if (isset($indicatorRow[$monthDay->format('d.m.Y')])) {
                        $values[] = $indicatorRow[$monthDay->format('d.m.Y')]['value'];
                    }
                }

                $values = array_filter($values);

                if ($code === 'bsw') {
                    $value = empty($values) ? 0 : array_sum($values) / count($values);
                } else {
                    $value = array_sum($values);
                }

                $row[$monthDay->format('d.m.Y')] = round($value, 2);

                $monthDay = $monthDay->addDay();
            }

            $result[] = $row;
        }

        return $result;
    }

    private function getTotalValuesColumns(CarbonImmutable $date): array
    {
        $columns = [
            [
                'title' => 'Итоговые показатели',
                'code' => 'indicator'
            ],
            [
                'title' => 'Всего скважин',
                'code' => 'wells'
            ]
        ];

        $monthDay = $date->startOfMonth();
        while ($monthDay <= $date) {
            $columns[] = [
                'code' => $monthDay->format('d.m.Y'),
                'title' => $monthDay->format('j')
            ];
            $monthDay = $monthDay->addDay();
        }

        return $columns;
    }

    protected function saveSingleFieldInDB(array $params): void
    {
        list($wellId, $field) = explode('|', $params['wellId']);
        $date = Carbon::parse($params['field'])->timezone('Asia/Almaty')->toImmutable();
        switch ($field) {
            case 'liquid':
                $this->saveField('prod.meas_liq', 'liquid', $wellId, $date, $params['value']);
                break;
            case 'bsw':
                $this->saveField('prod.meas_water_cut', 'water_cut', $wellId, $date, $params['value']);
                break;
            case 'reason_decline':
                $this->saveField('prod.meas_liq', 'reason_decline', $wellId, $date, $params['value']);
                break;
            case 'gas':
                $row = DB::connection('tbd')
                    ->table('prod.meas_gas_prod')
                    ->where('well', $wellId)
                    ->where('dbeg', '>=', $date->startOfDay())
                    ->where('dbeg', '<=', $date->endOfDay())
                    ->first();

                if (empty($row)) {
                    DB::connection('tbd')
                        ->table('prod.meas_gas_prod')
                        ->insert(
                            [
                                'well' => $wellId,
                                'gas_prod_val' => $params['value'],
                                'dbeg' => $date->startOfDay(),
                                'dend' => $date->endOfDay()
                            ]
                        );
                } else {
                    DB::connection('tbd')
                        ->table('prod.meas_gas_prod')
                        ->where('id', $row->id)
                        ->update(
                            [
                                'gas_prod_val' => $params['value'],
                            ]
                        );
                }
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