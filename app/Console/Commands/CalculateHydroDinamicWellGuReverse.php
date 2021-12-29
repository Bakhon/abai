<?php

namespace App\Console\Commands;

use App\Jobs\ReverseCalculateHydroDynamics;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CalculateHydroDinamicWellGuReverse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate_hydro_reverse_yesterday:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Расчитать гидро динамику обратным ходом на вчерашнюю дату';

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
        Log::channel('calculate_hydro_reverse_yesterday:cron')->info('Calculate  run');
        $input = [
            'date' => Carbon::yesterday()->format('Y-m-d'),
            'cron' => true
        ];

        ReverseCalculateHydroDynamics::dispatch($input);
    }
}
