<?php


namespace App\Models\ComplicationMonitoring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BG extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
