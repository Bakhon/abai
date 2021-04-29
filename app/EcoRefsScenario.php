<?php

namespace App;

use App\Models\Refs\EcoRefsScFa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
