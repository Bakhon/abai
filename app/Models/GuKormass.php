<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuKormass extends Model
{
    public function kormass()
    {
        return $this->hasOne('App\Models\Kormass','id','kormass_id')->withDefault();
    }
}
