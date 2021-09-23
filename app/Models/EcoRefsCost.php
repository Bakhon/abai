<?php

namespace App\Models;

use App\Models\Refs\TechnicalStructurePes;
use Illuminate\Database\Eloquent\Model;

class EcoRefsCost extends Model
{
    protected $fillable = [
        'sc_fa', 'company_id', 'date', 'variable', 'fix_noWRpayroll', 'fix_payroll',
        'fix_nopayroll', 'fix', 'gaoverheads', 'wr_nopayroll', 'wr_payroll', 'wo',
        'comment', 'author_id', 'log_id', 'net_back', 'amort', 'variable_processing', 'pes_id'
    ];

    const FILLABLE_FLOAT_KEYS = [
        'variable', 'variable_processing', 'fix_noWRpayroll', 'fix_payroll', 'fix_nopayroll', 'fix',
        'gaoverheads', 'wr_nopayroll', 'wr_payroll', 'wo', 'net_back', 'amort',
    ];

    public function scfa()
    {
        return $this->hasOne('App\Models\Refs\EcoRefsScFa', 'id', 'sc_fa')->withDefault();
    }

    public function company()
    {
        return $this->hasOne('App\Models\EcoRefsCompaniesId', 'id', 'company_id')->withDefault();
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function editor()
    {
        return $this->belongsTo('App\User', 'editor_id');
    }

    public function pes()
    {
        return $this->belongsTo(TechnicalStructurePes::class, 'pes_id');
    }
}
