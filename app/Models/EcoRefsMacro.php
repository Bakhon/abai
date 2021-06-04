<?php

namespace App\Models;

use App\Models\Refs\EcoRefsScFa;
use Illuminate\Database\Eloquent\Model;

class EcoRefsMacro extends Model
{
    protected $fillable = [
        'sc_fa', 'date', 'ex_rate_dol', 'ex_rate_rub', 'inf_end', 'barrel_world_price'
    ];
    public function scfa()
    {
        return $this->hasOne(EcoRefsScFa::class,'id','sc_fa')->withDefault();
    }
}
