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
        Route::get('/economicpivot', 'EconomicController@economicPivot')->name('economicpivot');
        Route::get('/oilpivot', 'EconomicController@oilPivot')->name('oilpivot');
        Route::get('/geteconomicpivotdata', 'EconomicController@getEconomicPivotData')->name('geteconomicpivotdata');
        Route::get('/getoilpivotdata', 'EconomicController@getOilPivotData')->name('getoilpivotdata');
        Route::get('/visualcenter', 'DruidController@visualcenter')->name('visualcenter');
        Route::get('/visualcenter2', 'DruidController@visualcenter2')->name('visualcenter2');
        Route::get('/visualcenter3', 'DruidController@visualcenter3')->name('visualcenter3');
        Route::get('/visualcenter3GetData', 'DruidController@visualcenter3GetData');
        Route::get('/visualcenter4', 'DruidController@visualcenter4')->name('visualcenter4');
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


        //wm
        Route::get('watermeasurement/export','ComplicationMonitoring\WaterMeasurementController@export')->name('watermeasurement.export');
        Route::get('watermeasurement/history/{watermeasurement}','ComplicationMonitoring\WaterMeasurementController@history')->name('watermeasurement.history');
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

        Route::get('omgca/list', 'ComplicationMonitoring\OmgCAController@list')->name('omgca.list');
        Route::get('omgca/export', 'ComplicationMonitoring\OmgCAController@export')->name('omgca.export');
        Route::get('omgca/history/{omgca}', 'ComplicationMonitoring\OmgCAController@history')->name('omgca.history');
        Route::resource('omgca','ComplicationMonitoring\OmgCAController');

        Route::resource('omguhe','ComplicationMonitoring\OmgUHEController');
        Route::get('omguhe/history/{omguhe}', 'ComplicationMonitoring\OmgUHEController@history')->name('omguhe.history');

        Route::get('omgngdu/list', 'ComplicationMonitoring\OmgNGDUController@list')->name('omgngdu.list');
        Route::get('omgngdu/export', 'ComplicationMonitoring\OmgNGDUController@export')->name('omgngdu.export');
        Route::get('omgngdu/history/{omgngdu}', 'ComplicationMonitoring\OmgNGDUController@history')->name('omgngdu.history');
        Route::resource('omgngdu','ComplicationMonitoring\OmgNGDUController');


        Route::post('/getgucdngngdufield', 'ComplicationMonitoring\WaterMeasurementController@getGuNgduCdngField');

        Route::get('oilgas/export', 'ComplicationMonitoring\OilGasController@export')->name('oilgas.export');
        Route::get('oilgas/history/{oilgas}', 'ComplicationMonitoring\OilGasController@history')->name('oilgas.history');
        Route::resource('oilgas','ComplicationMonitoring\OilGasController')->parameters(['oilgas' => 'oilgas']);

        Route::post('vcoreconomic','ComplicationMonitoring\OilGasController@economic');
        Route::post('vcoreconomiccurrent','ComplicationMonitoring\OilGasController@economicCurrentYear');
        Route::post('checkdublicateomgddng','ComplicationMonitoring\OmgCAController@checkDublicate');
        Route::post('getprevdaylevel','ComplicationMonitoring\OmgUHEController@getPrevDayLevel');

        Route::get('corrosioncrud/export', 'ComplicationMonitoring\CorrosionController@export')->name('corrosioncrud.export');
        Route::get('corrosioncrud/history/{corrosion}', 'ComplicationMonitoring\CorrosionController@history')->name('corrosioncrud.history');
        Route::resource('corrosioncrud','ComplicationMonitoring\CorrosionController');


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
        Route::get('kpicalc','VizCenter\Marab2Controller@kpicalculation');
        Route::get('kpiList','VizCenter\Marab2Controller@kpiList');

        Route::resource('viscenter2', 'VisCenter2\Vis2FormController');

        Route::get('importdzoday','DZO\DZOdayController@importExcel');
        Route::get('importdzoyear','DZO\DZOyearController@importExcel');
        Route::get('importdzocalc','DZO\DZOcalcController@importExcel');

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


