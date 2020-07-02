<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getOilPlice(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.quandl.com/api/v3/datasets/OPEC/ORB?start_date=2020-06-30&end_date=2020-06-30&api_key=1GucjdFKWYXnEejZ-xEC",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cookie: __cfduid=dedcd3017212288c778fd2ba885bafa8c1593684988"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return($response);
    }

}
