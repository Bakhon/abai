<?php

namespace App\Http\Controllers;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;
use Level23\Druid\Context\GroupByV2QueryContext;
use Level23\Druid\Filters\FilterBuilder;
use Level23\Druid\Extractions\ExtractionBuilder;
use Adldap\Laravel\Facades\Adldap;

use Illuminate\Http\Request;

class EconomicController extends Controller
{
    public function index(Request $request){
        return view('economic.main');
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
