<?php

namespace App\Models\VisCenter\ExcelForm;

use Illuminate\Database\Eloquent\Model;

class DzoImportOtm extends Model
{
    protected $table = 'dzo_import_otm';
    public $timestamps = false;
    protected $fillable = ['dzo_name','otm_well_workover_fact','otm_underground_workover','date'];
}
