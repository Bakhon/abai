<?php

namespace App\Console\Commands\Import;

use App\Imports\MissedWellsImport;
use Illuminate\Console\Command;

class MissedWells extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:missed_wells';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import missed wells';

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
        $this->importExcel(new MissedWellsImport($this), public_path('imports/missed_wells.xlsx'));
    }
}
