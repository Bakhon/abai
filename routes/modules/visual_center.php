<?php
Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('/visualcenter', 'VisCenter\VisualCenterController@visualcenter')->name('visualcenter');
                Route::get('/visualcenter2', 'VisCenter\VisualCenterController@visualcenter2')->name('visualcenter2');
                Route::get('/visualcenter3', 'VisCenter\VisualCenterController@visualcenter3')->name('visualcenter3');
                Route::get('/excelform', 'VisCenter\VisualCenterController@excelform')->name('excelform');
                Route::get('/visualcenter3GetData', 'VisCenter\VisualCenterController@visualcenter3GetData');
                Route::get('/visualcenter3GetDataOpec', 'VisCenter\VisualCenterController@visualcenter3GetDataOpec');
                Route::get('/visualcenter3GetDataStaff', 'VisCenter\VisualCenterController@visualcenter3GetDataStaff');
                Route::get('/visualcenter4', 'VisCenter\VisualCenterController@visualcenter4')->name('visualcenter4');
                Route::get('/visualcenter5', 'VisCenter\VisualCenterController@visualcenter5')->name('visualcenter5');
                Route::get('/visualcenter6', 'VisCenter\VisualCenterController@visualcenter6')->name('visualcenter6');
                Route::get('/visualcenter7', 'VisCenter\VisualCenterController@visualcenter7')->name('visualcenter7');
                Route::get('/getdzocalcs', 'VisCenter\VisualCenterController@getDZOcalcs')->name('getdzocalcs');
                Route::get('/getdzocalcsactualmonth', 'VisCenter\VisualCenterController@getDZOCalcsActualMonth')->name(
                    'getdzocalcsactualmonth'
                );
                Route::get("/getcurrency", "VisCenter\VisualCenterController@getCurrency");
                Route::get("/getcurrencyperiod", "VisCenter\VisualCenterController@getCurrencyPeriod");
                Route::get("/get-usd-rates", "VisCenter\VisualCenterController@getUsdRates");
                Route::get("/get-oil-rates", "VisCenter\VisualCenterController@getOilRates");
                Route::get("/get-dzo-monthly-plans", "VisCenter\VisualCenterController@getDzoMonthlyPlans");
                Route::get('/get-dzo-yearly-plan', 'VisCenter\VisualCenterController@getDzoYearlyPlan');

                Route::resource('marabkpiid', 'VisCenter\KPI\MarabKpiIdController');
                Route::resource('abdkpiid', 'VisCenter\KPI\AbdKpiIdController');
                Route::resource('typeid', 'VisCenter\KPI\TypeIdController');
                Route::resource('marab1', 'VisCenter\KPI\Marab1Controller');
                Route::resource('marab2', 'VisCenter\KPI\Marab2Controller');
                Route::resource('marab345', 'VisCenter\KPI\Marab345Controller');
                Route::resource('marab6', 'VisCenter\KPI\Marab6Controller');
                Route::resource('abd12', 'VisCenter\KPI\Abd12Controller');
                Route::resource('abd35', 'VisCenter\KPI\Abd35Controller');
                Route::resource('abd46', 'VisCenter\KPI\Abd46Controller');
                Route::resource('corpkpiid', 'VisCenter\KPI\CorpKpiIdController');
                Route::resource('corpall', 'VisCenter\KPI\CorpAllController');
                Route::get('kpicalc', 'VisCenter\KPI\Marab2Controller@kpicalculation');
                Route::get('kpiList', 'VisCenter\KPI\Marab2Controller@kpiList');

                Route::resource('viscenter2', 'VisCenter\InputForm\Vis2FormController');
                Route::resource('excelform2', 'VisCenter\InputForm\ExcelFormController');

                Route::get('/import_hist', 'VisCenter\ImportForms\DZOdayController@importExcel');
                Route::post('/import_h', 'VisCenter\ImportForms\DZOdayController@import')->name('import_h');

                Route::get('importdzoyear', 'VisCenter\ImportForms\DZOyearController@importExcel');

                Route::get('/import_econom', 'VisCenter\ImportForms\DZOcalcController@importExcel');
                Route::post('/import_eco', 'VisCenter\ImportForms\DZOcalcController@import')->name('import_e');

                Route::get('/import_excel', 'VisCenter\ImportForms\DZOdailyController@importExcel');
                Route::resource('/dzodaily', 'VisCenter\ImportForms\DZOdailyCrudController');

                Route::post('/import', 'VisCenter\ImportForms\DZOdailyController@import')->name('import');

                Route::get('/get-dzo-today-data', 'VisCenter\ExcelForm\ExcelFormController@getDzoCurrentData');
                Route::post('/dzo-excel-otm', 'VisCenter\ExcelForm\ExcelFormOtmController@store');
                Route::get('/get-dzo-current-chemistry', 'VisCenter\ExcelForm\ExcelFormChemistryController@getDzoCurrentChemistry');
                Route::get('/get-dzo-current-otm', 'VisCenter\ExcelForm\ExcelFormOtmController@getDzoCurrentOtm');
                Route::get('hive-data-from-avocet', function() {
                    Artisan::call('hive-data-from-avocet:cron');
                });
                Route::get('store-kgm-reports-from-avocet', function() {
                    Artisan::call('store-kgm-reports-from-avocet:cron');
                });
                Route::post('dzo-excel-form', 'VisCenter\ExcelForm\ExcelFormController@store');
                Route::post('dzo-chemistry-excel-form', 'VisCenter\ExcelForm\ExcelFormChemistryController@store');
                Route::get('/get-production-details', 'VisCenter\VisualCenterController@getProductionDetails');
                Route::get('/get-otm-details', 'VisCenter\VisualCenterController@getOtmDetails');
                Route::get('/get-chemistry-details', 'VisCenter\VisualCenterController@getChemistryDetails');
                Route::get('/get-drilling-details', 'VisCenter\VisualCenterController@getDrillingDetails');
                Route::get('/get-fond-details', 'VisCenter\VisualCenterController@getFondDetails');
                Route::get('/import-kgm-chemistry-and-repairs', 'VisCenter\VisualCenterController@storeKGMChemistryAndRepairsByMonth');
                Route::get('/daily-report', 'VisCenter\VisualCenterController@dailyReport')->name('daily-report');
                Route::get('/get-production-for-year', 'VisCenter\VisualCenterController@getProductionDetailsForYear');
                Route::get('/get-emergency-history', 'VisCenter\VisualCenterController@getEmergencyHistory');
                Route::get('/get-historical-production', 'VisCenter\VisualCenterController@getHistoricalProductionByDzo');
                Route::get('/import-kgm-reports-from-avocet', 'VisCenter\VisualCenterController@storeKGMReportsFromAvocetByDay');
            }
        );
    }
);
