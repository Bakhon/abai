<?php
Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(['prefix' => '/digital-drilling'], function () {
            // BD
            Route::group(['prefix' => '/bd'], function () {
                Route::get('/',                 'DigitalDrilling\BDController@index')->name('digital-drilling-home');
                Route::get('/info',             'DigitalDrilling\BDController@info')->name('digital-drilling-info');
                Route::get('/passport',         'DigitalDrilling\BDController@passport')->name('digital-drilling-passport');
                Route::get('/gis',              'DigitalDrilling\BDController@gis')->name('digital-drilling-gis');
                Route::get('/structure',        'DigitalDrilling\BDController@structure')->name('digital-drilling-structure');
                Route::get('/structure-graph',  'DigitalDrilling\BDController@structureGraph')->name('digital-drilling-structure-graph');
                Route::get('/inclino',          'DigitalDrilling\BDController@inclino')->name('digital-drilling-inclino');
                Route::get('/inclino-graph',    'DigitalDrilling\BDController@inclinoGraph')->name('digital-drilling-inclino-graph');
                Route::get('/project-data',     'DigitalDrilling\BDController@projectData')->name('digital-drilling-project-data');
            });

            // Project
            Route::group(['prefix' => '/project'], function () {
                Route::get('/well-profile',         'DigitalDrilling\ProjectController@wellProfile')->name('digital-drilling-well-profile');
                Route::get('/well-profile-graph',   'DigitalDrilling\ProjectController@wellProfileGraph')->name('digital-drilling-well-profile-graph');
                Route::get('/calculation',          'DigitalDrilling\ProjectController@calculation')->name('digital-drilling-calculation');
                Route::get('/calculation-graph',    'DigitalDrilling\ProjectController@calculationGraph')->name('digital-drilling-calculation-graph');
                Route::get('/rasters',              'DigitalDrilling\ProjectController@rasters')->name('digital-drilling-rasters');
                Route::get('/rasters-params',       'DigitalDrilling\ProjectController@rastersParams')->name('digital-drilling-rasters-params');
                Route::get('/rasters-component',    'DigitalDrilling\ProjectController@rastersComponent')->name('digital-drilling-rasters-component');
                Route::get('/deepening',            'DigitalDrilling\ProjectController@deepening')->name('digital-drilling-deepening');
                Route::get('/deepening-graph',      'DigitalDrilling\ProjectController@deepeningGraph')->name('digital-drilling-deepening-graph');
                Route::get('/deepening-params',     'DigitalDrilling\ProjectController@deepeningParams')->name('digital-drilling-deepening-params');
                Route::get('/fastening',            'DigitalDrilling\ProjectController@fastening')->name('digital-drilling-fastening');
                Route::get('/fastening-page2',      'DigitalDrilling\ProjectController@fasteningPage2')->name('digital-drilling-fastening-page2');
                Route::get('/fastening-page3',      'DigitalDrilling\ProjectController@fasteningPage3')->name('digital-drilling-fastening-page3');
                Route::get('/fastening-page4',      'DigitalDrilling\ProjectController@fasteningPage4')->name('digital-drilling-fastening-page4');
                Route::get('/fastening-page5',      'DigitalDrilling\ProjectController@fasteningPage5')->name('digital-drilling-fastening-page5');
                Route::get('/fastening-page6',      'DigitalDrilling\ProjectController@fasteningPage6')->name('digital-drilling-fastening-page6');
                Route::get('/fastening-page7',      'DigitalDrilling\ProjectController@fasteningPage7')->name('digital-drilling-fastening-page7');
            });

            // Online
            Route::group(['prefix' => '/online'], function () {
                Route::get('/alarm',        'DigitalDrilling\OnlineController@alarm')->name('digital-drilling-alarm');
                Route::get('/geo-first',    'DigitalDrilling\OnlineController@geoFirst')->name('digital-drilling-geo-first');
                Route::get('/geo-second',   'DigitalDrilling\OnlineController@geoSecond')->name('digital-drilling-geo-second');
                Route::get('/geo-third',    'DigitalDrilling\OnlineController@geoThird')->name('digital-drilling-geo-third');
                Route::get('/sector',       'DigitalDrilling\OnlineController@sector')->name('digital-drilling-sector');
                Route::get('/visual',       'DigitalDrilling\OnlineController@visual')->name('digital-drilling-visual');
                Route::get('/report1',      'DigitalDrilling\OnlineController@report1')->name('digital-drilling-report1');
                Route::get('/report2',      'DigitalDrilling\OnlineController@report2')->name('digital-drilling-report2');
            });

            // Supervising
            Route::group(['prefix' => '/supervising'], function () {
                Route::get('/alarm',            'DigitalDrilling\SupervisingController@alarm')->name('digital-drilling-alarm');
                Route::get('/reports',          'DigitalDrilling\SupervisingController@reports')->name('digital-drilling-reports');
                Route::get('/balance',          'DigitalDrilling\SupervisingController@balance')->name('digital-drilling-balance');
                Route::get('/balance-second',   'DigitalDrilling\SupervisingController@balanceSecond')->name('digital-drilling-balance-second');
                Route::get('/balance-third',    'DigitalDrilling\SupervisingController@balanceThird')->name('digital-drilling-balance-third');
                Route::get('/fact',             'DigitalDrilling\SupervisingController@fact')->name('digital-drilling-fact');
                Route::get('/npv',              'DigitalDrilling\SupervisingController@npv')->name('digital-drilling-npv');
                Route::get('/akc',              'DigitalDrilling\SupervisingController@akc')->name('digital-drilling-akc');
            });

            // Analytics
            Route::group(['prefix' => '/analytics'], function () {
                Route::get('/deepening-inclino',    'DigitalDrilling\AnalyticsController@deepeningInclino')->name('digital-drilling-analytics-deepening-inclino');
                Route::get('/deepening-visual',     'DigitalDrilling\AnalyticsController@deepeningVisual')->name('digital-drilling-analytics-deepening-visual');
                Route::get('/deepening-knbk',       'DigitalDrilling\AnalyticsController@deepeningKnbk')->name('digital-drilling-analytics-deepening-knbk');
                Route::get('/deepening-params',     'DigitalDrilling\AnalyticsController@deepeningParams')->name('digital-drilling-analytics-deepening-params');
                Route::get('/deepening-bur',        'DigitalDrilling\AnalyticsController@deepeningBur')->name('digital-drilling-analytics-deepening-bur');
                Route::get('/deepening-gidro',      'DigitalDrilling\AnalyticsController@deepeningGidro')->name('digital-drilling-analytics-deepening-gidro');
                Route::get('/deepening-sorting',    'DigitalDrilling\AnalyticsController@deepeningSorting')->name('digital-drilling-analytics-deepening-sorting');
                Route::get('/deepening-selection',  'DigitalDrilling\AnalyticsController@deepeningSelection')->name('digital-drilling-analytics-deepening-selection');
                Route::get('/fastening-first',      'DigitalDrilling\AnalyticsController@fasteningFirst')->name('digital-drilling-analytics-fastening-first');
                Route::get('/fastening-second',     'DigitalDrilling\AnalyticsController@fasteningSecond')->name('digital-drilling-analytics-fastening-second');
                Route::get('/fastening-third',      'DigitalDrilling\AnalyticsController@fasteningThird')->name('digital-drilling-analytics-fastening-third');
                Route::get('/complications',        'DigitalDrilling\AnalyticsController@complications')->name('digital-drilling-analytics-complications');
                Route::get('/akc',                  'DigitalDrilling\AnalyticsController@akc')->name('digital-drilling-analytics-akc');
                Route::get('/balance',              'DigitalDrilling\AnalyticsController@balance')->name('digital-drilling-analytics-balance');
            });

            // Daily report
            Route::group(['prefix' => '/daily-report'], function () {
                Route::get('/', 'DigitalDrilling\DailyReportController@index')->name('digital-drilling-daily-report');
            });
        });
    });