<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dzoPlan extends Model
{
    protected $table = 'dzo_plans';

    protected $fillable = [
        "date",
        "dzo",
        "plan_oil",
        "plan_kondensat"
    ];
}
