<?php

namespace App\Console\Commands\Import;

use App\Imports\MissedTrunklineImport;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\PipeCoord;
use Illuminate\Console\Command;

class ImportMissedTrunkline extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:missed_trunkline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import missed trunkline pipes';

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

        $this->importExcel(new MissedTrunklineImport($this), public_path('imports/missed_trunkline.xlsx'));

        $pipes_ids = OilPipe::get()->pluck('id');
//        PipeCoord::whereNotIn('oil_pipe_id', $pipes_ids)->forceDelete();
    }
}
