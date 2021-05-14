<?php

namespace App\Models\VisCenter\ExcelForm;

use Illuminate\Database\Eloquent\Model;

class DzoImportDecreaseReason extends Model
{
    public $timestamps = false;

    public function importData()
    {
        return $this->belongsTo(DzoImportData::class,'dzo_import_data_id','id');
    }
}
