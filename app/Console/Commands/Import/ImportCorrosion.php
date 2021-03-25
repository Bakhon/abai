<?php

namespace App\Console\Commands\Import;

use App\Imports\CorrosionImport;
use Illuminate\Console\Command;
use App\Models\ComplicationMonitoring\Corrosion;
use Maatwebsite\Excel\Facades\Excel;

class ImportCorrosion extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:corrosion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import corrosion speed';

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
        $this->output->title('Start Import corrosion speed');
        Corrosion::truncate();
        Excel::import(new CorrosionImport(), public_path('corrosion.xlsx'));
        $this->info('Import corrosion speed finished');

    }
}
