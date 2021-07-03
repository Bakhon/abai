<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;


class Agzu extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    public $table = 'agzu';

    public function gu()
    {
        return $this->hasOne(Gu::class)->withDefault();
    }

    
}
