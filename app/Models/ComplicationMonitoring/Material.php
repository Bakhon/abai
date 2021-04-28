<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Pipes\OilPipe;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public function pipe()
    {
        return $this->hasMany(Pipe::class);
    }

    public function oilPipes()
    {
        return $this->hasMany(OilPipe::class);
    }
}
