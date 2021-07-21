<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\WithHistory;


class Material extends Model
{

    use WithHistory;

    protected $fillable = ['name', 'yield_point', 'roughness'];

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
        return $this->setConnection('tbd_cmon')->hasMany(OilPipe::class);
    }
}
