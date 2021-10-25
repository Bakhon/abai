<?php

namespace App\Models\BigData;

use App\Models\BigData\Dictionaries\BottomHoleType;
use App\Models\BigData\Dictionaries\GdisConclusion;
use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Dictionaries\TubeNom;
use App\Models\BigData\Dictionaries\WellCategory;
use App\Models\BigData\Dictionaries\WellExplType;
use App\Models\BigData\Dictionaries\WellStatus;
use App\Models\BigData\Dictionaries\WellType;
use App\Models\BigData\Dictionaries\Zone;
use App\Models\TBDModel;

class Well extends TBDModel
{
    const WELL_STATUS_ACTIVE = 3;
    const WELL_STATUS_PERIODIC_EXPLOITATION = 7;
    const WELL_STATUS_INACTIVE = 8;

    const WELL_ACTIVE_STATUSES = [
        self::WELL_STATUS_ACTIVE,
        self::WELL_STATUS_PERIODIC_EXPLOITATION
    ];

    const WELL_CATEGORY_INJECTION = 'INJ';
    const WELL_CATEGORY_OIL = 'OIL';

    const DEFAULT_END_DATE = '3333-12-31 00:00:00+06';

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

    public function wellType()
    {
        return $this->belongsToMany(WellType::class, 'dict.well', 'id', 'well_type');
    }

    public function wellExpl()
    {
        return $this->belongsToMany(WellExplType::class, 'prod.well_expl', 'well', 'expl');
    }

    public function tubeNom()
    {
        return $this->belongsToMany(TubeNom::class, 'prod.well_constr', 'well', 'casing_nom');
    }

    public function spatialObject()
    {
        return $this->belongsToMany(SpatialObject::class, 'dict.well', 'id', 'whc');
    }

    public function spatialObjectBottom()
    {
        return $this->belongsToMany(SpatialObject::class, 'dict.well', 'id', 'bottom_coord');
    }

    public function bottomHole()
    {
        return $this->belongsToMany(BottomHoleType::class, 'prod.bottom_hole', 'well', 'bottom_hole_type');
    }

    public function labResearchValue()
    {
        return $this->belongsToMany(LabResearchValue::class, 'prod.lab_research', 'well', 'id', 'id', 'research');
    }

    public function wellPerfActual()
    {
        return $this->belongsToMany(WellPerfActual::class, 'prod.well_perf', 'well', 'id');
    }

    public function techModeProdOil()
    {
        return $this->hasMany(TechModeProdOil::class, 'well', 'id');
    }

    public function techModeInj()
    {
        return $this->hasMany(TechModeInj::class, 'well', 'id');
    }

    public function measLiq()
    {
        return $this->hasMany(MeasLiq::class, 'well', 'id');
    }

    public function measWaterCut()
    {
        return $this->hasMany(MeasWaterCut::class, 'well', 'id');
    }

    public function measLiqInjection()
    {
        return $this->hasMany(MeasLiqInjection::class, 'well', 'id');
    }

    public function wellWorkover()
    {
        return $this->hasMany(WellWorkover::class, 'well', 'id');
    }

    public function wellTreatment()
    {
        return $this->hasMany(WellTreatment::class, 'well', 'id');
    }

    public function gdisCurrent()
    {
        return $this->hasMany(GdisCurrent::class, 'well', 'id');
    }

    public function gdisConclusion()
    {
        return $this->belongsToMany(GdisConclusion::class, 'prod.gdis_current', 'well', 'id');
    }

    public function gdisCurrentValue()
    {
        return $this->belongsToMany(GdisCurrentValue::class, 'prod.gdis_current', 'well', 'id', 'id', 'gdis_curr');
    }

    public function gdisComplex()
    {
        return $this->belongsToMany(GdisComplexValue::class, 'prod.gdis_complex', 'well', 'id', 'id', 'gdis_complex');
    }

    public function gis()
    {
        return $this->hasMany(Gis::class, 'well', 'id');
    }

    public function zone()
    {
        return $this->belongsToMany(Zone::class, 'prod.well_zone', 'well', 'id');
    }

    public function wellReact()
    {
        return $this->hasMany(WellReactInfl::class, 'well_reacting', 'id');
    }

    public function gtm()
    {
        return $this->hasMany(Gtm::class, 'well', 'id');
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

        return $query;
    }

    public function getRelationTech(string $date)
    {
       return $this->techs()
                    ->wherePivot('dend', '>',$date)
                    ->withPivot('dend', 'dbeg', 'tap as tap')
                    ->orderBy('pivot_dbeg', 'desc')
                    ->first();
    }

    public function getRelationOrg(string $date)
    {
        return $this->orgs()
                    ->wherePivot('dend', '>', $date)
                    ->withPivot('dend', 'dbeg')
                    ->orderBy('pivot_dbeg', 'desc')
                    ->first();
    }

    public function getGeo(string $date)
    {
       return  $this->geo()->wherePivot('dend', '>', $date)
            ->wherePivot('dbeg', '<=', $date)
            ->withPivot('dend', 'dbeg')
            ->first();
    }

    /**
     * @param int $well_id
     * @param string|null $date
     * @return array|null
     */
    public function wellData(int $well_id,?string $date) : ?object
    {
        $query = DailyProdOil::where('well','=',$well_id);
        if($date)
        {
            $query = $query->where('date','>=',$date);
        }

        $query = $query->select('date','liquid','wcut','oil','hdin')
                          ->orderBy('date')->get();
        return $query;
    }
}
