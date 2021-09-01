<?php

namespace App\Models\VisCenter\ExcelForm;

use Illuminate\Database\Eloquent\Model;

class DzoImportData extends Model
{
    protected $fillable = [
        'oil_production_fact',
        'oil_delivery_fact',
        'dzo_name','date',
        'condensate_production_fact',
        'condensate_delivery_fact',
        'oil_production_fact_absolute',
        'oil_delivery_fact_absolute'
    ];

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
