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
        Route::resource('oildaily','OilDailyController');
        Route::get('/maps', 'DruidController@maps')->name('maps');
        Route::get('/mzdn', 'DruidController@mzdn')->name('mzdn');
        Route::get('/bigdata', 'DruidController@bigdata')->name('bigdata');
        Route::get('/constructor', 'DruidController@constructor')->name('constructor');


        //wm
        Route::resource('watermeasurement','WaterMeasurementController');
        Route::get('/getotherobjects', 'WaterMeasurementController@getOtherObjects');
        Route::get('/getngdu', 'WaterMeasurementController@getNgdu');
        Route::post('/getcdng', 'WaterMeasurementController@getCdng');
        Route::post('/getgu', 'WaterMeasurementController@getGu');
        Route::post('/getzu', 'WaterMeasurementController@getZu');
        Route::post('/getwell', 'WaterMeasurementController@getWell');
        Route::get('/getwbs', 'WaterMeasurementController@getWaterBySulin');
        Route::get('/getsrb', 'WaterMeasurementController@getSulphateReducingBacteria');
        Route::get('/gethob', 'WaterMeasurementController@getHydrocarbonOxidizingBacteria');
        Route::get('/gethb', 'WaterMeasurementController@getThionicBacteria');
        Route::post('/getwm', 'WaterMeasurementController@getWm');
        Route::post('/updatewm', 'WaterMeasurementController@update')->name('updatewm');
        Route::resource('omgca','OmgCAController');
        Route::resource('omguhe','OmgUHEController');
        Route::resource('omgngdu','OmgNGDUController');
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


