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


    public function fieldIds()
    {
        $result = DB::connection('tbd')
            ->table('tbdi.org as org')
            ->select('tbdi.id', 'df.field as field')
            ->leftJoin('tbdi.dzo_field as df', 'org.id', '=', 'df.dzo')
            ->where('org.id', '=', $this->id)
            ->whereNotNull('field')
            ->get()
            ->pluck('field')
            ->toArray();

        return $result;
    }
}
