<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ManualWell extends Model
{
    use LogsActivity, SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['updated_at', 'created_at', 'deleted_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public function zu()
    {
        return $this->belongsTo(ManualZu::class);
    }

    public function gu()
    {
        return $this->belongsTo(ManualGu::class);
    }

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class);
    }

    public function omgngdu()
    {
        return $this->hasMany(OmgNGDU::class, 'well_id');
    }

    public function watermeasurement()
    {
        return $this->hasMany(WaterMeasurement::class, 'well_id');
    }

    public function oilgas()
    {
        return $this->hasMany(OilGas::class, 'well_id');
    }

    public function oilPipes()
    {
        return $this->setConnection('tbd_cmon')->hasMany(ManualOilPipe::class, 'well_id');
    }

    public function omguhe()
    {
        return $this->hasMany(OmgUHE::class, 'well_id');
    }

    public function omgngdu_well()
    {
        return $this->hasMany(OmgNGDUWell::class, 'well_id');
    }
}
