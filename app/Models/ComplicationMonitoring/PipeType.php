<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PipeType extends Model
{
    use LogsActivity, SoftDeletes;

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

    public function oilPipes()
    {
        return $this->hasMany(OilPipe::class, 'type_id', 'id');
    }
}
