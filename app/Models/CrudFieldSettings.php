<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrudFieldSettings extends Model
{
    protected $guarded = ['id'];

    public function getMinValueAttribute($value)
    {
        return (float)$value;
    }

    public function getMaxValueAttribute($value)
    {
        return (float)$value;
    }
}
