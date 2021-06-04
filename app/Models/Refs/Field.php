<?php

namespace App\Models\Refs;

use App\Models\ComplicationMonitoring\Corrosion;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\OmgUHE;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Field extends Model
{
    public function omgngdu()
    {
        return $this->hasMany(OmgNGDU::class);
    }

    public function watermeasurement()
    {
        return $this->hasMany(WaterMeasurement::class);
    }

    public function corrosion()
    {
        return $this->hasMany(Corrosion::class);
    }

    public function omguhe()
    {
        return $this->hasMany(OmgUHE::class);
    }

    /**
     * @return BelongsTo|Org
     */
    public function org()
    {
        return $this->belongsTo(Org::class, 'org_id');
    }
}
