<?php

namespace App\Console\Commands\Import;

use App\Imports\TrunklineImport;
use Illuminate\Console\Command;

class ImportTrunkline extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:Trunkline {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import coordinates of trunkline';

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
        $this->importExcel(new TrunklineImport($this), base_path($this->argument('path')));
    }
}
