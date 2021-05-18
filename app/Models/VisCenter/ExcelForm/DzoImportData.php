<?php

namespace App\Models\VisCenter\ExcelForm;

use Illuminate\Database\Eloquent\Model;

class DzoImportData extends Model
{
    public $timestamps = false;
    protected $fillable = ['oil_production_fact','oil_delivery_fact','dzo_name','date','condensate_production_fact','condensate_delivery_fact'];

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
