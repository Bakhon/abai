<?php

namespace App\Models\Refs;

use App\User;
use Illuminate\Database\Eloquent\Model;

class EcoRefsWellForecast extends Model
{
    protected $fillable = [
        'uwi', 'date', 'active_days', 'paused_days', 'prs_portion',
        'oil', 'oil_forecast', 'oil_loss', 'oil_tech_loss',
        'liquid', 'liquid_forecast', 'liquid_loss', 'liquid_tech_loss',
        'author_id', 'log_id'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
