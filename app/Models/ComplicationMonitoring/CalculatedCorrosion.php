<?php

namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;

class CalculatedCorrosion extends Model
{
    protected $guarded = ['id'];

    public function gu()
    {
        return $this->hasOne(Gu::class);
    }
}
