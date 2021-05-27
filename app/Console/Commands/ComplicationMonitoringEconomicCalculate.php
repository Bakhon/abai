<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ComplicationMonitoringEconomicCalculate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitoring-economic-calc:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Complication monitoring economic calculation';

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
        //
    }

    public function getData(){
        //
    }

    public function calc() {
        //
    }

    public function addToDB(){
        //
    }
}
