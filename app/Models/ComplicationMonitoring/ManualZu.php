<?php

namespace App\Models\ComplicationMonitoring;

use App\Traits\ClearOmgNgduOnDelete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ManualZu extends Model
{
    use LogsActivity, SoftDeletes, ClearOmgNgduOnDelete;

    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['updated_at', 'created_at', 'deleted_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public function gu()
    {
        return $this->belongsTo(ManualGu::class);
    }

    public function wells()
    {
        return $this->hasMany(ManualWell::class, 'zu_id');
    }

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class);
    }

    public function omgngdu()
    {
        return $this->hasMany(OmgNGDU::class, 'zu_id');
    }

    public function watermeasurement()
    {
        return $this->hasMany(WaterMeasurement::class, 'zu_id');
    }

    public function oilgas()
    {
        return $this->hasMany(OilGas::class, 'zu_id');
    }

    public function oilPipes()
    {
        return $this->setConnection('tbd_cmon')->hasMany(ManualOilPipe::class, 'zu_id');
    }

    public function omguhe()
    {
        return $this->hasMany(OmgUHE::class, 'zu_id');
    }


}
