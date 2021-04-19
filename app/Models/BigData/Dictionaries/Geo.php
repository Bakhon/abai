<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\BigData\Well;
use App\Models\TBDModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Geo extends TBDModel
{
    protected $table = 'dict.geo';

    public function parent()
    {
        $result = DB::connection($this->connection)
            ->table('dict.geo_parent')
            ->select('parent')
            ->where('geo_id', $this->id)
            ->first();

        return $result ? Geo::find($result->parent) : null;
    }

    public function children()
    {
        return $this->hasMany(Geo::class, 'parent_id', 'id');
    }

    public function wells()
    {
        return $this->belongsToMany(Well::class, 'prod.well_geo', 'geo_id', 'well_id');
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
        $result = $this->children;
        $this->children->each(
            function ($child) use (&$result) {
                $result->merge($child->descendants());
                $result->merge($child->descendants());
            }
        );
        Cache::put('bd_geo_children_' . $this->id, $result);
        return $result;
    }
}
