<?php

namespace App\Models\VisCenter\ExcelForm;

use Illuminate\Database\Eloquent\Model;

class DzoImportDowntimeReason extends Model
{
    public $timestamps = false;
    protected $fillable = [
            'prs_wait_downtime_production_wells_count',
            'prs_downtime_production_wells_count',
            'krs_wait_downtime_production_wells_count',
            'krs_downtime_production_wells_count',
            'well_survey_downtime_production_wells_count',
            'unprofitable_downtime_production_wells_count',
            'other_downtime_production_wells_count'
        ];

    public function importData()
    {
        return $this->belongsTo(DzoImportData::class,'dzo_import_data_id','id');
    }
}
