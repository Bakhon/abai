<?php

namespace App\Providers;

use App\Http\Middleware\LocaleMiddleware;
use App\Models\ComplicationMonitoring\Corrosion;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\OilGas;
use App\Models\ComplicationMonitoring\OmgCA;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\OmgUHE;
use App\Models\ComplicationMonitoring\Pipe;
use App\Models\ComplicationMonitoring\WaterMeasurement;
use App\Models\ComplicationMonitoring\Zu;
use App\Observers\CorrosionHistoryObserver;
use App\Observers\GuHistoryObserver;
use App\Observers\OilGasHistoryObserver;
use App\Observers\OmgCAHistoryObserver;
use App\Observers\OmgNGDUHistoryObserver;
use App\Observers\OmgUHEHistoryObserver;
use App\Observers\PipeHistoryObserver;
use App\Observers\WaterMeasurementHistoryObserver;
use App\Observers\ZuHistoryObserver;
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
        $this->app->bind(
            DruidClient::class,
            function ($app) {
                return new DruidClient(['router_url' => env('DRUID_ROUTER_URL')]);
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->observers();
        $this->setLanguages();
    }

    private function observers()
    {
        OmgCA::observe(
            [
                OmgCAHistoryObserver::class
            ]
        );
        OmgNGDU::observe(
            [
                OmgNGDUHistoryObserver::class
            ]
        );
        WaterMeasurement::observe(
            [
                WaterMeasurementHistoryObserver::class
            ]
        );
        OilGas::observe(
            [
                OilGasHistoryObserver::class
            ]
        );
        Corrosion::observe(
            [
                CorrosionHistoryObserver::class
            ]
        );
        OmgUHE::observe(
            [
                OmgUHEHistoryObserver::class
            ]
        );
        Pipe::observe(
            [
                PipeHistoryObserver::class
            ]
        );
        Gu::observe(
            [
                GuHistoryObserver::class
            ]
        );
        Zu::observe(
            [
                ZuHistoryObserver::class
            ]
        );
    }

    private function setLanguages()
    {

        $langDict = [
            'ru' => 'Рус',
            'kz' => 'Каз',
            'en' => 'Eng'
        ];

        $languages = [
            'current' => [
                'code' => LocaleMiddleware::getLocale(),
                'name' => $langDict[LocaleMiddleware::getLocale()]
            ],
            'list' => []
        ];

        foreach(\App\Http\Middleware\LocaleMiddleware::$languages as $lang) {
            if($lang === LocaleMiddleware::getLocale()) continue;

            $languages['list'][] = [
                'url' => str_replace(request()->getHttpHost().'/'.LocaleMiddleware::getLocale(), request()->getHttpHost()."/${lang}", url()->current()),
                'name' => $langDict[$lang]
            ];
        }

        \View::share('languages', $languages);
    }
}
