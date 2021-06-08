<?php

namespace App\Models\Refs;

use App\User;
use Illuminate\Database\Eloquent\Model;

class TechnicalDataForecast extends Model
{
    protected $fillable = [
        'source_id',
        'gu_id',
        'well_id',
        'date', 'oil',
        'liquid',
        'days_worked',
        'prs',
        'comment',
        'author_id',
        'editor_id',
        'log_id'
    ];

    public function source()
    {
        return $this->belongsTo(TechnicalStructureSource::class, 'source_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function gu()
    {
        return $this->belongsTo(TechnicalStructureGu::class, 'gu_id');
    }

    public function log()
    {
        return $this->belongsTo(TechnicalDataLog::class, 'log_id');
    }
}
