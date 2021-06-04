<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Inhibitor;
use App\Models\Refs\Field;
use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;

class OmgUHE extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'datetime',
        'out_of_service_of_dosing' => 'boolean'
    ];

    protected $attributes = ['out_of_service_of_dosing' => 0];

    public function getCurrentDosageAttribute($value)
    {
        return $value ? round($value, 1) : $value;
    }

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class)->withDefault();
    }

    public function cdng()
    {
        return $this->belongsTo(Cdng::class)->withDefault();
    }

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

    public function inhibitor()
    {
        return $this->belongsTo(Inhibitor::class)->withDefault();
    }
}
