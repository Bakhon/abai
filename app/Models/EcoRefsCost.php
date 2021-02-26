<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsCost extends Model
{
    protected $fillable = [
        'sc_fa', 'company_id', 'date', 'variable', 'fix_noWRpayroll', 'fix_nopayroll', 'fix', 'gaoverheads',
        'wr_nopayroll', 'wr_payroll', 'wo'
    ];

    public function scfa()
    {
        return $this->hasOne('App\Models\Refs\EcoRefsScFa','id','sc_fa')->withDefault();
    }

    public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId','id','company_id')->withDefault();
    }
}
