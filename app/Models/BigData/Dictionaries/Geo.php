<?php

namespace App\Models\BigData\Dictionaries;


use App\Models\BigData\Well;
use App\Models\TBDModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Geo extends TBDModel
{
    protected $table = 'dict.geo';

    public function type()
    {
        return $this->belongsTo(GeoType::class, 'geo_type', 'id');
    }

    public function parent()
    {
        $result = DB::connection($this->connection)
            ->table('dict.geo_parent')
            ->select('parent')
            ->where('geo', $this->id)
            ->first();

        return $result ? Geo::find($result->parent) : null;
    }

    public function firstParent()
    {
        return $this->hasMany(GeoParent::class, 'geo', 'id');
    }

    public function children()
    {
        $ids = DB::connection($this->connection)
            ->table('dict.geo_parent')
            ->select('geo_id')
            ->where('parent', $this->id)
            ->get()
            ->pluck('geo_id')
            ->toArray();

        return !empty($ids) ? Geo::whereIn('id', $ids)->get() : null;
    }

    public function wells()
    {
        return $this->belongsToMany(Well::class, 'prod.well_geo', 'geo', 'well_id');
    }


    public function ancestors()
    {
        $result = collect();

        $item = $this;

        while (true) {
            $parent = $item->parent();
            if (empty($parent)) {
                break;
            }

            $result->push($parent);
            $item = $parent;
        }

        return $result;
    }


    public function descendants()
    {
        if (Cache::has('bd_geo_children_' . $this->id)) {
            return Cache::get('bd_geo_children_' . $this->id);
        }
        $result = $this->children();
        if (!empty($result)) {
            $result->each(
                function ($child) use (&$result) {
                    $result->merge($child->descendants());
                }
            );
        }

        Cache::put('bd_geo_children_' . $this->id, $result);
        return $result;
    }
}
