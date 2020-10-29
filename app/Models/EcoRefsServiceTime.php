<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsServiceTime extends Model
{
    protected $fillable = [
        'company_id', 'equip_id', 'avg_serv_life'
    ];

    public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId','id','company_id')->withDefault();
    }
    public function equip()
    {
        return $this->hasOne('App\Models\EcoRefsEquipId','id','equip_id')->withDefault();
    }
}
