<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Command;
use App\Imports\GuWellsImport;

class Wells extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:wells {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import coordinates of wells in GUs';

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
        $this->importExcel(new GuWellsImport($this), base_path($this->argument('path')));
    }
}
