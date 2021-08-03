<?php

namespace App\Console\Commands\BigData;

use App\Rules\ClassName;
use Carbon\Carbon;
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
    protected $formCode;
    protected $formName;

    protected $configFileName;

    public function handle()
    {
        $this->formType = $this->choice('Выберите тип формы', array_keys($this->formTypes));
        $this->formCode = $this->askFormCode();
        $this->formName = $this->ask('Укажите название формы');

        $this->configFileName = Str::snake($this->formCode);

        $this->generateFormMenuConfig();
        $this->generateFormConfig();
        $this->generateFormClass();
        $this->addFormToFormsList();
        $this->createPermissionsMigration();
        Artisan::call('migrate');
        Artisan::call('config:clear');
    }

    private function askFormCode(): string
    {
        $formCode = Str::ucfirst($this->ask('Укажите код формы (в CamelCase, например FluidProduction)'));

        if (!$this->isformCodeValid($formCode)) {
            $this->error('Некорректно указан код формы');
            $formCode = $this->askFormCode();
        }

        if ($this->isFormExists($formCode)) {
            $this->error('Форма с указанным кодом уже существует');
            $formCode = $this->askFormCode();
        }

        return $formCode;
    }

    private function isformCodeValid(string $formCode): bool
    {
        $validator = Validator::make(
            ['class_name' => $formCode],
            [
                'class_name' => [new ClassName()]
            ]
        );
        if ($validator->fails()) {
            return false;
        }

        if ($formCode != Str::ucfirst(Str::camel($formCode))) {
            return false;
        }
        return true;
    }

    private function isFormExists($formCode): bool
    {
        return class_exists("\App\Services\BigData\Forms\\$formCode");
    }

    private function generateFormConfig(): void
    {
        $configPath = resource_path("/params/bd/forms/") . "{$this->configFileName}.json";
        if (File::exists($configPath)) {
            $this->error('Форма с таким названием уже существует');
        }

        $templateFile = $this->formType === 'Простая' ? 'plainFormConfigTemplate' : 'tableFormConfigTemplate';
        $text = File::get(__DIR__ . "/Templates/{$templateFile}");
        File::put($configPath, $text);
    }

    private function generateFormMenuConfig(): void
    {
        $configFile = resource_path("/js/json/bd/") . "forms.json";
        $menu = json_decode(File::get($configFile), true);
        $menu[] = [
            "code" => Str::snake($this->formCode),
            "name" => $this->formName,
            "ico" => "<svg width='56' height='56' viewBox='0 0 56 56' fill='none' xmlns='http://www.w3.org/2000/svg'><rect width='56' height='56' rx='16' fill='#333975'/><path d='M33.9176 26.5098C35.7975 26.5098 37.3332 24.9673 37.3332 23.085C37.3332 21.3333 34.606 18.1699 34.2882 17.8301C34.1823 17.7255 34.0499 17.6732 33.9176 17.6732C33.7852 17.6732 33.6263 17.7255 33.5469 17.8301C33.2291 18.1699 30.502 21.3333 30.502 23.085C30.502 24.9673 32.0377 26.5098 33.9176 26.5098ZM32.5407 23.7386C32.6996 23.5294 33.0173 23.5033 33.2291 23.6601C33.3086 23.7124 33.944 24.183 34.606 23.6601C34.8178 23.5033 35.1355 23.5294 35.2944 23.7386C35.4533 23.9477 35.4268 24.2615 35.215 24.4183C34.7913 24.7582 34.3412 24.8628 33.944 24.8628C33.3615 24.8628 32.8585 24.6275 32.5937 24.4183C32.3819 24.2615 32.3554 23.9477 32.5407 23.7386Z' fill='#9EA4C9'/><path d='M21.1019 23.5555C22.4258 23.5555 23.4849 22.4836 23.4849 21.1503C23.4849 19.9215 21.5785 17.7255 21.3402 17.464C21.2873 17.3856 21.1814 17.3333 21.0755 17.3333C20.9696 17.3333 20.8901 17.3856 20.8107 17.464C20.5989 17.6993 18.666 19.9215 18.666 21.1503C18.719 22.4836 19.8046 23.5555 21.1019 23.5555ZM20.1488 21.6209C20.2811 21.464 20.493 21.4379 20.6254 21.5686C20.6783 21.6209 21.1284 21.9346 21.5785 21.5686C21.7374 21.4379 21.9492 21.464 22.0551 21.6209C22.1875 21.7778 22.1611 21.9869 22.0022 22.0915C21.7109 22.3268 21.3932 22.4052 21.1019 22.4052C20.7048 22.4052 20.3341 22.2222 20.1488 22.0915C20.0428 21.9869 20.0164 21.7516 20.1488 21.6209Z' fill='#9EA4C9'/><path d='M26.8748 38.6667C30.5817 38.6667 33.6266 35.6863 33.6266 32C33.6266 28.4444 27.5103 21.6209 27.2455 21.3333C27.1396 21.2287 27.0072 21.1765 26.8748 21.1765C26.7424 21.1765 26.61 21.2287 26.5041 21.3333C26.2394 21.6209 20.123 28.4444 20.123 32C20.123 35.6863 23.1415 38.6667 26.8748 38.6667ZM23.2209 33.4902C23.5916 33.2287 24.1212 33.3333 24.3595 33.6993C24.4124 33.7516 25.2332 34.9019 26.8219 34.9019H26.8483C28.4899 34.8758 29.3637 33.6993 29.3637 33.6993C29.6285 33.3333 30.1316 33.2287 30.5022 33.4902C30.8729 33.7516 30.9788 34.2483 30.7141 34.6144C30.6611 34.6928 29.3637 36.5229 26.8483 36.5229C26.8219 36.5229 26.8219 36.5229 26.7954 36.5229C24.28 36.5229 23.0091 34.6666 22.9561 34.5882C22.7178 34.2483 22.8238 33.7516 23.2209 33.4902Z' fill='#9EA4C9'/></svg>",
            "type" => $this->formType === 'Простая' ? 'plain' : 'table',
            "isVisible" => true
        ];

        File::put($configFile, json_encode($menu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    private function generateFormClass(): void
    {
        $text = File::get(__DIR__ . '/Templates/formClassTemplate');
        $text = str_replace(
            [
                '#className#',
                '#parentClass#',
                '#configFileName#'
            ],
            [
                $this->formCode,
                $this->formTypes[$this->formType],
                $this->configFileName
            ],
            $text
        );

        File::put(app_path() . "/Services/BigData/Forms/{$this->formCode}.php", $text);
    }

    private function addFormToFormsList(): void
    {
        $formsList = config('bigdata_forms');
        $formsList[$this->configFileName] = "\App\Services\BigData\Forms\\$this->formCode";
        File::put(
            config_path() . '/bigdata_forms.php',
            '<?php return ' . var_export($formsList, true) . ';'
        );
    }

    private function createPermissionsMigration()
    {
        $permissions = $this->generatePermissions();

        $migrationClassName = "AddPermissionsTo{$this->formCode}Form";
        $migrationFileName = Carbon::now()->format('Y_m_d_His') . '_' . Str::snake($migrationClassName) . '.php';

        $text = File::get(__DIR__ . '/Templates/permissionsMigrationTemplate');
        $text = str_replace(
            [
                '#MIGRATION_CLASS_NAME#',
                '#PERMISSIONS#'
            ],
            [
                $migrationClassName,
                json_encode($permissions)
            ],
            $text
        );

        File::put(database_path('migrations/' . $migrationFileName), $text);
    }

    private function generatePermissions(): array
    {
        $actions = [
            'list',
            'create',
            'edit',
            'history',
            'delete',
        ];
        $permissions = [];

        foreach ($actions as $action) {
            $permissions[] = [
                'name' => 'bd forms ' . $this->configFileName . ' ' . $action,
                'guard_name' => 'web'
            ];
        }

        return $permissions;
    }
}