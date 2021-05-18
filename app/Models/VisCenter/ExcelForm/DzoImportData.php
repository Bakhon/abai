<?php

namespace App\Models\VisCenter\ExcelForm;

use Illuminate\Database\Eloquent\Model;

class DzoImportData extends Model
{
    public $timestamps = false;

    public function importField()
    {
        return $this->hasMany(DzoImportField::class);
    }
    public function importDowntimeReason()
    {
        return $this->hasOne(DzoImportDowntimeReason::class);
    }
    public function importDecreaseReason()
    {
        return $this->hasOne(DzoImportDecreaseReason::class);
    }
}
