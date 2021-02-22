<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\TBDModel;
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
}
