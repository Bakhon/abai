<?php

namespace App\Models\BigData;

use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Dictionaries\WellCategory;
use App\Models\BigData\Dictionaries\WellStatus;
use App\Models\TBDModel;

class Well extends TBDModel
{
    const WELL_STATUS_ACTIVE = 3;
    const WELL_STATUS_PERIODIC_EXPLOITATION = 7;
    const WELL_ACTIVE_STATUSES = [
        self::WELL_STATUS_ACTIVE,
        self::WELL_STATUS_PERIODIC_EXPLOITATION
    ];

    const WELL_CATEGORY_OIL = 1;

    protected $table = 'tbdi.well';
    protected $guarded = ['id'];

    public function geo()
    {
        return $this->belongsToMany(Geo::class, 'tbdi.well_geo', 'well_id', 'geo_id');
    }

    public function orgs()
    {
        return $this->belongsToMany(Org::class, 'tbdi.well_org', 'well_id', 'org_id');
    }

    public function techs()
    {
        return $this->belongsToMany(Tech::class, 'tbdi.well_tech', 'well_id', 'tech_id');
    }

    public function status()
    {
        return $this->belongsToMany(WellStatus::class, 'tbdi.well_status', 'well_id', 'well_status_type_id');
    }

    public function category()
    {
        return $this->belongsToMany(WellCategory::class, 'tbdi.well_category', 'well_id', 'well_category_type_id');
    }


    public function scopeActive($query, $date)
    {
        $query->whereHas(
            'status',
            function ($query) use ($date) {
                $query->where('dbeg', '<=', $date)
                    ->where('dend', '>=', $date)
                    ->whereIn('tbdi.well_status.well_status_type_id', self::WELL_ACTIVE_STATUSES);
            }
        );
        $query->whereHas(
            'category',
            function ($query) use ($date) {
                $query->where('dbeg', '<=', $date)
                    ->where('dend', '>=', $date)
                    ->where('tbdi.well_category.well_category_type_id', self::WELL_CATEGORY_OIL);
            }
        );

        return $query;
    }
}
