<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;
use Level23\Druid\Filters\FilterBuilder;
use Level23\Druid\Extractions\ExtractionBuilder;
use Adldap\Laravel\Facades\Adldap;

class DruidController extends Controller
{
    public function index(){

      $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);
      $response = $client->query('well_daily_2018', Granularity::ALL)
                          ->interval('2012-12-24 20:00:00', '2019-12-24 22:00:00')
                          ->count('totalNrRecords')
                          ->execute();

      //$user = Adldap::search()->users()->find('васильев');
      return view('druid',['data'=>$response]);
    }
}
