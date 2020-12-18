<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Level23\Druid\DruidClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DruidClient::class, function ($app) {
            return new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\ComplicationMonitoring\OmgCA::observe([
            \App\Observers\OmgCAHistoryObserver::class
        ]);
        \App\Models\ComplicationMonitoring\OmgNGDU::observe([
            \App\Observers\OmgNGDUHistoryObserver::class
        ]);
        \App\Models\ComplicationMonitoring\WaterMeasurement::observe([
            \App\Observers\WaterMeasurementHistoryObserver::class
        ]);
        \App\Models\ComplicationMonitoring\OilGas::observe([
            \App\Observers\OilGasHistoryObserver::class
        ]);
        \App\Models\ComplicationMonitoring\Corrosion::observe([
            \App\Observers\CorrosionHistoryObserver::class
        ]);
        \App\Models\ComplicationMonitoring\OmgUHE::observe([
            \App\Observers\OmgUHEHistoryObserver::class
        ]);
        \App\Models\ComplicationMonitoring\Pipe::observe([
            \App\Observers\PipeHistoryObserver::class
        ]);
    }
}
