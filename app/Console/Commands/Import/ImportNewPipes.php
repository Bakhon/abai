<?php

namespace App\Console\Commands\Import;

use App\Imports\NewPipesImport;
use Illuminate\Console\Command;

class ImportNewPipes extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:new_pipes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import new pipes';

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
        $this->importExcel(new NewPipesImport($this), public_path('imports/new_pipes.xlsx'));
    }
}
