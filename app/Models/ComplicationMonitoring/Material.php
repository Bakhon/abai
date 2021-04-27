<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Pipes\MapPipe;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public function pipe()
    {
        return $this->hasMany(Pipe::class)->withDefault();
    }

    public function map_pipe()
    {
        return $this->hasMany(MapPipe::class);
    }
}
