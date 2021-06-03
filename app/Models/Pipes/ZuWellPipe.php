<?php

namespace App\Models\Pipes;

use Illuminate\Database\Eloquent\Model;
use App\Models\Refs\Well;
use App\Models\ComplicationMonitoring\PipeType;

class ZuWellPipe extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'coordinates' => 'array'
    ];

    public function well()
    {
        return $this->belongsTo(Well::class);
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
