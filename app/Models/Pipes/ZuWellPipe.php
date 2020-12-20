<?php

namespace App\Models\Pipes;

use Illuminate\Database\Eloquent\Model;

class ZuWellPipe extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'coordinates' => 'array'
    ];

    public function well()
    {
        return $this->belongsTo(\App\Models\Refs\Well::class);
    }
}
