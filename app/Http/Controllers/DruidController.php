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

        $builder = $client->query('economic_2020v4', Granularity::YEAR);
        $builder2 = $client->query('economic_2020v4', Granularity::MONTH);
        $builder3 = $client->query('economic_2020v4', Granularity::DAY);
        $builder4 = $client->query('economic_2020v4', Granularity::DAY);
        $builder5 = $client->query('economic_2020v4', Granularity::YEAR);

        if ($request->has('org')) {
            $builder
                ->interval('2019-01-01T00:00:00+00:00/2020-08-31T00:00:00+00:00')
                ->select('profitability')
                ->sum("Operating_profit")
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitless_cat_1');

            $builder2
                ->interval('2020-06-01T00:00:00+00:00/2028-08-31T00:00:00+00:00')
                ->select('profitability')
                ->sum("Operating_profit")
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitless_cat_1');

            $builder3
                ->interval('2020-06-01T00:00:00+00:00/2020-07-01T00:00:00+00:00')
                ->count("*")
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitless_cat_1');

            $builder4
                ->interval('2020-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->count("*")
                ->where('org_id2', '=', $request->org)
                ->where('profitability', '=', 'profitless_cat_1');

            $builder5
                ->interval('2019-01-01T00:00:00+00:00/2020-08-31T00:00:00+00:00')
                ->longSum("prs1")
                ->count("*")
                ->where('profitability', '=', 'profitless_cat_1')
                ->where('org_id2', '=', $request->org)
                ->divide('prs', ['prs1', '*']);
        }else{
            $builder
            ->interval('2019-01-01T00:00:00+00:00/2020-08-31T00:00:00+00:00')
            ->select('profitability')
            ->sum("Operating_profit")
            ->where('profitability', '=', 'profitless_cat_1');

            $builder2
                ->interval('2020-06-01T00:00:00+00:00/2028-08-31T00:00:00+00:00')
                ->select('profitability')
                ->sum("Operating_profit")
                ->where('profitability', '=', 'profitless_cat_1');

            $builder3
                ->interval('2020-06-01T00:00:00+00:00/2020-07-01T00:00:00+00:00')
                ->count("*")
                ->where('profitability', '=', 'profitless_cat_1');

            $builder4
                ->interval('2020-07-01T00:00:00+00:00/2020-08-01T00:00:00+00:00')
                ->count("*")
                ->where('profitability', '=', 'profitless_cat_1');

            $builder5
                ->interval('2019-01-01T00:00:00+00:00/2020-08-31T00:00:00+00:00')
                ->sum("prs1")
                ->where('profitability', '=', 'profitless_cat_1');
        }


        $result = $builder->groupBy();
        $result2 = $builder2->groupBy();
        $result3 = $builder3->groupBy();
        $result4 = $builder4->groupBy();
        $result5 = $builder5->groupBy();

        $array = $result->data();
        $array2 = $result2->data();
        $array3 = $result3->data();
        $array4 = $result4->data();
        $array5 = $result5->data();


        $data['count'] = [];
        $data['countProfitlessCat1PrevMonth'] = [];
        $data['countProfitlessCat1Month'] = [];

        foreach($array3 as $item){
            array_push($data['countProfitlessCat1PrevMonth'], $item['*']);
        }
        foreach($array4 as $item){
            array_push($data['countProfitlessCat1Month'], $item['*']);
        }

        $averageProfitlessCat1Month = array_sum($data['countProfitlessCat1Month'])/count($data['countProfitlessCat1Month']);
        $averageProfitlessCat1PrevMonth = array_sum($data['countProfitlessCat1PrevMonth'])/count($data['countProfitlessCat1PrevMonth']);


        $yearIndex = count($array)-1;
        $lastMonthIndex = count($array2)-1;
        $prevMonthIndex = count($array2)-2;


        $year = self::moneyFotmat(-1 * $array[$yearIndex]["Operating_profit"]);
        $month = self::moneyFotmat(-1 * $array2[$lastMonthIndex]["Operating_profit"]);
        $persent = ($array2[$prevMonthIndex]["Operating_profit"] - $array2[$lastMonthIndex]["Operating_profit"]) * 100 / $array2[$prevMonthIndex]["Operating_profit"];
        $persentCount = ($averageProfitlessCat1PrevMonth - $averageProfitlessCat1Month) * 100 / $averageProfitlessCat1PrevMonth;

        $vdata = ['year' => $year,
                    'month' => $month,
                    'persent' => round($persent),
                    'persentCount' => round($persentCount),
                    'averageProfitlessCat1MonthCount' => round($averageProfitlessCat1Month),
                    'prs' => round($array5[0]["prs1"])];

        return response()->json($vdata);
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


    static function moneyFotmat($digit){
        if ($digit < 1000000) {
            $format = number_format($digit);
        } else if ($digit < 1000000000) {
            $format = number_format($digit / 1000000, 2) . ' млн';
        } else {
            $format = number_format($digit / 1000000000, 2) . ' млрд';
        }

        return $format;
    }
}
