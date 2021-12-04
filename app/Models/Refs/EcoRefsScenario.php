<?php

namespace App\Models\Refs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EcoRefsScenario extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'params' => 'array',
    ];

    /**
     * @return BelongsTo|EcoRefsScFa
     */
    public function scFa()
    {
        return $this->belongsTo(EcoRefsScFa::class, 'sc_fa_id');
    }

    /**
     * @return HasMany|EcoRefsScenarioResult
     */
    public function results()
    {
        return $this->hasMany(EcoRefsScenarioResult::class, 'scenario_id');
    }
}
