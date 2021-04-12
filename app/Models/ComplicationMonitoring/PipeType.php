<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class PipeType extends Model
{
    protected $table = 'pipe_types';
    protected $guarded = ['id'];
    protected $fillable = ['name', 'outside_diameter', 'inner_diameter', 'thickness', 'roughness', 'material_id', 'plot'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class)->withDefault();
    }
}
