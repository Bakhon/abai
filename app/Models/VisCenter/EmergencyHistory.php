<?php

namespace App\Models\VisCenter;

use Illuminate\Database\Eloquent\Model;

class EmergencyHistory extends Model
{
    protected $table = 'emergency_history';
    public $timestamps = false;
    protected $fillable = [
        'date',
        'title',
        'description',
        'approved'
    ];
}
