<?php

namespace App\Models;

use App\Models\Refs\EcoRefsScFa;
use Illuminate\Database\Eloquent\Model;

class EcoRefsAvgPrs extends Model
{
    protected $fillable = [
        'sc_fa', 'company_id', 'date', 'avg_prs'
    ];

    public function scfa()
    {
        return $this->hasOne(EcoRefsScFa::class,'id','sc_fa')->withDefault();
    }
    public function company()
    {
        return $this->hasOne(EcoRefsCompaniesId::class,'id','company_id')->withDefault();
    }
}
