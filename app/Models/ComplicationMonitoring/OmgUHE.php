<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;

class OmgUHE extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'datetime',
        'out_of_service_оf_dosing' => 'boolean'
    ];

    protected $attributes = ['out_of_service_оf_dosing' => 0];

    public function getCurrentDosageAttribute($value)
    {
        return $value ? round($value, 1) : $value;
    }

    public function ngdu()
    {
        return $this->belongsTo(\App\Models\Refs\Ngdu::class)->withDefault();
    }

    public function cdng()
    {
        return $this->belongsTo(\App\Models\Refs\Cdng::class)->withDefault();
    }

    public function gu()
    {
        return $this->belongsTo(\App\Models\Refs\Gu::class)->withDefault();
    }

    public function zu()
    {
        return $this->belongsTo(\App\Models\Refs\Zu::class)->withDefault();
    }

    public function well()
    {
        return $this->belongsTo(\App\Models\Refs\Well::class)->withDefault();
    }

    public function field()
    {
        return $this->belongsTo(\App\Models\Refs\Field::class)->withDefault();
    }

    public function inhibitor()
    {
        return $this->belongsTo(\App\Models\Inhibitor::class)->withDefault();
    }
}
