<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;
use Level23\Druid\Context\GroupByV2QueryContext;
use Level23\Druid\Filters\FilterBuilder;
use Level23\Druid\Extractions\ExtractionBuilder;
use Adldap\Laravel\Facades\Adldap;

class DruidController extends Controller
{
    public function index(){

      $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);
      $response = $client->query('well_daily_oil2_v4', Granularity::ALL)
                          ->interval('2012-12-24 20:00:00', '2020-12-24 22:00:00')
                          ->count('totalNrRecords')
                          ->execute();

      return view('druid',['data'=>$response]);
    }


    public function getEconomicData(Request $request){
        $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);

        $builder = $client->query('economic_2020v2', Granularity::DAY);
        $builder2 = $client->query('economic_2020v2', Granularity::DAY);
        $builder3 = $client->query('economic_2020v2', Granularity::DAY);

        $builder
            ->interval('2020-01-01T00:00:00+00:00/2020-05-31T00:33:09+00:00')
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat('yyyy-MM-dd');
            })
            ->select('profitability')
            ->select('price_export_1')
            ->select('org_id2')
            ->count('uwi')
            ->where('org_id2', '=', $request->org)
            ->where('profitability', '=', 'profitable');


        $builder2
            ->interval('2020-01-01T00:00:00+00:00/2020-05-31T00:33:09+00:00')
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat('yyyy-MM-dd');
            })
            ->select('profitability')
            ->select('price_export_1')
            ->select('org_id2')
            ->count('uwi')
            ->where('org_id2', '=', $request->org)
            ->where('profitability', '=', 'profitless_cat_1');


        $builder3
            ->interval('2020-01-01T00:00:00+00:00/2020-05-31T00:33:09+00:00')
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat('yyyy-MM-dd');
            })
            ->select('profitability')
            ->select('price_export_1')
            ->select('org_id2')
            ->count('uwi')
            ->where('org_id2', '=', $request->org)
            ->where('profitability', '=', 'profitless_cat_2');

        $result = $builder->groupBy();
        $result2 = $builder2->groupBy();
        $result3 = $builder3->groupBy();

        $array = $result->data();
        $array2 = $result2->data();
        $array3 = $result3->data();

        $data['dt'] = [];
        $data['profitable'] = [];
        $data['profitless_cat_1'] = [];
        $data['profitless_cat_2'] = [];
        $data['price'] = [];

        foreach($array as $item){
            array_push($data['dt'], $item['dt']);
            array_push($data['profitable'], $item['uwi']);
            array_push($data['price'], $item['price_export_1']);
        }

        foreach($array2 as $item){
            array_push($data['profitless_cat_1'], $item['uwi']);
        }

        foreach($array3 as $item){
            array_push($data['profitless_cat_2'], $item['uwi']);
        }

        return response()->json($data);
  }



    public function getOilPrice(Request $request){
        if ($request->has('start_date') && $request->has('end_date')) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.quandl.com/api/v3/datasets/OPEC/ORB?start_date=".$request->start_date."&end_date=".$request->end_date."&api_key=1GucjdFKWYXnEejZ-xEC",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            return($response);
        }else{
            return "Error. Invalid url";
        }
    }

    public function economic()
    {
        $chartOptions['labels'] = ['01/01/2019', '02/01/2019', '03/01/2019', '04/01/2019', '05/01/2019', '06/01/2019', '07/01/2019', '08/01/2019', '09/01/2019', '10/01/2019', '11/01/2019'];
        return view('economic.main',['chartOptions' => $chartOptions]);
    }

	public function visualcenter()
    {
	   return view('visualcenter.visualcenter');
    }

    public function production(){
        return view('production.main');
    }


    public function gtmscor(){
        return view('production.gtmscor');
    }

    public function mfond(){
        return view('production.mfond');
    }

    public function oil(){
        return view('facilities.oil');
    }

    public function facilities(){
        return view('facilities.main');
    }

    public function liquid(){
        return view('facilities.liquid');
    }

    public function hydraulics(){
        return view('facilities.hydraulics');
    }

    public function complications(){
        return view('facilities.complications');
    }

    public function tabs(){
        return view('dev.tabs');
    }

    public function getNkKmg(){
      $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);
      $response = $client->query('nk_kmg', Granularity::ALL)
                          ->interval('1901-01-01T00:00:00+00:00/2020-07-31T18:02:55+00:00')
                          ->execute();

      return response()->json($response->data());
    }

    public function getNkKmgYear(){
        $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);

        $response = $client->query('nk_kmg_year', Granularity::ALL)
                            ->interval('1901-01-01T00:00:00+00:00/2020-07-31T18:02:55+00:00')
                            ->execute();


        return response()->json($response->data());

    }

    public function getWellDailyOil(){
        $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);

        $builder = $client->query('well_daily_oil2_v10', Granularity::DAY);

        $builder
            ->interval('2020-01-01T00:00:00+00:00/2020-01-02T00:00:00+00:00')
            ->select('__time', 'dt', function (ExtractionBuilder $extractionBuilder) {
                $extractionBuilder->timeFormat('yyyy-MM-dd');
            })
            ->select('surfx')
            ->select('surfy')
            ->select('well_uwi')
            ->select('org');


        $result = $builder->groupBy();

        return response()->json($result->data());

    }

    public function maps()
    {
	   return view('maps.maps');
    }
    public function map()
    {
        return view('production.map');
    }
    public function getCurrency(Request $request)
    {
        $url = "https://www.nationalbank.kz/rss/get_rates.cfm?fdate=" . $request->fdate;
        $dataObj = simplexml_load_file($url);
        if ($dataObj) {
            foreach ($dataObj as $item) {
                if ($item->title == 'USD') {
                    return response()->json($item);
                }
            }
        }
    }

}
