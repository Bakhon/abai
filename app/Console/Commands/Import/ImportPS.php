<?php

namespace App\Console\Commands\Import;

use App\Imports\ImportPsPipesObjects;
use Illuminate\Console\Command;

class ImportPS extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:ps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import PS pipes and objects';

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
    public function handle(): void
    {
        activity()->disableLogging();

        $this->importExcel(new ImportPsPipesObjects($this), public_path('imports/ps_pipes_and_objects.xlsx'));
    }
}
