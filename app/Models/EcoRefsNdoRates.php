<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsNdoRates extends Model
{
    protected $fillable = [
        'company_id', 'ndo_rates'
    ];

    public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId','id','company_id')->withDefault();
    }
}
