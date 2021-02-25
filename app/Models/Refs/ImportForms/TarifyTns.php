<?php

namespace App\Models\Refs\ImportForms;

use Illuminate\Database\Eloquent\Model;

class TarifyTns extends Model
{
    protected $table = 'eco_refs_tarify_tns';

    protected $fillable = [
        'sc_fa',
        'branch_id',
        'company_id',
        'direction_id',
        'route_id',
        'route_tn_id',
        'exc_id',
        'date',
        'tn_rate',
        'extent'
    ];
}
