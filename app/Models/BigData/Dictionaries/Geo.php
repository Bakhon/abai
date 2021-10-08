<?php

namespace App\Models\BigData\Dictionaries;


use App\Models\BigData\Well;
use App\Models\TBDModel;
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
            ->select('geo')
            ->where('parent', $this->id)
            ->get()
            ->pluck('geo')
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

    public function parentTree(int $id)
    {
        return DB::connection('tbd')->select("
                WITH RECURSIVE dict_orgs(id,geo,parent) AS (
                   SELECT s1.id, 
                          s1.geo, 
                          s1.parent
                     FROM dict.geo_parent s1 
                     WHERE s1.geo = :id AND s1.dend>now() 
                  UNION
                  SELECT s2.id, 
                         s2.geo, 
                         s2.parent
                    FROM dict.geo_parent s2, dict_orgs s1 
                   WHERE s2.geo = s1.parent AND s2.dend>now()
                  )
                SELECT * FROM dict_orgs ",['id'=>$id]);
    }

    public function getWellName(int $id)
    {
        return Geo::select('name_ru')->find($id);
    }

    public function getItems(array $ids)
    {
        return Geo::whereIn('id',$ids)->get();
    }
}
