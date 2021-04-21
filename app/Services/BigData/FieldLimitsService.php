<?php


namespace App\Services\BigData;

use App\Services\BigData\Forms\TableForm;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FieldLimitsService
{
    const DEVIATION_COEFFICIENT = 0.341;

    public function calculate(array $fields, CarbonImmutable $date)
    {
        foreach ($fields as $field) {
            $this->calculateFieldLimits($date, $field);
        }
    }

    public function calculateFieldLimits(CarbonImmutable $date, array $field)
    {
        $startDate = $date->subMonthNoOverflow();
        if (!empty($field['custom_period'])) {
            $startDate = $date->sub($field['custom_period']);
        }

        $query = DB::connection('tbd')
            ->table($field['table'])
            ->select('well', $field['column'])
            ->where('dbeg', '>=', $startDate)
            ->where('dbeg', '<=', $date);

        if (!empty($field['additional_filter'])) {
            foreach ($field['additional_filter'] as $key => $value) {
                $query->where($key, $value);
            }
        }

        $result = $query->get()
            ->groupBy('well')
            ->map(
                function ($columnValues) use ($field) {
                    return $this->calculateColumnLimits($field['column'], $columnValues);
                }
            );

        $cacheKey = TableForm::getLimitsCacheKey($field, $date);
        Cache::put($cacheKey, $result->toJson(), Carbon::now()->addDay());

        return $result->toArray();
    }

    private function calculateColumnLimits(string $column, Collection $columnValues): array
    {
        if ($columnValues->count() <= 1) {
            return [];
        }

        $avg = $columnValues->sum($column) / $columnValues->count();
        $deviation = $this->calcStandardDeviation(
            $columnValues->pluck($column),
            $avg
        );

        $min = $avg - $deviation * self::DEVIATION_COEFFICIENT;
        $max = $avg + $deviation * self::DEVIATION_COEFFICIENT;

        return $this->getRoundedValues($min, $max);
    }

    private function calcStandardDeviation(Collection $collection, float $avg): float
    {
        $sum = $collection->reduce(
            function ($sum, $item) use ($avg) {
                return $sum + pow($item - $avg, 2);
            }
        );

        return sqrt($sum / ($collection->count() - 1));
    }

    private function getRoundedValues(float $min, float $max)
    {
        if (abs($min) < 1 || abs($max) < 1) {
            $min = floor($min * 100) / 100;
            $max = ceil($max * 100) / 100;
        } elseif (abs($min) < 10 || abs($max) < 10) {
            $min = floor($min * 10) / 10;
            $max = ceil($max * 10) / 10;
        } else {
            $min = floor($min);
            $max = ceil($max);
        }
        return [
            'min' => $min,
            'max' => $max,
        ];
    }
}