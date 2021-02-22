<?php

namespace App\Models\BigData\Dictionaries;

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
