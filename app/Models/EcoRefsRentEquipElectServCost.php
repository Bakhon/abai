<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsRentEquipElectServCost extends Model
{
    protected $fillable = [
        'sc_fa', 'company_id', 'equip_id', 'date', 'rent_cost', 'equip_cost', 'elect_cons', 'dayli_serv_cost'
    ];

    public function scfa()
    {
        return $this->hasOne('App\Models\Refs\EcoRefsScFa','id','sc_fa')->withDefault();
    }
    public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId','id','company_id')->withDefault();
    }
    public function equip()
    {
        return $this->hasOne('App\Models\EcoRefsEquipId','id','equip_id')->withDefault();
    }
}
