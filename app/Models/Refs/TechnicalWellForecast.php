<?php

namespace App\Models\Refs;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TechnicalWellForecast extends Model
{
    protected $fillable = [
        'uwi', 'date', 'active_hours', 'paused_hours', 'prs_portion',
        'oil', 'oil_forecast', 'oil_loss', 'oil_tech_loss',
        'liquid', 'liquid_forecast', 'liquid_loss', 'liquid_tech_loss',
        'status_id', 'loss_status_id', 'user_id', 'log_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(TechnicalWellStatus::class, 'status_id');
    }

    public function lossStatus()
    {
        return $this->belongsTo(TechnicalWellLossStatus::class, 'loss_status_id');
    }
}
