<?php

namespace App\Models\ComplicationMonitoring;

use App\Models\Traits\WithHistory;
use Illuminate\Database\Eloquent\Model;

class PipeType extends Model
{
    use WithHistory;

    protected $guarded = ['id'];

    public function material()
    {
        return $this->belongsTo(Material::class)->withDefault();
    }
}
