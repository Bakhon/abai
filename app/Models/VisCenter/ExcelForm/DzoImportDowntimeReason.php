<?php

namespace App\Models\VisCenter\ExcelForm;

use Illuminate\Database\Eloquent\Model;

class DzoImportDowntimeReason extends Model
{
    public $timestamps = false;

    public function importData()
    {
        return $this->belongsTo(DzoImportData::class);
    }
}