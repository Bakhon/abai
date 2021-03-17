<?php

namespace App\Models\BigData\Infrastructure;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'bigdata_history';

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'datetime',
        'payload' => 'array'
    ];

    //relations

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
