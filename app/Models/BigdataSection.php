<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BigdataSection extends Model
{
    //relations

    public function reports()
    {
        return $this->hasMany(BigdataReport::class);
    }
}
