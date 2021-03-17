<?php

namespace App\Console\Commands\BigData;

use App\Rules\ClassName;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GenerateForm extends Command
{
    protected $signature = 'form:generate';

    protected $description = 'Command description';

    protected $formTypes = [
        'Простая' => 'PlainForm',
        'Табличная' => 'TableForm'
    ];

    protected $formType;

    protected $formName;

    protected $configFileName;

    public function handle()
    {
        $this->formType = $this->choice('Выберите тип формы', array_keys($this->formTypes));
        $this->formName = $this->askFormName();
        $this->configFileName = Str::snake($this->formName);

        $this->generateFormConfig();
        $this->generateFormClass();
        $this->addFormToFormsList();
        Artisan::call('config:clear');
    }

    private function askFormName()
    {
        $formName = Str::ucfirst($this->ask('Укажите название формы (в CamelCase, например FluidProduction)'));

        if (!$this->isFormNameValid($formName)) {
            $this->error('Некорректно указано название формы');
            $formName = $this->askFormName();
        }

        if (!$this->isFormExists($formName)) {
            $this->error('Форма с указанным названием уже существует');
            $formName = $this->askFormName();
        }

        return $formName;
    }

    private function isFormNameValid(string $formName): bool
    {
        $validator = Validator::make(
            ['class_name' => $formName],
            [
                'class_name' => [new ClassName()]
            ]
        );
        if ($validator->fails()) {
            return false;
        }

        if ($formName != Str::ucfirst(Str::camel($formName))) {
            return false;
        }
        return true;
    }

    private function isFormExists($formName)
    {
        if (class_exists("\App\Services\BigData\Forms\\$formName")) {
            return false;
        }
        return true;
    }

    private function generateFormConfig()
    {
        $configPath = resource_path("/params/bd/forms/") . "{$this->configFileName}.json";
        if (File::exists($configPath)) {
            $this->error('Форма с таким названием уже существует');
        }

        $templateFile = $this->formType === 'Простая' ? 'plainFormConfigTemplate' : 'tableFormConfigTemplate';
        $text = File::get(__DIR__ . "/Templates/{$templateFile}");
        File::put($configPath, $text);
    }

    private function generateFormClass()
    {
        $text = File::get(__DIR__ . '/Templates/formClassTemplate');
        $text = str_replace(
            [
                '#className#',
                '#parentClass#',
                '#configFileName#'
            ],
            [
                $this->formName,
                $this->formTypes[$this->formType],
                $this->configFileName
            ],
            $text
        );

        File::put(app_path() . "/Services/BigData/Forms/{$this->formName}.php", $text);
    }

    private function addFormToFormsList()
    {
        $formsList = config('bigdata_forms');
        $formsList[$this->configFileName] = "\App\Services\BigData\Forms\\$this->formName";
        File::put(
            config_path() . '/bigdata_forms.php',
            '<?php return ' . var_export($formsList, true) . ';'
        );
    }
}