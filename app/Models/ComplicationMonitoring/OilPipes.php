<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Inhibitor;
use App\Models\Refs\Field;
use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;

class OilPipes extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'datetime',
    ];


   

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class)->withDefault();
    }

    // public function cdng()
    // {
    //     return $this->belongsTo(Cdng::class)->withDefault();
    // }

    public function gu()
    {
        return $this->belongsTo(Gu::class)->withDefault();
    }

    public function zu()
    {
        return $this->belongsTo(Zu::class)->withDefault();
    }

    public function well()
    {
        return $this->belongsTo(Well::class)->withDefault();
    }

    public function field()
    {
        return $this->belongsTo(Field::class)->withDefault();
    }

    // public function pipeType()
    // {
    //     return $this->belongsTo(PipeType::class)->withDefault();
    // }

    // public function inhibitor()
    // {
    //     return $this->belongsTo(Inhibitor::class)->withDefault();
    // }
}