<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EditHistory extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'date_prev_change' => 'datetime',
        'payload' => 'array'
    ];

    public function entity()
    {
        return $this->morphTo();
    }

}
