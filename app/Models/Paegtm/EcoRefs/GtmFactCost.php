<?php

namespace App\Models\Paegtm\EcoRefs;

use Illuminate\Database\Eloquent\Model;

class GtmFactCost extends Model
{
    protected $table = 'paegtm_refs_gtm_fact_costs';
    protected $fillable = [
        'dzo_name',
        'dzo_name_short',
        'oilfield',
        'well_name',
        'gtm_name',
        'price',
        'gtm_date',
    ];
}
