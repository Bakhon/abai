<?php

namespace App\Models\VisCenter\ExcelForm;

use Illuminate\Database\Eloquent\Model;

class DzoImportDecreaseReason extends Model
{
    public $timestamps = false;

    public function importField()
    {
        return $this->belongsTo(DzoImportData::class);
    }
}
