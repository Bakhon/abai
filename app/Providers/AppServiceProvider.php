<?php

namespace App\Providers;

use App\Http\Middleware\LocaleMiddleware;
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
                return new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);
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
        \App\Models\ComplicationMonitoring\OmgCA::observe(
            [
                \App\Observers\OmgCAHistoryObserver::class
            ]
        );
        \App\Models\ComplicationMonitoring\OmgNGDU::observe(
            [
                \App\Observers\OmgNGDUHistoryObserver::class
            ]
        );
        \App\Models\ComplicationMonitoring\WaterMeasurement::observe(
            [
                \App\Observers\WaterMeasurementHistoryObserver::class
            ]
        );
        \App\Models\ComplicationMonitoring\OilGas::observe(
            [
                \App\Observers\OilGasHistoryObserver::class
            ]
        );
        \App\Models\ComplicationMonitoring\Corrosion::observe(
            [
                \App\Observers\CorrosionHistoryObserver::class
            ]
        );
        \App\Models\ComplicationMonitoring\OmgUHE::observe(
            [
                \App\Observers\OmgUHEHistoryObserver::class
            ]
        );
        \App\Models\ComplicationMonitoring\Pipe::observe(
            [
                \App\Observers\PipeHistoryObserver::class
            ]
        );
        \App\Models\Refs\Gu::observe(
            [
                \App\Observers\GuHistoryObserver::class
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
