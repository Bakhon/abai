<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DzoImportDecreaseReason extends Model
{
    public function importDecreaseReason()
    {
        return $this->belongsTo(DzoImportData::class);
    }
}
