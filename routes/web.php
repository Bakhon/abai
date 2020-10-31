<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect('/'. App\Http\Middleware\LocaleMiddleware::$mainLanguage);
});



Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function() {
    Route::group(['middleware' => 'auth'], function () {
        Route::get("/geteconimicdata", "EconomicController@getEconomicData");
        Route::get("/getcurrency", "DruidController@getCurrency");
        Route::get("/getcurrencyperiod", "DruidController@getCurrencyPeriod");
        Route::get('/', function () {
            return view('welcome');
        });
        Route::get('/druid', 'DruidController@index');
        Route::get('/oilprice', 'DruidController@getOilPrice');
        Route::get('/getnkkmg', 'DruidController@getNkKmg');
        Route::get('/getwelldailyoil', 'DruidController@getWellDailyOil');
        Route::get('/getnkkmgyear', 'DruidController@getNkKmgYear');
        Route::get('/economic', 'EconomicController@index')->name('economic');
        Route::get('/economicpivot', 'EconomicController@economicPivot')->name('economicpivot');
        Route::get('/oilpivot', 'EconomicController@oilPivot')->name('oilpivot');
        Route::get('/geteconomicpivotdata', 'EconomicController@getEconomicPivotData')->name('geteconomicpivotdata');
        Route::get('/getoilpivotdata', 'EconomicController@getOilPivotData')->name('getoilpivotdata');
        Route::get('/visualcenter', 'DruidController@visualcenter')->name('visualcenter');
        Route::get('/visualcenter2', 'DruidController@visualcenter2')->name('visualcenter2');
        Route::get('/visualcenter3', 'DruidController@visualcenter3')->name('visualcenter3');
        Route::get('/podborgno', 'DruidController@gno')->name('gno');
        Route::get('/monitor', 'DruidController@monitor')->name('monitor');
        Route::get('/production', 'DruidController@production')->name('production');
        Route::get('/gtmscor', 'DruidController@gtmscor')->name('gtmscor');
        Route::get('/calcgtm', 'DruidController@calcGtm')->name('calcgtm');
        Route::get('/mfond', 'DruidController@mfond')->name('mfond');
        Route::get('/map', 'DruidController@map')->name('map');
        Route::get('/oil', 'DruidController@oil')->name('oil');
        Route::get('/facilities', 'DruidController@facilities')->name('facilities');
        Route::get('/liquid', 'DruidController@liquid')->name('liquid');
        Route::get('/hydraulics', 'DruidController@hydraulics')->name('hydraulics');
        Route::get('/complications', 'DruidController@complications')->name('complications');
        Route::get('/tabs', 'DruidController@tabs')->name('tabs');
        Auth::routes();
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/maps', 'DruidController@maps')->name('maps');
        Route::get('/mzdn', 'DruidController@mzdn')->name('mzdn');
        Route::get('/bigdata', 'DruidController@bigdata')->name('bigdata');
        Route::get('/constructor', 'DruidController@constructor')->name('constructor');
        Route::get('/export', 'HomeController@export');


        //wm
        Route::resource('watermeasurement','ComplicationMonitoring\WaterMeasurementController');
        Route::get('/getotherobjects', 'ComplicationMonitoring\WaterMeasurementController@getOtherObjects');
        Route::get('/getngdu', 'ComplicationMonitoring\WaterMeasurementController@getNgdu');
        Route::get('/getcdng', 'ComplicationMonitoring\WaterMeasurementController@getCdng');
        Route::post('/getgu', 'ComplicationMonitoring\WaterMeasurementController@getGu');
        Route::post('/getzu', 'ComplicationMonitoring\WaterMeasurementController@getZu');
        Route::post('/getwell', 'ComplicationMonitoring\WaterMeasurementController@getWell');
        Route::get('/getwbs', 'ComplicationMonitoring\WaterMeasurementController@getWaterBySulin');
        Route::get('/getsrb', 'ComplicationMonitoring\WaterMeasurementController@getSulphateReducingBacteria');
        Route::get('/gethob', 'ComplicationMonitoring\WaterMeasurementController@getHydrocarbonOxidizingBacteria');
        Route::get('/gethb', 'ComplicationMonitoring\WaterMeasurementController@getThionicBacteria');
        Route::post('/getwm', 'ComplicationMonitoring\WaterMeasurementController@getWm');
        Route::get('/getallgus', 'ComplicationMonitoring\WaterMeasurementController@getAllGu');
        Route::get('/getallkormasses', 'ComplicationMonitoring\WaterMeasurementController@getAllKormasses');
        Route::post('/getgudata', 'ComplicationMonitoring\WaterMeasurementController@getGuData');
        Route::post('/getgudatabyday', 'ComplicationMonitoring\OmgNGDUController@getGuDataByDay');
        Route::post('/updatewm', 'ComplicationMonitoring\WaterMeasurementController@update')->name('updatewm');
        Route::resource('omgca','ComplicationMonitoring\OmgCAController');
        Route::resource('omguhe','ComplicationMonitoring\OmgUHEController');
        Route::resource('omgngdu','ComplicationMonitoring\OmgNGDUController');
        Route::post('/getgucdngngdufield', 'ComplicationMonitoring\WaterMeasurementController@getGuNgduCdngField');


        //gno economic
        Route::resource('ecorefscompaniesids','EcoRefsCompaniesIdsController');
        Route::resource('ecorefsdirection','EcoRefsDirectionController');
        Route::resource('ecorefsrouteid','EcoRefsRouteIdController');
        Route::resource('ecorefsroutetnid','EcoRefsRouteTnIdController');
        Route::resource('ecorefsequipid','EcoRefsEquipIdController');
        Route::resource('ecorefsannualprodvolume','EcoRefsAnnualProdVolumeController');
        Route::resource('ecorefsrenttax','EcoRefsRentTaxController');
        Route::resource('ecorefsavgmarketprice','EcoRefsAvgMarketPriceController');
        Route::resource('ecorefsdiscontcoefbar','EcoRefsDiscontCoefBarController');
        Route::resource('ecorefsbranchid','EcoRefsBrachIdController');
        Route::resource('ecorefsrentequipelectservcost','EcoRefsRentEquipElectServCostController');
        Route::resource('ecorefsservicetime','EcoRefsServiceTimeController');
        Route::resource('ecorefsndorates','EcoRefsNdoRatesController');
        Route::resource('ecorefselectprsbrigcost','EcoRefsPrepElectPrsBrigCostController');
        Route::resource('ecorefstarifytn','EcoRefsTarifyTnController');
        Route::resource('ecorefsmacro','EcoRefsMacroController');
        Route::post('/getkormass', 'OmgNGDUController@getKormass');
        Route::resource('ecorefsempper','Refs\EcoRefsEmpPerController');
        Route::resource('ecorefsscfa','Refs\EcoRefsScFaController');
        Route::get('ecorefslist','Refs\EcoRefsScFaController@refsList');
        Route::get('nnoeco','Refs\EcoRefsScFaController@nnoeco');
        Route::resource('ecorefsexc','EcoRefsExcController');
        Route::resource('antiecoone','AntiCrisis\AntiEcoOneController');
        Route::resource('antiecotwo','AntiCrisis\AntiEcoTwoController');
    });
    Auth::routes([
        'reset' => false,
        'verify' => false,
        'register' => false,
    ]);
});

Route::get('setlocale/{lang}', function ($lang) {
    $referer = Redirect::back()->getTargetUrl();
    $parse_url = parse_url($referer, PHP_URL_PATH);
    $segments = explode('/', $parse_url);

    if (in_array($segments[1], App\Http\Middleware\LocaleMiddleware::$languages)) {
        unset($segments[1]);
    }

    array_splice($segments, 1, 0, $lang);
    $url = Request::root().implode("/", $segments);

    if(parse_url($referer, PHP_URL_QUERY)){
        $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
    }

    return redirect($url);
})->name('setlocale');


