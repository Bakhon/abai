<?php

namespace App\Models\Refs;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

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
     * @return BelongsTo|EcoRefsGtmKit
     */
    public function gtmKit()
    {
        return $this->belongsTo(EcoRefsGtmKit::class, 'gtm_kit_id');
    }

    /**
     * @return BelongsTo|EconomicDataLog
     */
    public function manufacturingLog()
    {
        return $this->belongsTo(EconomicDataLog::class, 'manufacturing_program_log_id');
    }

    /**
     * @return HasOneThrough|EcoRefsManufacturingProgram
     */
    public function manufacturingProgram()
    {
        return $this->hasOneThrough(
            EcoRefsManufacturingProgram::class,
            EconomicDataLog::class,
            'id',
            'log_id',
            'manufacturing_program_log_id',
            'id'
        );
    }

    /**
     * @return BelongsTo|TechnicalStructureSource
     */
    public function source()
    {
        return $this->belongsTo(TechnicalStructureSource::class, 'source_id');
    }

    /**
     * @return BelongsTo|User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasMany|EcoRefsScenarioResult
     */
    public function results()
    {
        return $this->hasMany(EcoRefsScenarioResult::class, 'scenario_id');
    }
}
