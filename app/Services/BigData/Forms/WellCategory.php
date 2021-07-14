<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\BigData\SubmitFormException;
use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\WellCategory as WellCategoryDictionary;
use App\Models\BigData\Well;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class WellCategory extends PlainForm
{

    const GEO_HORIZON_TYPE = 4;

    const INJECTION_WELL = 2;

    const WELL_CATEGORIES = [
        Well::WELL_CATEGORY_OIL,
        Well::WELL_CATEGORY_INJECTION
    ];

    const WELL_ACTIVE_STATUSES = [
        Well::WELL_STATUS_ACTIVE,
        Well::WELL_STATUS_PERIODIC_EXPLOITATION,
        Well::WELL_STATUS_INACTIVE,
    ];

    protected $configurationFileName = 'well_category';

    public function submit(): array
    {
        DB::connection('tbd')->beginTransaction();

        try {
            $dbQuery = DB::connection('tbd')->table($this->params()['table']);

            $oldCategory = $dbQuery->where('well', $this->request->get('well'))
                ->where('dend', Well::DEFAULT_END_DATE)
                ->first();
            if ($oldCategory !== null) {
                $dbQuery->where('id', $oldCategory->id)->update(
                    [
                        'dend' => $this->request->get('dbeg')
                    ]
                );
            }

            $data = $this->request->except('org');
            $data['dend'] = Well::DEFAULT_END_DATE;

            if (!empty($data['id'])) {
                $id = $dbQuery->where('id', $data['id'])->update($data);
            } else {
                $id = $dbQuery->insertGetId($data);
            }

            $this->saveOrganization();

            DB::connection('tbd')->commit();
            return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
        } catch (\Exception $e) {
            DB::connection('tbd')->rollBack();
            throw new SubmitFormException($e->getMessage());
        }
    }

    public function saveOrganization()
    {
        $dbQuery = DB::connection('tbd')->table('prod.well_org');

        $oldOrg = $dbQuery
            ->where('well', $this->request->get('well'))
            ->where('dend', '<', Well::DEFAULT_END_DATE)
            ->orderByDesc('dend')
            ->first();

        if ($oldOrg && $oldOrg->org === $this->request->get('org')) {
            return;
        }

        $dbQuery->insert(
            [
                'org' => $this->request->get('org'),
                'well' => $this->request->get('well'),
                'dbeg' => $this->request->get('dbeg'),
                'dend' => Well::DEFAULT_END_DATE
            ]
        );

        if ($oldOrg !== null) {
            $dbQuery->where('id', $oldOrg->id)->update(
                [
                    'dend' => $this->request->get('dbeg')
                ]
            );
        }
    }

    public function getCalculatedFields(int $wellId, array $values): array
    {
        if (empty($values['dbeg'])) {
            return [];
        }

        $result = DB::connection('tbd')
            ->table('prod.well_category as wc')
            ->select('c.name_ru as category')
            ->where('wc.dbeg', '<=', Carbon::parse($values['dbeg'])->timezone('Asia/Almaty')->endOfDay())
            ->where('wc.well', $wellId)
            ->leftJoin('dict.well_category_type as c', 'c.id', 'wc.category')
            ->orderBy('wc.dbeg', 'desc')
            ->first();

        if (empty($result)) {
            return [];
        }

        return [
            'old_category' => $result->category
        ];
    }

    public function getUpdatedFields(int $wellId, array $values): array
    {
        if (empty($values['dbeg']) || empty($values['category'])) {
            return [];
        }

        $category = WellCategoryDictionary::find($values['category']);
        if (!in_array($category->code, self::WELL_CATEGORIES)) {
            return [];
        }

        $well = Well::find($wellId);
        $otherWells = $this->getOtherWells(
            $well,
            $category,
            Carbon::parse($values['dbeg'])->timezone('Asia/Almaty')
        );

        return [
            'connected_wells' => [
                'rows' => $otherWells,
                'columns' => $this->getColumns($category)
            ]
        ];
    }

    private function getOtherWells(Well $well, WellCategoryDictionary $category, Carbon $date): ?array
    {
        $horizon = $this->getWellHorizon($well);
        if (empty($horizon)) {
            return [];
        }

        $geoIds = [$horizon->id];
        $horizonChildren = $horizon->descendants();
        if (!empty($horizonChildren)) {
            $geoIds = array_merge($geoIds, $horizonChildren->pluck('id')->toArray());
        }

        $otherWellsQuery = DB::connection('tbd')
            ->table('dict.geo as g')
            ->leftJoin('prod.well_geo as wg', 'wg.geo', 'g.id')
            ->leftJoin('dict.well as w', 'w.id', 'wg.well')
            ->whereIn('g.id', $geoIds)
            ->where('wg.dbeg', '<=', $date)
            ->where('wg.dend', '>=', $date)
            ->leftJoin('prod.well_category as wc', 'wc.well', 'w.id')
            ->where('wc.dbeg', '<=', $date)
            ->where('wc.dend', '>=', $date)
            ->leftJoin('dict.well_category_type as wct', 'wct.id', 'wc.category')
            ->leftJoin('prod.well_status as ws', 'ws.well', 'w.id')
            ->whereIn('ws.status', self::WELL_ACTIVE_STATUSES)
            ->where('ws.dbeg', '<=', $date)
            ->where('ws.dend', '>=', $date)
            ->leftJoin('dict.well_status_type as wst', 'wst.id', 'ws.status');

        if ($category->code === Well::WELL_CATEGORY_OIL) {
            $otherWellsQuery = $this->selectInjectionWellsFields($otherWellsQuery, $date);
        } else {
            $otherWellsQuery = $this->selectOilWellsFields($otherWellsQuery, $date);
        }

        $result = collect($otherWellsQuery->get())->map(
            function ($item) {
                $item->checked = !empty($item->checked);
                return $item;
            }
        );

        return $result->toArray();
    }

    private function getColumns(WellCategoryDictionary $category): array
    {
        $columns = [
            [
                "code" => "well",
                "title" => trans("bd.forms.well_category.uwi_number")
            ],
            [
                "code" => "status",
                "title" => trans("bd.forms.well_category.status")
            ]
        ];

        if ($category->code === Well::WELL_CATEGORY_OIL) {
            $columns[] = [
                "code" => "water_inj",
                "title" => trans("bd.forms.well_category.water_inj_v")
            ];
        } else {
            $columns[] = [
                "code" => "liquid_debit",
                "title" => trans("bd.forms.well_category.water_l")
            ];
            $columns[] = [
                "code" => "oil_debit",
                "title" => trans("bd.forms.well_category.water_v")
            ];
        }

        $columns[] = [
            "code" => "category",
            "title" => trans("bd.forms.well_category.well_cat")
        ];

        return $columns;
    }

    private function getWellHorizon(Well $well): ?Geo
    {
        $horizon = $well->geo->where('geo_type', self::GEO_HORIZON_TYPE)->first();

        if (!empty($horizon)) {
            return $horizon;
        }

        foreach ($well->geo as $geo) {
            $parents = $geo->ancestors();
            foreach ($parents as $parent) {
                if ($parent->geo_type === self::GEO_HORIZON_TYPE) {
                    $horizon = $parent;
                    break;
                }
            }
        }

        return $horizon;
    }

    private function selectInjectionWellsFields(Builder $query, Carbon $date)
    {
        return $query->select(
            'w.id as well_id',
            'w.uwi as well',
            'wst.name_ru as status',
            'wct.name_ru as category',
            'wri.id as checked',
            DB::raw(
                '(select water_inj_val from prod.meas_water_inj as mwi where mwi.well = w.id and mwi.dbeg <= \'' . $date->format(
                    'Y-m-d'
                ) . '\' order by mwi.dbeg desc limit 1) as water_inj'
            )
        )
            ->leftJoin('prod.well_react_infl as wri', 'wri.well_influencing', 'w.id')
            ->leftJoin('dict.well_category_type as c', 'c.id', 'wc.category')
            ->whereIn('c.code', [Well::WELL_CATEGORY_INJECTION]);
    }

    private function selectOilWellsFields(Builder $query, Carbon $date)
    {
        return $query->select(
            'wg.id as well_id',
            'w.uwi as well',
            'wst.name_ru as status',
            'wct.name_ru as category',
            'wri.id as checked',
            DB::raw(
                '(select liquid from prod.meas_liq as ml where ml.well = w.id and ml.dbeg <= \'' . $date->format(
                    'Y-m-d'
                ) . '\' order by ml.dbeg desc limit 1) as liquid_debit'
            )
        )
            ->leftJoin('prod.well_react_infl as wri', 'wri.well_reacting', 'w.id')
            ->leftJoin('dict.well_category_type as c', 'c.id', 'wc.category')
            ->whereIn('c.code', [Well::WELL_CATEGORY_OIL]);
    }

    private function isValidDate($wellId, $dbeg): bool
    {
        $dend = DB::connection('tbd')
            ->table('prod.well_category')
            ->where('well', $wellId)
            ->where('dend', '<', Well::DEFAULT_END_DATE)
            ->orderBy('dend', 'desc')
            ->get('dend')
            ->first();

        return $dbeg >= $dend->dend;
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDate($this->request->get('well'), $this->request->get('dbeg'))) {
            $errors['dbeg'] = trans('bd.validation.dbeg');
        }

        return $errors;
    }

}