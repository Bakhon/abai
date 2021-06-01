<?php

namespace App\Models\BigData;

use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Dictionaries\TubeNom;
use App\Models\BigData\Dictionaries\WellCategory;
use App\Models\BigData\Dictionaries\WellExplType;
use App\Models\BigData\Dictionaries\WellStatus;
use App\Models\BigData\Dictionaries\WellType;
use App\Models\TBDModel;
use Carbon\Carbon;

class Well extends TBDModel
{
    const WELL_STATUS_ACTIVE = 3;
    const WELL_STATUS_PERIODIC_EXPLOITATION = 7;
    const WELL_ACTIVE_STATUSES = [
        self::WELL_STATUS_ACTIVE,
        self::WELL_STATUS_PERIODIC_EXPLOITATION
    ];

    const WELL_CATEGORY_OIL = 1;

    protected $table = 'dict.well';
    protected $guarded = ['id'];

    public function geo()
    {
        return $this->belongsToMany(Geo::class, 'prod.well_geo', 'well', 'geo');
    }

    public function orgs()
    {
        return $this->belongsToMany(Org::class, 'prod.well_org', 'well', 'org');
    }

    public function techs()
    {
        return $this->belongsToMany(Tech::class, 'prod.well_tech', 'well', 'tech');
    }

    public function status()
    {
        return $this->belongsToMany(WellStatus::class, 'prod.well_status', 'well', 'status');
    }

    public function category()
    {
        return $this->belongsToMany(WellCategory::class, 'prod.well_category', 'well', 'category');
    }

    public function well_type()
    {
        return $this->belongsToMany(WellType::class, 'dict.well', 'id', 'well_type');
    }

    public function well_expl()
    {
        return $this->belongsToMany(WellExplType::class, 'prod.well_expl', 'well', 'expl');
    }
    public function tube_nom()
    {
        return $this->belongsToMany(TubeNom::class, 'prod.well_constr', 'well', 'casing_nom');
    }



    public function scopeActive($query, $date)
    {
        $query->whereHas(
            'status',
            function ($query) use ($date) {
                $query->where('dbeg', '<=', $date)
                    ->where('dend', '>=', $date)
                    ->whereIn('prod.well_status.status', self::WELL_ACTIVE_STATUSES);
            }
        );
        $query->whereHas(
            'category',
            function ($query) use ($date) {
                $query->where('dbeg', '<=', $date)
                    ->where('dend', '>=', $date)
                    ->where('prod.well_category.category', self::WELL_CATEGORY_OIL);
            }
        );

        return $query;
    }
}
