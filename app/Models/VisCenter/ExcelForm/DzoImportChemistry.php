<?php

namespace App\Models\VisCenter\ExcelForm;

use Illuminate\Database\Eloquent\Model;

class DzoImportChemistry extends Model
{
    public $timestamps = false;
    protected $fillable = ['demulsifier','bactericide','corrosion_inhibitor','scale_inhibitor','dzo_name','date'];
}
