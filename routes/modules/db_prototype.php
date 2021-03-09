<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth', 'prefix' => 'bigdata'],
            function () {
                Route::get('/', 'bd\DBController@bigdata')->name('bigdata');
                Route::get('/las', 'bd\DBController@las')->name('las');

                Route::get('/reports', 'bd\DBController@reports')->name('bigdata.reports');
                Route::get('/reports/favorite', 'bd\DBController@favoriteReports')->name('bigdata.reports.favorite');
                Route::post('/reports/favorite/{report}', 'bd\DBController@addReportToFavorites')->name(
                    'bigdata.reports.favorite.add'
                );
                Route::delete('/reports/favorite/{report}', 'bd\DBController@removeReportFromFavorites')->name(
                    'bigdata.reports.favorite.remove'
                );

                Route::get('/protoform', 'bd\DBController@form')->name('bigdata.protoform');
                Route::get('/mobileform', 'bd\DBController@mobileForm')->name('bigdata.form.mobile');
                Route::post('/mobileform', 'bd\FormsController@saveMobileForm');
                Route::get('/mobileform/values', 'bd\FormsController@getMobileFormValues');

                Route::get('form/{form}', 'bd\FormsController@getParams')->name('bigdata.form.params');
                Route::post('form/{form}', 'bd\FormsController@submit')->name('bigdata.form.send');
                Route::get('form/{form}/rows', 'bd\FormsController@getRows');
                Route::get('form/{form}/well-prefix', 'bd\FormsController@getWellPrefix');
                Route::post('form/{form}/validate/{field}', 'bd\FormsController@validateField')->name(
                    'bigdata.form.validate.field'
                );
                Route::patch('form/{form}/save/{field}', 'bd\FormsController@saveField')->name(
                    'bigdata.form.save.field'
                );
                Route::resource('wells', 'bd\WellsController', ['as' => 'bigdata']);
                Route::get('dict/geos/{org}', 'bd\DictionariesController@getGeoByOrg');
                Route::get('dict/{dict}', 'bd\DictionariesController@get')->name('bigdata.dictionary');
            }
        );
    }
);
