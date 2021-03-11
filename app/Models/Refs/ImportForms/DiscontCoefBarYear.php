<?php

namespace App\Models\Refs\ImportForms;

use Illuminate\Database\Eloquent\Model;

class DiscontCoefBarYear extends Model
{
    protected $table = 'eco_refs_discont_coef_bars';

    protected $fillable = [
        'sc_fa',
        'company_id',
        'direction_id',
        'route_id',
        'date',
        'barr_coef',
        'discont',
        'oil_cost',
    ];
}