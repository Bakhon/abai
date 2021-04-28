<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Pipes\OilPipe;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\WithHistory;


class Material extends Model
{

    use WithHistory;

    public function material()
    {
        return $this->belongsTo(Material::class)->withDefault();
    }

    public function pipe()
    {
        return $this->hasMany(Pipe::class);
    }

    public function oilPipes()
    {
        return $this->hasMany(OilPipe::class);
    }
}
