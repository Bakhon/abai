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

}