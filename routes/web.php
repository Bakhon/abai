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

Route::get("/ecoeco", "ComplicationMonitoring\OilGasController@ecoData");

Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function() {
    Route::group(['middleware' => 'auth'], function () {
        Route::get("/geteconimicdata", "EconomicController@getEconomicData");
        Route::get("/getcurrency", "DruidController@getCurrency");
        Route::get("/getcurrencyperiod", "DruidController@getCurrencyPeriod");
        Route::post("/corrosion", "DruidController@corrosion");
        Route::get('/', function () {
            return view('welcome');
        });
        Route::get('/druid', 'DruidController@index');
        Route::get('/oilprice', 'DruidController@getOilPrice');
        Route::get('/getnkkmg', 'DruidController@getNkKmg');
        Route::get('/getwelldailyoil', 'DruidController@getWellDailyOil');
        Route::get('/getnkkmgyear', 'DruidController@getNkKmgYear');
        Route::get('/economic', 'EconomicController@index')->name('economic');
        Route::get('/getdzocalcs', 'EconomicController@getDZOcalcs')->name('getdzocalcs');
        Route::get('/getdzocalcsactualmonth', 'EconomicController@getDZOCalcsActualMonth')->name('getdzocalcsactualmonth');
        Route::get('/economicpivot', 'EconomicController@economicPivot')->name('economicpivot');
        Route::get('/oilpivot', 'EconomicController@oilPivot')->name('oilpivot');
        Route::get('/geteconomicpivotdata', 'EconomicController@getEconomicPivotData')->name('geteconomicpivotdata');
        Route::get('/getoilpivotdata', 'EconomicController@getOilPivotData')->name('getoilpivotdata');
        Route::get('/visualcenter', 'DruidController@visualcenter')->name('visualcenter');
        Route::get('/visualcenter2', 'DruidController@visualcenter2')->name('visualcenter2');
        Route::get('/visualcenter3', 'DruidController@visualcenter3')->name('visualcenter3');
        Route::get('/visualcenter3GetData', 'DruidController@visualcenter3GetData');
        Route::get('/visualcenter4', 'DruidController@visualcenter4')->name('visualcenter4');
        Route::get('/visualcenter5', 'DruidController@visualcenter5')->name('visualcenter5');
        Route::get('/visualcenter6', 'DruidController@visualcenter6')->name('visualcenter6');
        Route::get('/visualcenter7', 'DruidController@visualcenter7')->name('visualcenter7');
        Route::get('/podborgno', 'DruidController@gno')->name('gno');
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
        Route::get('/gtm', 'DruidController@gtm')->name('gtm');
        Route::get('/dob', 'DruidController@dob')->name('dob');
        Route::post('/protodata', 'ProtoDBController@getProtoOtchet1')->name('protodata');
        Route::post('/gtm1', 'DBgtmController@gtm1')->name('gtm1');
        Route::post('/dob1', 'DBdobController@dob1')->name('dob1');
        Route::get('/bigdata', 'DruidController@bigdata')->name('bigdata');
        Route::get('/constructor', 'DruidController@constructor')->name('constructor');
        Route::get('/tr', 'DruidController@tr')->name('tr');
        Route::get('/export', 'HomeController@export');
        Route::get('/fa', 'DruidController@fa')->name('fa');
        Route::get('/trfa', 'DruidController@trfa')->name('trfa');
        Route::get('/tr_charts', 'DruidController@tr_charts')->name('tr_charts');


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
        Route::post('/getkormass', 'ComplicationMonitoring\OmgNGDUController@getKormass');
        Route::resource('ecorefsempper','Refs\EcoRefsEmpPerController');
        Route::resource('ecorefsscfa','Refs\EcoRefsScFaController');
        Route::get('ecorefslist','Refs\EcoRefsScFaController@refsList');
        Route::get('nnoeco','Refs\EcoRefsScFaController@nnoeco');
        Route::resource('ecorefsexc','EcoRefsExcController');
        Route::resource('antiecoone','AntiCrisis\AntiEcoOneController');
        Route::resource('antiecotwo','AntiCrisis\AntiEcoTwoController');
        Route::resource('ecorefsprocdob','EcoRefsProcDobController');
        Route::resource('ecorefsavgprs','EcoRefsAvgPrsController');

        Route::resource('marabkpiid','VizCenter\MarabKpiIdController');
        Route::resource('abdkpiid','VizCenter\AbdKpiIdController');
        Route::resource('typeid','VizCenter\TypeIdController');
        Route::resource('marab1','VizCenter\Marab1Controller');
        Route::resource('marab2','VizCenter\Marab2Controller');
        Route::resource('marab345','VizCenter\Marab345Controller');
        Route::resource('marab6','VizCenter\Marab6Controller');
        Route::resource('abd12','VizCenter\Abd12Controller');
        Route::resource('abd35','VizCenter\Abd35Controller');
        Route::resource('abd46','VizCenter\Abd46Controller');
        Route::resource('corpkpiid','VizCenter\CorpKpiIdController');
        Route::resource('corpall','VizCenter\CorpAllController');

        Route::get('kpicalc','VizCenter\Marab2Controller@kpicalculation');
        Route::get('kpiList','VizCenter\Marab2Controller@kpiList');

        Route::resource('viscenter2', 'VisCenter2\Vis2FormController');

        Route::get('/import_hist','DZO\DZOdayController@importExcel');
        Route::post('/import_h', 'DZO\DZOdayController@import')->name('import_h');

        Route::get('importdzoyear','DZO\DZOyearController@importExcel');

        Route::get('/import_econom','DZO\DZOcalcController@importExcel');
        Route::post('/import_eco', 'DZO\DZOcalcController@import')->name('import_e');

        Route::get('/import_excel', 'DZO\DZOdailyController@importExcel');

        Route::post('/import', 'DZO\DZOdailyController@import')->name('import');

        Route::get('jobs/status', 'JobsController@getStatus')->name('jobs.status');

        Route::get('organizations', 'OrganizationsController@index')->name('organizations');

    });
    Auth::routes([
        'reset' => false,
        'verify' => true,
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


