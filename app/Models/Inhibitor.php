<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inhibitor extends Model
{
    protected $guarded = ['id'];

    public function prices()
    {
        return $this->hasMany(InhibitorPrice::class);
    }

    public function omguhe()
    {
        return $this->hasMany(\App\Models\ComplicationMonitoring\OmgUHE::class);
    }
}
