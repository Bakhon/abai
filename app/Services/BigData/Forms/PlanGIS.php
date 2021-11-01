<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Org;
use App\Services\BigData\DictionaryService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PlanGIS extends TableForm
{
    protected $configurationFileName = 'plan_g_i_s';

    public function getResults(): array
    {
        $filter = json_decode($this->request->get('filter'));
        if (empty($filter->date) || empty($filter->date_to)) {
            return ['rows' => []];
        }

        if ($this->request->get('type') !== 'org') {
            throw new \Exception(trans('bd.select_dzo_ngdu'));
        }

        $org = $this->getOrganization();
        $orgChild = Org::find($this->request->get('id'));
        $orgChildren = $org->children()->orderBy('name_ru')->get();

        if(!$this->isOrganization($orgChild) && $orgChild->parentOrg->type->code === 'SUBC') {
            $tmp[] = $orgChild;
            $orgChildren = collect($tmp);
        }

        $columns = $this->getColumns($filter, $org, $orgChildren);

        $rows = $this->getRows($filter, $org, $orgChildren);

        return [
            'columns' => $columns['columns'],
            'merge_columns' => $columns['merge_columns'],
            'complicated_header' => $this->tableHeaderService->getHeader(
                $columns['columns'],
                $columns['merge_columns']
            ),
            'rows' => $rows
        ];
    }

    private function getOrganization(): Org
    {
        $org = Org::find($this->request->get('id'));
        if (!$org->type) {
            throw new \Exception(trans('bd.select_dzo'));
        }

        if ($this->isOrganization($org)) {
            return $org;
        }

        if ($this->isOrganization($org->parentOrg)) {
            return $org->parentOrg;
        }

        throw new \Exception(trans('bd.select_dzo'));
    }

    private function isOrganization($org) {
        return ($org->type->code === 'SUBC' || $org->parentOrg->name_short_ru === 'ММГ');
    }

    private function getColumns($filter, $org, $children)
    {
        $columns = [
            [
                'code' => 'num',
                'title' => '№',
                'type' => 'text',
                'is_editable' => false
            ],
            [
                'code' => 'name',
                'title' => trans('bd.forms.plan_g_i_s.name'),
                'type' => 'text',
                'is_editable' => false
            ]
        ];

        $date = Carbon::parse($filter->date);
        $dateTo = Carbon::parse($filter->date_to);

        $childCodesByMonths = [];
        while ($date < $dateTo) {
            $mergeColumns['date_' . $date->format('n_Y')] = [
                'code' => 'date_' . $date->format('n_Y'),
                'title' => trans('app.months.' . $date->format('n')) . ' ' . $date->format('Y')
            ];

            $childCodes = [];
            foreach ($children as $child) {
                $code = "date_{$date->format('n_Y')}_" . $child->id;
                $childCodes[] = $code;
                $childCodesByMonths[$child->id][] = $code;
                $columns[] = [
                    'code' => $code,
                    'title' => $child->name_short_ru,
                    'parent_column' => 'date_' . $date->format('n_Y'),
                    'type' => 'integer',
                    'is_editable' => $org->name_short_ru === 'ММГ' ? false : true
                ];
            }

            $date->addMonth();
        }

        $mergeColumns['total'] = [
            'code' => 'total',
            'title' => trans('bd.forms.plan_g_i_s.total_period')
        ];

        $totalColumnCodes = [];
        $totalFormula = [];
        foreach ($children as $child) {
            $code = $child->id . '_total';
            $totalColumnCodes[] = $code;
            $formula = $this->getSumFormula($childCodesByMonths[$child->id]);
            $totalFormula[] = $formula;
            if(count($children) <= 1) continue;

            $columns[] = [
                'code' => $code,
                'title' => $child->name_short_ru,
                'parent_column' => 'total',
                'type' => 'calc',
                'formula' => $formula
            ];
        }

        $columns[] = [
            'code' => 'dzo_total',
            'title' => trans('bd.forms.plan_g_i_s.total'),
            'parent_column' => 'total',
            'type' => 'calc',
            'formula' => implode(' + ', $totalFormula)
        ];

        return [
            'columns' => $columns,
            'merge_columns' => $mergeColumns
        ];
    }

    private function getSumFormula($codes)
    {
        return collect($codes)
            ->map(function ($code) {
                return '$' . $code . '$';
            })
            ->join(' + ');
    }

    private function getRows(\stdClass $filter, Org $org, Collection $orgChildren): array
    {
        $plans = DB::connection('tbd')
            ->table('prod.plan_gis')
            ->whereIn('org', array_merge([$org->id], $orgChildren->pluck('id')->toArray()))
            ->get();

        $dictionaryService = app()->make(DictionaryService::class);
        $gisTypes = $dictionaryService->get('plan_gis_type');

        $rows = [];
        foreach ($gisTypes as $gisType) {
            $row = [
                'id' => $gisType['id'],
                'num' => ['value' => $gisType['id']],
                'name' => ['value' => $gisType['name']]
            ];
            $date = Carbon::parse($filter->date);
            $dateTo = Carbon::parse($filter->date_to);

            while ($date < $dateTo) {
                $row = array_merge(
                    $row,
                    $this->getPlansByDateAndOrg($org, $orgChildren, $plans, $date, $gisType['id'])
                );
                $date->addMonth();
            }

            $rows[] = $row;
        }
        $rows = array_slice($rows, 1);
        usort($rows, function($a, $b) {return $a['num'] > $b['num'];});

        for($i = 0; $i < count($rows); $i++) {
            $rows[$i]['num']['value'] = $i+1;
        }
        return $rows;
    }

    private function getPlansByDateAndOrg(
        Org $org,
        Collection $orgChildren,
        Collection $plans,
        Carbon $date,
        int $gisTypeId
    ) {
        $row = [];
        foreach ($orgChildren as $child) {
            $plan = $plans->where('month', $date->format('n'))
                ->where('year', $date->format('Y'))
                ->where('org', $child->id)
                ->where('plan_gis_type', $gisTypeId)
                ->first();

            $row["date_{$date->format('n_Y')}_" . $child->id] = ['value' => $plan ? $plan->count : null];
        }

        $plan = $plans->where('month', $date->format('n'))
            ->where('year', $date->format('Y'))
            ->where('org', $org->id)
            ->where('plan_gis_type', $gisTypeId)
            ->first();

        $row["date_{$date->format('n_Y')}_" . $org->id] = ['value' => $plan ? $plan->count : null];
        return $row;
    }

    protected function saveSingleFieldInDB(array $params): void
    {
        list($date, $month, $year, $org) = explode('_', $params['field']);

        $plan = DB::connection('tbd')
            ->table('prod.plan_gis')
            ->where('org', $org)
            ->where('plan_gis_type', $params['wellId'])
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if ($plan) {
            DB::connection('tbd')
                ->table('prod.plan_gis')
                ->where('id', $plan->id)
                ->update(['count' => $params['value']]);
        } else {
            DB::connection('tbd')
                ->table('prod.plan_gis')
                ->insert(
                    [
                        'org' => $org,
                        'plan_gis_type' => $params['wellId'],
                        'month' => $month,
                        'year' => $year,
                        'count' => $params['value']
                    ]
                );
        }
    }

}