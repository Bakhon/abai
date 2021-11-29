<?php

namespace App\Console\Commands\Import;

use App\Imports\BGsImport;
use App\Models\ComplicationMonitoring\BG;
use Illuminate\Console\Command;

class ImportBGs extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:bgs_points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Import BG's points";

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
        BG::truncate();
        $this->importExcel(new BGsImport($this), public_path('imports/bgs.xlsx'));
    }
}
