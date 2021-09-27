<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;

class Pump extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    public function gu()
    {
        return $this->belongsTo(Gu::class);
    }

    
}
