<?php

namespace App\Models\Refs;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TechnicalWellForecastKit extends Model
{
    protected $fillable = [
        'name', 'technical_log_id', 'economic_log_id', 'user_id',
    ];

    public function economicLog()
    {
        return $this->belongsTo(EconomicDataLog::class, 'economic_log_id');
    }

    public function technicalLog()
    {
        return $this->belongsTo(EconomicDataLog::class, 'technical_log_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
