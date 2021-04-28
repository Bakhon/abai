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
                Route::post("/export-economic-data", "EconomicController@exportEconomicData");

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
                Route::get('/economic/nrs', 'EconomicController@index')->name('economic');
                Route::get('/economicpivot', 'EconomicController@economicPivot')->name('economicpivot');
                Route::get('/oilpivot', 'EconomicController@oilPivot')->name('oilpivot');
                Route::get('/geteconomicpivotdata', 'EconomicController@getEconomicPivotData')->name(
                    'geteconomicpivotdata'
                );
                Route::get('/getoilpivotdata', 'EconomicController@getOilPivotData')->name('getoilpivotdata');

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
                Route::get('economic_data_json', 'EcoRefsCostController@economicDataJson');
                Route::get('economic_data/upload_excel', 'EcoRefsCostController@uploadExcel')->name('economic_data_upload');
                Route::post('economic_data/import_excel', 'EcoRefsCostController@importExcel')->name('economic_data_import');
                Route::resource('economic_data_log', 'Refs\EconomicDataLogController');
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
                Route::get('eco_refs_sc_fas', 'Refs\EcoRefsScFaController@getScFas');
                Route::get('ecorefslist', 'Refs\EcoRefsScFaController@refsList')->name('eco_refs_list');

                // economic tech data
                Route::get('tech_data_list', 'Refs\TechnicalDataController@refsList')->name('tech_data_list');
                Route::resource('tech_struct_source', 'Refs\TechnicalStructureSourceController');
                Route::get('tech_struct_sources', 'Refs\TechnicalStructureSourceController@getSources');
                Route::resource('tech_struct_company', 'Refs\TechnicalStructureCompanyController');
                Route::resource('tech_struct_field', 'Refs\TechnicalStructureFieldController');
                Route::resource('tech_struct_ngdu', 'Refs\TechnicalStructureNgduController');
                Route::resource('tech_struct_cdng', 'Refs\TechnicalStructureCdngController');
                Route::resource('tech_struct_gu', 'Refs\TechnicalStructureGuController');
                Route::resource('tech_struct_bkns', 'Refs\TechnicalStructureBknsController');
                Route::resource('tech_data_forecast', 'Refs\TechnicalDataForecastController');
                Route::resource('tech_data_log', 'Refs\TechnicalDataLogController');
                Route::get('tech_data_json', 'Refs\TechnicalDataForecastController@techDataJson');
                Route::get('technical_forecast/upload_excel', 'Refs\TechnicalDataController@uploadExcel')->name('tech_refs_upload');
                Route::post('technical_forecast/import_excel', 'Refs\TechnicalDataController@importExcel')->name('tech_refs_import');

                Route::get('nnoeco', 'Refs\EcoRefsScFaController@nnoeco');
                Route::resource('ecorefsexc', 'EcoRefsExcController');
                Route::resource('antiecoone', 'AntiCrisis\AntiEcoOneController');
                Route::resource('antiecotwo', 'AntiCrisis\AntiEcoTwoController');
                Route::resource('ecorefsprocdob', 'EcoRefsProcDobController');
                Route::resource('ecorefsavgprs', 'EcoRefsAvgPrsController');


                Route::get('jobs/status', 'JobsController@getStatus')->name('jobs.status');

                Route::get('organizations', 'OrganizationsController@index')->name('organizations');
                Route::get('fields', 'FieldController@index')->name('fields');

                Route::get('profile', 'UserController@profile')->name('profile');
                Route::post('modulerequest','ModuleController@moduleRequest')->name('modulerequest');
                Route::post('/update_avatar', 'UserController@update_avatar')->name('update_avatar');
                Route::post('/delete_avatar', 'UserController@delete_avatar')->name('delete_avatar');

                Route::get('anticrisis', 'AntiCrisisController@index')->name('anticrisis');



                Route::get('/module_economy', 'EconomyKenzhe\MainController@index');
                Route::get('/module_economy/company/', 'EconomyKenzhe\MainController@company')->name('company');
                Route::get('/module_economy/companies', 'EconomyKenzhe\MainController@companies');
                Route::match(['GET','POST'],'/import_rep', 'EconomyKenzhe\ImportController@importRepTtValues')->name('import_rep');
                Route::match(['GET','POST'],'/import_reptt_titles', 'EconomyKenzhe\ImportController@importRepTtTitlesTree')->name('import_reptt_titles');

                Route::get('/paegtm', 'GTM\GTMController@index')->name('gtm');
                Route::get('/paegtm/accum_oil_prod_data', 'GTM\GTMController@getAccumOilProd')->name('gtm');
                Route::get('/paegtm/comparison_indicators_data', 'GTM\GTMController@getComparisonIndicators')->name('gtm');

                Route::post('dzo_excel_form', 'VisCenter\ExcelForm\ExcelFormController@store');
                Route::post('dzo_chemistry_excel_form', 'VisCenter\ExcelForm\ExcelFormChemistryController@store');
                Route::get('/proactive-factors', 'EconomyKenzhe\proactiveFactorsController@proactiveFactors')->name('proactiveFactors');          
                
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
