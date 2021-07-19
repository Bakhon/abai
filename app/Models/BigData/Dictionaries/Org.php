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
        return $this->belongsTo(Org::class, 'parent_id');
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
}
