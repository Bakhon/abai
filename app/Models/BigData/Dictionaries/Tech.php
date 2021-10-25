<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\BigData\Well;
use App\Models\TBDModel;
use Illuminate\Support\Facades\DB;

class Tech extends TBDModel
{
    protected $table = 'dict.tech';

    const TYPE_ZU = 'MS';
    const TYPE_GU = 'GU';
    const TYPE_GZU = 'GMS';
    const TYPE_AGZU = 'AGMS';
    const TYPE_SPGU = 'SSU';
    const TYPE_KNS = 'GPST';
    const TYPE_BKNS = 'MGPST';
    const TYPE_OPPS = 'OPPS';
    const TYPE_OTU = 'OTU';
    const TYPE_WIDM = 'WIDM';
    const TYPE_WDM = 'WDM';

    public function parentItem()
    {
        return $this->belongsTo(Tech::class, 'parent', 'id');
    }

    public function children()
    {
        return $this->hasMany(Tech::class, 'parent', 'id');
    }

    public function wells()
    {
        return $this->belongsToMany(Well::class, 'prod.well_tech', 'tech', 'well');
    }

    public function type()
    {
        return $this->belongsTo(TechType::class, 'tech_type');
    }

    public function parentTree(int $id)
    {
       return DB::connection('tbd')->select(
            "WITH RECURSIVE dict_techs(id,name,parent) AS (
                              SELECT s1.id, 
                                     (CASE WHEN s1.name_short_ru!='' THEN s1.name_short_ru ELSE s1.name_ru END) as name_ru, 
                                     s1.parent
                                FROM dict.tech s1 
                               WHERE id = :id AND s1.dend>now() 
                              UNION
                              SELECT s2.id, 
                                (CASE WHEN s2.name_short_ru!='' THEN s2.name_short_ru ELSE s2.name_ru END) as name_ru, 
                                s2.parent
                                FROM dict.tech s2, dict_techs s1 
                               WHERE s2.id = s1.parent AND s2.dend>now()
                          )
                    SELECT name FROM dict_techs", ['id' => $id]);
    }
}
