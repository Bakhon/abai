<?php

namespace App\Console\Commands\BigData;

use App\Services\BigData\Forms\TableForm;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use ReflectionClass;

class CalculateFieldLimits extends Command
{
    const DEVIATION_COEFFICIENT = 0.341;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'form:calc_field_limits';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Расчет изменчивости параметров для форм ввода';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fields = $this->getFields();
        $this->calculateLimits($fields);
    }

    private function getFields(): array
    {
        $forms = config('bigdata_forms');

        $fields = [];

        foreach ($forms as $formClassName) {
            $class = new ReflectionClass($formClassName);

            if ($class->getParentClass()->name === TableForm::class) {
                $fields = array_merge($fields, $this->getFormFields($class));
            }
        }

        return $fields;
    }

    private function getFormFields(ReflectionClass $class): array
    {
        $configFilePath = app()->make($class->name)->getConfigFilePath();
        $formConfig = json_decode(file_get_contents($configFilePath), true);


        $fields = [];
        foreach ($formConfig['columns'] as $column) {
            if (!isset($column['validate_deviation']) || !$column['validate_deviation']) {
                continue;
            }
            if (!$column['isEditable']) {
                continue;
            }

            $fields[] = [
                'code' => $column['code'],
                'table' => $column['table'],
                'column' => $column['column'],
                'additional_filter' => $column['additional_filter'] ?? [],
                'custom_period' => $column['validate_deviation_period'] ?? null
            ];
        }
        return $fields;
    }

    private function calculateLimits(array $fields)
    {
        $yesterday = CarbonImmutable::yesterday();
        foreach ($fields as $field) {
            $startDate = $yesterday->subMonthNoOverflow();
            if ($field['custom_period']) {
                $startDate = $yesterday->sub($field['custom_period']);
            }

            $query = DB::connection('tbd')
                ->table($field['table'])
                ->select('well_id', $field['column'])
                ->where('dbeg', '>=', $startDate)
                ->where('dbeg', '<=', $yesterday);

            if (!empty($field['additional_filter'])) {
                foreach ($field['additional_filter'] as $key => $value) {
                    $query->where($key, $value);
                }
            }

            $result = $query->get()
                ->groupBy('well_id')
                ->map(
                    function ($columnValues) use ($field) {
                        return $this->calculateFieldLimit($field, $columnValues);
                    }
                );

            $cacheKey = TableForm::getLimitsCacheKey($field, $yesterday);
            Cache::put($cacheKey, $result->toJson(), \Carbon\Carbon::now()->addDay());
        }
    }

    private function calculateFieldLimit(array $field, Collection $columnValues): array
    {
        if ($columnValues->count() <= 1) {
            return [];
        }

        $avg = $columnValues->sum($field['column']) / $columnValues->count();
        $deviation = $this->calcDeviation(
            $columnValues->pluck($field['column']),
            $avg
        );

        $min = $avg - $deviation * self::DEVIATION_COEFFICIENT;
        $max = $avg + $deviation * self::DEVIATION_COEFFICIENT;

        return $this->getRoundedValues($min, $max);
    }

    /**
     * Расчет среднеквадратичного отклонения
     */
    private function calcDeviation(Collection $collection, float $avg): float
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
