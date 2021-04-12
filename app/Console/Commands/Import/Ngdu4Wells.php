<?php

namespace App\Console\Commands\Import;

use App\Imports\Ngdu4WellsImport;
use Illuminate\Console\Command;

class Ngdu4Wells extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:Ngdu4Wells {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import coordinates of wells in GUs from NGDU-4';

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
        $this->importExcel(new Ngdu4WellsImport($this));
    }
}
