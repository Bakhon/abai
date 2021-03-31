<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\TBDModel;
use Illuminate\Support\Facades\DB;

class Org extends TBDModel
{
    protected $table = 'tbdi.org';

    //relations

    public function parentOrg()
    {
        return $this->belongsTo(Org::class, 'parent_id');
    }

    public function wells()
    {
        return $this->belongsToMany(\App\Models\BigData\Well::class, 'tbdi.well_org', 'org_id', 'well_id');
    }

    public function type()
    {
        return $this->belongsTo(OrgType::class, 'type_id');
    }


    public function fieldIds()
    {
        $result = DB::connection('tbd')
            ->table('tbdi.org as org')
            ->select('org.id', 'df.field as field')
            ->leftJoin('tbdic.dzo_field as df', 'org.id', '=', 'df.dzo')
            ->where('org.id', '=', $this->id)
            ->whereNotNull('field')
            ->get()
            ->pluck('field')
            ->toArray();

        return $result;
    }
}
