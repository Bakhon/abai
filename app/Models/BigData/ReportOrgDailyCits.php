<?php


namespace App\Models\BigData;

use App\Models\BigData\Dictionaries\Metric;
use App\Models\TBDModel;

class ReportOrgDailyCits extends TBDModel
{

    protected $table = 'prod.report_org_daily_cits';

    public function metric()
    {
        return $this->belongsTo(Metric::class, 'metric');
    }
}