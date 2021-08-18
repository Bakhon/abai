<?php

namespace App\Console\Commands;

use App\Http\Traits\CalculateGuCorrosionTrait;
use App\Models\ComplicationMonitoring\Gu;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;

class CalculateGuCorrosionBetweenDates extends Command
{
    use CalculateGuCorrosionTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculateGuCorrosion {date_start} {date-end}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate corrosion on point A for each GU for date range';

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
        $period = CarbonPeriod::create($this->argument('date_start'), $this->argument('date-end'));

        $gus = Gu::whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        foreach ($period as $date) {
            $this->date = $date->format('Y-m-d');

            $this->line(' ');
            $this->line('----------------------------');
            $this->info('Processing '.$this->date);
            $this->line('----------------------------');
            $this->line(' ');

            foreach ($gus as $gu) {
                $message = $this->calculateCorrosion($gu);
                $this->info($message);
            }
        }

        $this->output->success('Сalculation completed');
    }
}
