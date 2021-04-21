<?php

namespace App\Console\Commands\BigData;

use App\Services\BigData\FieldLimitsService;
use App\Services\BigData\Forms\TableForm;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use ReflectionClass;

class CalculateFieldLimits extends Command
{
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

    protected $limitsService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FieldLimitsService $limitsService)
    {
        $this->limitsService = $limitsService;
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
            if (!$column['is_editable']) {
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
        $this->limitsService->calculate($fields, $yesterday);
    }
}
