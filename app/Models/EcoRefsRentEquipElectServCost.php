<?php

namespace App\Models;

use App\Models\Refs\EcoRefsScFa;
use Illuminate\Database\Eloquent\Model;

class EcoRefsRentEquipElectServCost extends Model
{
    protected $fillable = [
        'sc_fa', 'company_id', 'equip_id', 'date', 'rent_cost', 'equip_cost', 'elect_cons', 'dayli_serv_cost'
    ];

    public function scfa()
    {
        return $this->hasOne(EcoRefsScFa::class,'id','sc_fa')->withDefault();
    }
    public function company()
    {
        return $this->hasOne(EcoRefsCompaniesId::class,'id','company_id')->withDefault();
    }
    public function equip()
    {
        return $this->hasOne(EcoRefsEquipId::class,'id','equip_id')->withDefault();
    }
}
