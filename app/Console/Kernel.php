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
        \App\Console\Commands\HiveDataFromAvoset::class,
        \App\Console\Commands\receiveNonOperatingAssets::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('hive-data-from-avoset:cron')->dailyAt('08:10')->timezone('Asia/Almaty');
        $schedule->command('hive-data-from-avoset:cron')->dailyAt('11:30')->timezone('Asia/Almaty');
        $schedule->command('parse-usd:cron')->dailyAt('16:20')->timezone('Asia/Almaty');
        $schedule->command('parse-usd:cron')->dailyAt('18:30')->timezone('Asia/Almaty');
        $schedule->command('parse-oil:cron')->dailyAt('08:10')->timezone('Asia/Almaty');

        $schedule->command('form:calc_field_limits')->dailyAt('02:00')->timezone('Asia/Almaty');
        $schedule->command('receive-non-operating-email:cron')->dailyAt('03:33')->timezone('Asia/Almaty')->appendOutputTo(storage_path('logs/inspire.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
