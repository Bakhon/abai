<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsMacro extends Model
{
    protected $fillable = [
        'date', 'ex_rate_dol', 'ex_rate_rub', 'inf_end'
    ];
}
