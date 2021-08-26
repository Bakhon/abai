<?php

namespace App\Console\Commands;

use App\Models\ComplicationMonitoring\AbaiprotZu;
use App\Traits\ParseOmgNgduWellTrait;
use Illuminate\Console\Command;

class ParseOmgNgduWellData extends Command
{
    use ParseOmgNgduWellTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse_omg_ngdu_well_data';

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
        $this->output->title('Starting parse');

        $abaiprotZus = AbaiprotZu::where('__time', '>', '2021-06-30')->get();
        $this->parseOmgNgduWellData($abaiprotZus);
        foreach ($this->errors as $error) {
            $this->error($error);
        }
        $this->info('Parse finished');
    }
}
