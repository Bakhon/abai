<?php

namespace App\Models\Refs\ImportForms;

use Illuminate\Database\Eloquent\Model;

class CostYear extends Model
{
    protected $table = 'eco_refs_costs';

    protected $fillable = [
        'sc_fa',
        'company_id',
        'date',
        'variable',
        'fix_noWRpayroll',
        'fix_payroll',
        'fix_nopayroll',
        'fix',
        'gaoverheads',
        'wr_nopayroll',
        'wr_payroll',
        'wo'
    ];
}
