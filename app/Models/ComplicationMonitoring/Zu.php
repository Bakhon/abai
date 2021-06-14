<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Zu extends Model
{
    use LogsActivity, SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['updated_at', 'created_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public function gu()
    {
        return $this->belongsTo(Gu::class);
    }

    public function wells()
    {
        return $this->hasMany(Well::class);
    }

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class);
    }

    public function omgngdu()
    {
        return $this->hasMany(OmgNGDU::class);
    }

    public function watermeasurement()
    {
        return $this->hasMany(WaterMeasurement::class);
    }

    public function oilgas()
    {
        return $this->hasMany(OilGas::class);
    }

    public function omguhe()
    {
        return $this->hasMany(OmgUHE::class);
    }

    public function omgngdu_well()
    {
        return $this->hasMany(OmgNGDUWell::class);
    }
}
