<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\UsdParse::class,
        \App\Console\Commands\OilParse::class,
        \App\Console\Commands\HiveDataFromAvocet::class,
        \App\Console\Commands\ReceiveNonOperatingAssets::class,
        \App\Console\Commands\ComplicationMonitoringEconomicCalculate::class,
        \App\Console\Commands\EmergencySituations::class,
        \App\Console\Commands\CalculateHydroDinamicGuUpsvYesterday::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('hive-data-from-avocet:cron')->dailyAt('08:35')->timezone('Asia/Almaty');
        $schedule->command('parse-usd:cron')->dailyAt('16:20')->timezone('Asia/Almaty');
        $schedule->command('parse-usd:cron')->dailyAt('18:30')->timezone('Asia/Almaty');
        $schedule->command('parse-oil:cron')->dailyAt('08:10')->timezone('Asia/Almaty');
        $schedule->command('form:calc_field_limits')->dailyAt('02:00')->timezone('Asia/Almaty');
        $schedule->command('receive-non-operating-email:cron')->dailyAt('07:40')->timezone('Asia/Almaty');
        $schedule->command('monitoring-economic-calc:cron')->dailyAt('03:00')->timezone('Asia/Almaty');
        $schedule->command('create-emergency:cron')->dailyAt('08:50')->timezone('Asia/Almaty');
        $schedule->command('calculate-hydro-yesterday:cron')
            ->dailyAt('06:00')
            ->timezone('Asia/Almaty');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
