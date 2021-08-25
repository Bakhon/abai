<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class EcoRefsGtmValue extends Model
{
    protected $fillable = [
        'gtm_id', 'date', 'priority',
        'growth', 'amount', 'comment', 'author_id'
    ];

    public function company()
    {
        return $this->belongsTo(EcoRefsGtm::class, 'gtm_id');
    }

    public function gtm()
    {
        return $this->belongsTo(EcoRefsGtm::class, 'gtm_id');
    }

}
