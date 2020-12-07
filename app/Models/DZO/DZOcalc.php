<?php

namespace App\Models\DZO;

use Illuminate\Database\Eloquent\Model;

class DZOcalc extends Model
{
    protected $table = 'd_z_ocalcs';

    protected $fillable = [
        'dzo',
        'type', 
        'jan_plan_2020',
        'jan_fact_2020',
        'jan_fact_2019',
        'feb_plan_2020',
        'feb_fact_2020',
        'feb_fact_2019',
        'mar_plan_2020',
        'mar_fact_2020',
        'mar_fact_2019',
        'apr_plan_2020',
        'apr_fact_2020',
        'apr_fact_2019',
        'may_plan_2020',
        'may_fact_2020',
        'may_fact_2019',
        'jun_plan_2020',
        'jun_fact_2020',
        'jun_fact_2019',
        'jul_plan_2020',
        'jul_fact_2020',
        'jul_fact_2019',
        'aug_plan_2020',
        'aug_fact_2020',
        'aug_fact_2019',
        'sept_plan_2020',
        'sept_fact_2020',
        'sept_fact_2019',
        'oct_plan_2020',
        'oct_fact_2020',
        'oct_fact_2019',
        'plan_2020'
    ];
}
