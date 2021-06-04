<?php

namespace App\Models\Refs;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TechnicalStructureGu extends Model
{
    protected $fillable = [
        'name', 'cdng_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cdng()
    {
        return $this->belongsTo(TechnicalStructureCdng::class, 'cdng_id');
    }
}
