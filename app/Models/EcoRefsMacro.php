<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoRefsMacro extends Model
{
    protected $fillable = [
        'date', 'ex_rate,$', 'ex_rate,rub', 'inf_end'
    ];
}
