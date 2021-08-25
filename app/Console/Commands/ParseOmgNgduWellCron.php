<?php

namespace App\Console\Commands;

use App\Models\ComplicationMonitoring\AbaiprotZu;
use App\Traits\ParseOmgNgduWellTrait;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ParseOmgNgduWellCron extends Command
{
    use ParseOmgNgduWellTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse_omg_ngdu_well_data:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse data from abaiprot scheme cmon table zu to omg_ngdu_well table';

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
        Log::channel('parse_omg_ngdu_well_data:cron')->info('Parse run');

        $yesterday = Carbon::yesterday()->format('Y-m-d');
        Log::channel('parse_omg_ngdu_well_data:cron')->info('yesterday is '.$yesterday);

        $abaiprotZus = AbaiprotZu::where('__time', '>=', $yesterday)->get();
        $this->parseOmgNgduWellData($abaiprotZus);

        foreach ($this->errors as $error) {
            Log::channel('parse_omg_ngdu_well_data:cron')->error($error);
        }
        Log::channel('parse_omg_ngdu_well_data:cron')->info('Parse finished');
    }
}
