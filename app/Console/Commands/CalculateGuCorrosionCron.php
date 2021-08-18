<?php

namespace App\Console\Commands;

use App\Http\Traits\CalculateGuCorrosionTrait;
use App\Models\ComplicationMonitoring\Gu;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CalculateGuCorrosionCron extends Command
{
    use CalculateGuCorrosionTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate-gu-corrosion:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate corrosion on point A for each GU for yesterday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->date = Carbon::yesterday()->format('Y-m-d');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::channel('calculate_corrosion_yesterday:cron')->info('Calculate  run');

        $gus = Gu::whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        Log::channel('calculate_corrosion_yesterday:cron')->info('Yesterday date ' . $this->date);

        foreach ($gus as $gu) {
            $message = $this->calculateCorrosion($gu);
            Log::channel('calculate_corrosion_yesterday:cron')->info($message);
        }

        Log::channel('calculate_corrosion_yesterday:cron')->info('Сalculation completed');
    }
}
