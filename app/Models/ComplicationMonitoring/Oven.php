<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;


class Oven extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    public $table = 'ovens';

    public function gu()
    {
        return $this->hasOne(Gu::class, 'id', 'gu_id')->withDefault();
    }

    
}
