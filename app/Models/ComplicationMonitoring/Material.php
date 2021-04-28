<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\WithHistory;


class Material extends Model
{

    use WithHistory;


    protected $table = 'materials';
    protected $guarded = ['id'];
    protected $fillable = ['name', 'yield_point', 'roughness', 'material_id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class)->withDefault();
    }

    public function pipe()
    {
        return $this->hasMany(Pipe::class);
    }

    public function pipeType()
    {
        return $this->hasMany(PipeType::class);
    }

    public function oilPipes()
    {
        return $this->hasMany(OilPipe::class);
    }


   
}
