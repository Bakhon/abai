<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class TechRefsProductionData extends Model
{
    protected $fillable = [
        'gu_id', 'well_id', 'date', 'oil', 'liquid', 'days_worked', 'prs', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function gu()
    {
        return $this->belongsTo('App\Models\Refs\TechRefsGu', 'gu_id');
    }
}
