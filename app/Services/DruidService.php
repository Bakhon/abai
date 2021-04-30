<?php

namespace App\Services;

use Level23\Druid\DruidClient;
use Level23\Druid\Extractions\ExtractionBuilder;
use Level23\Druid\Types\Granularity;

class DruidService
{
    protected $client;

    public function __construct(DruidClient $client)
    {
        $this->client = $client;
    }

    public function getWellCoordinates()
    {
        $builder = $this->client->query('economic_2020v4', Granularity::DAY);

        $builder
            ->interval('2020-07-01T00:00:00+00:00/2020-07-02T00:00:00+00:00')
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat('yyyy-MM-dd');
            })
            ->select('surfx')
            ->select('surfy')
            ->select('uwi');

        $result = $builder->groupBy();

        return $result->data();
    }

    public function getWellOil()
    {

        $builder = $this->client->query('economic_2020v4', Granularity::DAY);

        $builder
            ->interval('2020-07-01T00:00:00+00:00/2020-07-02T00:00:00+00:00')
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat('yyyy-MM-dd');
            })
            ->select('uwi')
            ->select('oil');

        $result = $builder->groupBy();

        return $result->data();
    }

    public function getAccumOilProd(string $intervalStart, string $intervalStop):array
    {
        $builder = $this->client->query('gtm_eff_forecast_v25', Granularity::MONTH);
        $builder->interval($intervalStart, $intervalStop);
        $builder->select(...['__time', 'dt',
            function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat('yyyy-MM');
            }
        ]);
        $builder->floatSum('add_prod_12m');
        $builder->floatSum('plan_add_prod_12m');
        $result = $builder->groupBy();

        return $result->data();
    }

    public function getComparisonIndicators(string $intervalStart, string $intervalStop):array
    {
        $builder = $this->client->query('gtm_eff_forecast_v25', Granularity::YEAR);
        $builder->interval($intervalStart, $intervalStop);
        $builder->select(...['__time', 'dt',
            function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat('yyyy');
            }
        ]);
        $builder->select('gtm_kind');
        $builder->distinctCount('well_uwi');
        $builder->sum('work_time');
        $builder->floatSum('add_prod_12m');
        $builder->floatSum('plan_add_prod_12m');
        $builder->where('dzo_short',  'ММГ');
        $result = $builder->groupBy();

        return $result->data();
    }
}