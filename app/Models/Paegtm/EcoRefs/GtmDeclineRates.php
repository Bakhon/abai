<?php

namespace App\Models\Paegtm\EcoRefs;

use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\Org;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GtmDeclineRates extends Model
{
    protected $table = 'paegtm_gtm_decline_rates';

    protected $fillable = [
        'org_id',
        'dzo_name',
        'dzo_name_short',
        'geo_id',
        'oilfield',
        'date',
        'base_fund',
        'vns',
        'vns_grp',
        'gs',
        'gs_grp',
        'zbs',
        'zbgs',
        'ugl',
        'grp',
        'vbd',
        'pvlg',
        'rir',
        'pvr',
        'opz',
    ];

    protected $casts = [
        'date' 	=> 'date',
    ];

    /**
     * @return BelongsTo|Org
     */
    public function org()
    {
        return $this->belongsTo(Org::class, 'org_id');
    }

    /**
     * @return BelongsTo|Org
     */
    public function geo()
    {
        return $this->belongsTo(Geo::class, 'org_id');
    }
}
