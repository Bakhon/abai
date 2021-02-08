<?php

namespace App\Models\BigData;

use Illuminate\Database\Eloquent\Model;

class Well extends Model
{
    protected $table = 'bigdata_wells';
    protected $guarded = ['id'];
}
