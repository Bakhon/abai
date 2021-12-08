<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('/tkrsMain', 'DigitalMonitoringWellInterventionAndWorkover\DigitalMonitoringWellInterventionAndWorkoverController@tkrsMain')->name('tkrsMain');
                Route::get('/hookWeightSensor', 'DigitalMonitoringWellInterventionAndWorkover\DigitalMonitoringWellInterventionAndWorkoverController@hookWeightSensor')->name('hookWeightSensor');
                Route::get('/hookWeightSensorAnalyse', 'DigitalMonitoringWellInterventionAndWorkover\DigitalMonitoringWellInterventionAndWorkoverController@hookWeightSensorAnalyse')->name('hookWeightSensorAnalyse');
                Route::get('/gps', 'DigitalMonitoringWellInterventionAndWorkover\DigitalMonitoringWellInterventionAndWorkoverController@gps')->name('gps');
                Route::get('/video', 'DigitalMonitoringWellInterventionAndWorkover\DigitalMonitoringWellInterventionAndWorkoverController@gps')->name('video');
                Route::get('/videoSurveillance', 'DigitalMonitoringWellInterventionAndWorkover\DigitalMonitoringWellInterventionAndWorkoverController@videoSurveillance')->name('videoSurveillance');
                Route::get('/gpsPositioning', 'DigitalMonitoringWellInterventionAndWorkover\DigitalMonitoringWellInterventionAndWorkoverController@gpsPositioning')->name('gpsPositioning');
            }
        );
    }
);