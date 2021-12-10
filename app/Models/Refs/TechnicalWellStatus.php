<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class TechnicalWellStatus extends Model
{
    protected $fillable = ['name', 'user_id'];

    const GDIS = 1;

    const KRF_FOR_RECOVERY = 2;

    const KRF_FOR_INCREASE = 3;
}
