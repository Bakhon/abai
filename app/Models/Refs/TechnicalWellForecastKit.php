<?php

namespace App\Models\Refs;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TechnicalWellForecastKit extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'permanent_stop_coefficients' => 'array',
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

    public function results()
    {
        return $this->hasMany(TechnicalWellForecastKitResult::class, 'kit_id');
    }
}
