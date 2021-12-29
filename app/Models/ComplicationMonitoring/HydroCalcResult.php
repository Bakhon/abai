<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class HydroCalcResult extends Model
{
    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $connection = 'tbd_cmon';

    public function oilPipe()
    {
        return $this->belongsTo(OilPipe::class);
    }

    public function wellGuOilPipe()
    {
        return $this->belongsTo(OilPipe::class)
            ->whereIn('between_points', [
                'well-zu',
                'well-well_collector',
                'well_collector-zu',
                'zu-gu',
                'zu-zu_coll',
                'zu_coll-gu'
            ]);
    }
}
