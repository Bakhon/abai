<?php

namespace App\Models\Refs;

use App\User;
use Illuminate\Database\Eloquent\Model;

class EcoRefsGtmKit extends Model
{
    protected $fillable = [
        'name', 'gtm_log_id', 'gtm_value_log_id', 'user_id',
    ];

    public function gtmLog()
    {
        return $this->belongsTo(EconomicDataLog::class, 'gtm_log_id');
    }

    public function gtmValueLog()
    {
        return $this->belongsTo(EconomicDataLog::class, 'gtm_value_log_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
