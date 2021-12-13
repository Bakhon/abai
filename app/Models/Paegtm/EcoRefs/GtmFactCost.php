<?php

namespace App\Models\Paegtm\EcoRefs;

use Illuminate\Database\Eloquent\Model;

class GtmFactCost extends Model
{
    protected $table = 'paegtm_refs_gtm_fact_costs';

    protected $fillable = [
        'org_id',
        'dzo_name',
        'dzo_name_short',
        'geo_id',
        'oilfield',
        'well_name',
        'gtm_type_id',
        'gtm_name',
        'price',
        'gtm_date',
    ];
}
