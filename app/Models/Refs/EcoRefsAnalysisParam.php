<?php

namespace App\Models\Refs;

use App\User;
use Illuminate\Database\Eloquent\Model;

class EcoRefsAnalysisParam extends Model
{
    protected $fillable = [
        'date', 'netback_plan', 'netback_fact', 'netback_forecast',
        'variable_cost', 'permanent_cost', 'permanent_year_cost',
        'avg_prs_cost', 'oil_density', 'days',
        'permanent_stop_cost', 'permanent_stop_cost_propose',
        'user_id', 'log_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
