<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Pipes\MapPipe;
use Illuminate\Database\Eloquent\Model;

class PipeType extends Model
{
    protected $table = 'pipe_types';
    protected $guarded = ['id'];
    protected $fillable = ['name', 'outside_diameter', 'inner_diameter', 'thickness'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class)->withDefault();
    }

    public function mapPipes()
    {
        return $this->belongsTo(MapPipe::class, 'id', 'type_id');
    }
}
