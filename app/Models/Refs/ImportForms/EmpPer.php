<?php

namespace App\Models\Refs\ImportForms;

use Illuminate\Database\Eloquent\Model;

class EmpPer extends Model
{
    protected $table = 'eco_refs_emp_pers';

    protected $fillable = [
        'sc_fa',
        'company_id',
        'direction_id',
        'route_id',
        'date',
        'emp_per'
    ];
}
