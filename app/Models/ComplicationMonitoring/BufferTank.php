<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Refs\Field;
use App\Models\Refs\OtherObjects;

class BufferTank extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    public $table = 'buffer_tank';

    public function gu()
    {
        return $this->hasOne(Gu::class)->withDefault();
    }

    
}
