<?php

namespace App\Models\VisCenter\ImportForms;

use Illuminate\Database\Eloquent\Model;

class DZOstaff extends Model
{
    protected $fillable = [
        'dzo',
        'date',
        "__time",
        "staff_number",
    ];
}
