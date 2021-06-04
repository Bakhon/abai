<?php

namespace App\Models\Pipes;

use Illuminate\Database\Eloquent\Model;
use App\Models\ComplicationMonitoring\Zu;
use App\Models\ComplicationMonitoring\PipeType;

class GuZuPipe extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'coordinates' => 'array'
    ];

    public function zu()
    {
        return $this->belongsTo(Zu::class);
    }

    public function gu()
    {
        return $this->belongsTo(Gu::class);
    }

    public function pipeType()
    {
        return $this->belongsTo(PipeType::class);
    }
}
