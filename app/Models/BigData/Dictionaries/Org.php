<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\BigData\Well;
use App\Models\TBDModel;
use Illuminate\Support\Facades\DB;

class Org extends TBDModel
{
    protected $table = 'dict.org';

    //relations

    public function parentOrg()
    {
        return $this->belongsTo(Org::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(Org::class, 'parent');
    }

    public function wells()
    {
        return $this->belongsToMany(Well::class, 'prod.well_org', 'org', 'well');
    }

    public function type()
    {
        return $this->belongsTo(OrgType::class, 'org_type');
    }


    public function fieldIds()
    {
        $result = DB::connection('tbd')
            ->table('dict.org as org')
            ->select('org.id', 'df.field as field')
            ->leftJoin('dict.dzo_field as df', 'org.id', '=', 'df.dzo')
            ->where('org.id', '=', $this->id)
            ->whereNotNull('field')
            ->get()
            ->pluck('field')
            ->toArray();

        return $result;
    }

    public function parentTree(int $id)
    {
        return DB::connection('tbd')->select("
                WITH RECURSIVE dict_orgs(id,name,parent,code) AS (
                     SELECT s1.id, 
                            (CASE WHEN s1.name_short_ru!='' THEN s1.name_short_ru ELSE s1.name_ru END) as name_ru, 
                            s1.parent,
                            s1.code
                       FROM dict.org s1 
                      WHERE id = :id AND s1.dend>now() 
                    UNION
                      SELECT s2.id, 
                            (CASE WHEN s2.name_short_ru!='' THEN s2.name_short_ru ELSE s2.name_ru END) as name_ru, 
                            s2.parent,
                            s2.code
                       FROM dict.org s2, dict_orgs s1 
                      WHERE s2.id = s1.parent AND s2.dend>now()
                 )
                 SELECT id,name,parent,code FROM dict_orgs",['id'=>$id]);
    }
}
