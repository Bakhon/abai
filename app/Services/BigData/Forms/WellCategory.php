<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Well;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class WellCategory extends PlainForm
{

    const GEO_HORIZON_TYPE = 4;

    const OIL_WELL = 13;
    const INJECTION_WELL = 2;
    const STEAM_INJECTION_WELL = 11;

    const WELL_CATEGORIES = [
        Well::WELL_CATEGORY_OIL,
        Well::WELL_CATEGORY_INJECTION,
        Well::WELL_CATEGORY_STEAM_INJECTION
    ];

    const WELL_ACTIVE_STATUSES = [
        Well::WELL_STATUS_ACTIVE,
        Well::WELL_STATUS_PERIODIC_EXPLOITATION,
        Well::WELL_STATUS_INACTIVE,
    ];

    protected $configurationFileName = 'well_category';

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
        if (!in_array($values['category'], self::WELL_CATEGORIES)) {
            return [];
        }

        $well = Well::find($wellId);
        $otherWells = $this->getOtherWells(
            $well,
            $values['category'],
            Carbon::parse($values['dbeg'])->timezone('Asia/Almaty')
        );

        return [
            'connected_wells' => [
                'rows' => $otherWells,
                'columns' => $this->getColumns($values['category'])
            ]
        ];
    }

    private function getOtherWells(Well $well, int $category, Carbon $date): ?array
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

        if ($category === Well::WELL_CATEGORY_OIL) {
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

    private function getColumns(int $category): array
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

        if ($category === Well::WELL_CATEGORY_OIL) {
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
            ->whereIn('wc.category', [Well::WELL_CATEGORY_INJECTION, Well::WELL_CATEGORY_STEAM_INJECTION])
            ->leftJoin('prod.well_react_infl as wri', 'wri.well_influencing', 'w.id');
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
            ->where('wc.category', Well::WELL_CATEGORY_OIL)
            ->leftJoin('prod.well_react_infl as wri', 'wri.well_reacting', 'w.id');
    }

}