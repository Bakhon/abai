<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BigdataReport extends Model
{
    //relations

    public function section()
    {
        return $this->belongsTo(BigdataSection::class);
    }
}
