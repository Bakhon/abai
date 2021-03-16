<?php

namespace App\Models\Pipes;


use Illuminate\Database\Eloquent\Model;
use App\Models\Refs\Zu;
use App\Models\Refs\Gu;
use App\Models\Refs\Well;
use App\Models\Pipes\PipeCoord;
use App\Models\ComplicationMonitoring\PipeType;

class MapPipe extends Model
{
    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function zu()
    {
        return $this->belongsTo(Zu::class);
    }

    public function gu()
    {
        return $this->belongsTo(Gu::class);
    }

    public function well()
    {
        return $this->belongsTo(Well::class);
    }

    public function pipeType()
    {
        return $this->belongsTo(PipeType::class, 'type_id', 'id');
    }

    public function coords()
    {
        return $this->hasMany(PipeCoord::class);
    }
}