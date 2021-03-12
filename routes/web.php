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

use Illuminate\Support\Facades\Cache;

Route::get(
    '/',
    function () {
        return redirect('/' . App\Http\Middleware\LocaleMiddleware::$mainLanguage);
    }
);

Route::get("/ecoeco", "ComplicationMonitoring\OilGasController@ecoData");

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get("/geteconimicdata", "EconomicController@getEconomicData");

                Route::post("/corrosion", "DruidController@corrosion");
                Route::get(
                    '/',
                    function () {
                        return view('welcome');
                    }
                )->name('mainpage');
                Route::get('/druid', 'DruidController@index');
                Route::get('/oilprice', 'DruidController@getOilPrice');
                Route::get('/getnkkmg', 'DruidController@getNkKmg');
                Route::get('/getwelldailyoil', 'DruidController@getWellDailyOil');
                Route::get('/getnkkmgyear', 'DruidController@getNkKmgYear');
                Route::get('/economic', 'EconomicController@index')->name('economic');
                Route::get('/economicpivot', 'EconomicController@economicPivot')->name('economicpivot');
                Route::get('/oilpivot', 'EconomicController@oilPivot')->name('oilpivot');
                Route::get('/geteconomicpivotdata', 'EconomicController@getEconomicPivotData')->name(
                    'geteconomicpivotdata'
                );
                Route::get('/getoilpivotdata', 'EconomicController@getOilPivotData')->name('getoilpivotdata');

                // visual center
                Route::get('/visualcenter', 'VisCenter\VisualCenterController@visualcenter')->name('visualcenter');
                Route::get('/visualcenter2', 'VisCenter\VisualCenterController@visualcenter2')->name('visualcenter2');
                Route::get('/visualcenter3', 'VisCenter\VisualCenterController@visualcenter3')->name('visualcenter3');
                Route::get('/excelform', 'VisCenter\VisualCenterController@excelform')->name('excelform');
                Route::get('/visualcenter3GetData', 'VisCenter\VisualCenterController@visualcenter3GetData');
                Route::get('/visualcenter3GetDataOpec', 'VisCenter\VisualCenterController@visualcenter3GetDataOpec');
                Route::get('/visualcenter3GetDataStaff', 'VisCenter\VisualCenterController@visualcenter3GetDataStaff');
                Route::get('/visualcenter3GetDataAccident', 'VisCenter\VisualCenterController@visualcenter3GetDataAccident');               
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
                Route::get('/get-dzo-yearly-plan', 'VisCenter\VisualCenterController@getDzoYearlyPlan');
                Route::get('/podborgno', 'gno\GNOController@index')->name('gno');
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
                Route::get('/constructor', 'DruidController@constructor')->name('constructor');

                //tr
                Route::get('/tr', 'tr\TrController@tr')->name('tr');
                Route::get('/export', 'HomeController@export');
                Route::get('/fa', 'tr\TrController@fa')->name('fa');
                Route::get('/trfa', 'tr\TrController@trfa')->name('trfa');
                Route::get('/tr_charts', 'tr\TrController@tr_charts')->name('tr_charts');
                Route::get('/tech_mode', 'tr\TrController@tech_mode')->name('tech_mode');

                //gno economic
                Route::resource('ecorefscompaniesids', 'EcoRefsCompaniesIdsController');
                Route::resource('ecorefsdirection', 'EcoRefsDirectionController');
                Route::resource('ecorefsrouteid', 'EcoRefsRouteIdController');
                Route::resource('ecorefsroutetnid', 'EcoRefsRouteTnIdController');
                Route::resource('ecorefsequipid', 'EcoRefsEquipIdController');
                Route::resource('ecorefsannualprodvolume', 'EcoRefsAnnualProdVolumeController');
                Route::resource('ecorefsrenttax', 'EcoRefsRentTaxController');
                Route::resource('ecorefsavgmarketprice', 'EcoRefsAvgMarketPriceController');
                Route::resource('ecorefsdiscontcoefbar', 'EcoRefsDiscontCoefBarController');
                Route::resource('ecorefscost', 'EcoRefsCostController');
                Route::resource('ecorefsbranchid', 'EcoRefsBrachIdController');
                Route::resource('ecorefsrentequipelectservcost', 'EcoRefsRentEquipElectServCostController');
                Route::resource('ecorefsservicetime', 'EcoRefsServiceTimeController');
                Route::resource('ecorefsndorates', 'EcoRefsNdoRatesController');
                Route::resource('ecorefselectprsbrigcost', 'EcoRefsPrepElectPrsBrigCostController');
                Route::resource('ecorefstarifytn', 'EcoRefsTarifyTnController');
                Route::resource('ecorefsmacro', 'EcoRefsMacroController');
                Route::post('/getkormass', 'ComplicationMonitoring\OmgNGDUController@getKormass');
                Route::resource('ecorefsempper', 'Refs\EcoRefsEmpPerController');
                Route::resource('ecorefsscfa', 'Refs\EcoRefsScFaController');
                Route::get('ecorefslist', 'Refs\EcoRefsScFaController@refsList')->name('eco_refs_list');
                Route::get('nnoeco', 'Refs\EcoRefsScFaController@nnoeco');
                Route::resource('ecorefsexc', 'EcoRefsExcController');
                Route::resource('antiecoone', 'AntiCrisis\AntiEcoOneController');
                Route::resource('antiecotwo', 'AntiCrisis\AntiEcoTwoController');
                Route::resource('ecorefsprocdob', 'EcoRefsProcDobController');
                Route::resource('ecorefsavgprs', 'EcoRefsAvgPrsController');

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

                Route::get('jobs/status', 'JobsController@getStatus')->name('jobs.status');

                Route::get('organizations', 'OrganizationsController@index')->name('organizations');

                Route::get('profile', 'UserController@profile')->name('profile');

                Route::get('anticrisis', 'AntiCrisisController@index')->name('anticrisis');


                
                Route::get('/module_economy', 'EconomyKenzhe\MainController@index');
                Route::get('/module_economy/company/{id}/{date}', 'EconomyKenzhe\MainController@company')->name('company');
                Route::get('/module_economy/companies', 'EconomyKenzhe\MainController@companies');
                Route::match(['get','post'],'/import_rep', 'EconomyKenzhe\MainController@importRepTt')->name('import_rep');

                Route::get('/paegtm', 'GTM\GTMController@index')->name('gtm');

            }
        );
        Auth::routes(
            [
                'reset' => false,
                'verify' => true,
                'register' => false,
            ]
        );

        Route::get(
            '/js/lang.js',
            function () {
                $lang = App\Http\Middleware\LocaleMiddleware::getLocale();
                $strings = Cache::rememberForever(
                    'lang_' . $lang . '.js',
                    function () use ($lang) {
                        $files = glob(resource_path('lang/' . $lang . '/*.php'));
                        $strings = [];

                        foreach ($files as $file) {
                            $name = basename($file, '.php');
                            $strings[$name] = require $file;
                        }

                        return $strings;
                    }
                );

                header('Content-Type: text/javascript');
                echo('window.current_lang = "' . $lang . '";');
                echo('window.i18n = ' . json_encode($strings) . ';');
                exit();
            }
        )->name('assets.lang');
    }
);

Route::get(
    'setlocale/{lang}',
    function ($lang) {
        $referer = Redirect::back()->getTargetUrl();
        $parse_url = parse_url($referer, PHP_URL_PATH);
        $segments = explode('/', $parse_url);

        if (in_array($segments[1], App\Http\Middleware\LocaleMiddleware::$languages)) {
            unset($segments[1]);
        }

        array_splice($segments, 1, 0, $lang);
        $url = Request::root() . implode("/", $segments);

        if (parse_url($referer, PHP_URL_QUERY)) {
            $url = $url . '?' . parse_url($referer, PHP_URL_QUERY);
        }

        return redirect($url);
    }
)->name('setlocale');
