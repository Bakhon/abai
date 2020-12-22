<?php

namespace App\Models\Pipes;

use Illuminate\Database\Eloquent\Model;

class GuZuPipe extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'coordinates' => 'array'
    ];

    public function zu()
    {
        return $this->belongsTo(\App\Models\Refs\Zu::class);
    }

    public function gu()
    {
        return $this->belongsTo(\App\Models\Refs\Gu::class);
    }
}
