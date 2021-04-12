<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public function pipe()
    {
        return $this->hasOne(Pipe::class)->withDefault();
    }
}
