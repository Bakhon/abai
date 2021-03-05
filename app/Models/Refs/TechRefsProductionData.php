<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;

class TechRefsProductionData extends Model
{
    protected $fillable = [
        'source_id', 'gu_id', 'well_id', 'date', 'oil', 'liquid', 'days_worked', 'prs', 'author_id', 'editor_id'
    ];

    public function source()
    {
        return $this->belongsTo('App\Models\Refs\TechRefsSource', 'source_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function editor()
    {
        return $this->belongsTo('App\User', 'editor_id');
    }

    public function gu()
    {
        return $this->belongsTo('App\Models\Refs\TechRefsGu', 'gu_id');
    }
}
