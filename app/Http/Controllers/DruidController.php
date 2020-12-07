<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;
use Level23\Druid\Context\GroupByV2QueryContext;
use Level23\Druid\Filters\FilterBuilder;
use Level23\Druid\Extractions\ExtractionBuilder;
use Adldap\Laravel\Facades\Adldap;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role;

class DruidController extends Controller
{
    public function index()
    {

        $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);
        $response = $client->query('month_meter_prod_oil_v02', Granularity::MONTH)
            ->interval('2014-01-01 20:00:00', '2020-10-20 22:00:00')
            ->count('totalNrRecords')
            ->execute();
return $response;
     //   return view('druid');
    }

    public function getOilPrice(Request $request)
    {
        if ($request->has('start_date') && $request->has('end_date')) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://www.quandl.com/api/v3/datasets/OPEC/ORB?start_date=" . $request->start_date . "&end_date=" . $request->end_date . "&api_key=1GucjdFKWYXnEejZ-xEC",
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

            return ($response);
        } else {
            return "Error. Invalid url";
        }
    }

    public function visualcenter()
    {
        return view('visualcenter.visualcenter');
    }

    public function visualcenter2()
    {
        return view('visualcenter.visualcenter2');
    }

    public function visualcenter3()
    {
//$file = 'https://yandex.ru/news/quotes/graph_1006.json';
//$file_name = 'D:/openserver/OpenServer/domains/localhost/public/js/json/graph_1006.json';
//file_put_contents($file_name, file_get_contents($file));

//Role::create(['name'=>'writer']);
//$permission = Permission::create(['name'=>'writer post']);
//auth()->user()->givePermissionTo('edit post');
        return view('visualcenter.visualcenter3');
    }

    public function visualcenter4()
    {
        return view('visualcenter.visualcenter4');
    }

    public function production()
    {
        return view('production.main');
    }


    public function gtmscor()
    {
        return view('production.gtmscor');
    }

    public function mfond()
    {
        return view('production.mfond');
    }

    public function oil()
    {
        return view('facilities.oil');
    }

    public function facilities()
    {
        return view('facilities.main');
    }

    public function liquid()
    {
        return view('facilities.liquid');
    }

    public function hydraulics()
    {
        return view('facilities.hydraulics');
    }

    public function complications()
    {
        return view('facilities.complications');
    }

    public function tabs()
    {
        return view('dev.tabs');
    }

    public function getNkKmg()
    {
        $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);
        $response = $client->query('nk_kmg', Granularity::ALL)
            ->interval('1901-01-01T00:00:00+00:00/2020-07-31T18:02:55+00:00')
            ->execute();

        return response()->json($response->data());
    }

    public function getNkKmgYear()
    {
        $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);

        $response = $client->query('nk_kmg_year', Granularity::ALL)
            ->interval('1901-01-01T00:00:00+00:00/2020-07-31T18:02:55+00:00')
            ->execute();


        return response()->json($response->data());
    }

    public function getWellDailyOil()
    {
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
    public function mzdn()
    {
        return view('reports.mzdn');
    }

    public function bigdata()
    {
        return view('reports.bigdata');
    }

    public function constructor()
    {
        return view('reports.constructor');
    }
    public function gtm()
    {
        return view('reports.gtm');
    }
    public function dob()
    {
        return view('reports.dob');
    }

    function getCurrencyPeriod(Request $request)
    {
        $datesNow = $request->dates;
        $period = $request->period;
        $datesNowString = strtotime($datesNow);
        $last = strtotime($datesNow . '-' . $period . 'day');
        //$last = strtotime($datesNow . '- 1 month');
        $countDay = ($datesNowString - $last) / 86400;
        for (
            $i = 1;
            $i <= $countDay;
            $i++
        ) {
            $last = $last + 86400;
            $dates = date('d.m.Y', $last);
            $url = "https://www.nationalbank.kz/rss/get_rates.cfm?fdate=" . $dates;
            $dataObj = simplexml_load_file($url);
            if ($dataObj) {
                foreach ($dataObj as $item) {
                    if ($item->title == 'USD') {
                        $description = $item->description;
                        $array[$i] =  array(
                            "dates" => $dates,
                            "description" => $description,
                        );
                    }
                }
            }
        }

        return response()->json($array);
    }

    public function gno()
    {
        return view('gno.gno');
    }

    public function monitor()
    {
        return view('monitor.monitor');
    }

    public function calcGtm()
    {
        return view('production.calcgtm');
    }
    public function corrosion(Request $request)
    {
        if (true) {
            //flowrate of liquid oil//
            $q_l = $request->q_l; // БД ОМГ НГДУ  input in pipesim m3/day
            $WC = $request->WC; // БД ОМГ НГДУ input in pipesim Watercut
            //oil density
            $rhol = $request->rhol; // БД Лабараторная НЕФТИ input in pipesim density dead oil kg/m3
            //$q_l = $q_l * 1000 / $rhol; // перевод массового расхода (т/сут) в объемный (м3/сут)
            $q_l = $q_l / 24.0 / 60.0 / 60.0; // input in pipesim convert from m3/d to m3/sec
            //flowrate of gas
            $GOR1 = $request->GOR1; // БД ОМГ НГДУ input in pipesim Gas-Oil-Ratio газосодержание на входе в ГУ
            $GOR1 = $GOR1 / 100;
            $q_g_sib = $request->q_g_sib; // m3/day расход газа в СИБ => БД ОМГ НГДУ
            $q_g_sib = $q_g_sib / 24.0 / 60.0 / 60.0; // input in pipesim convert from m3/d to m3/sec
            //$GOR = ($GOR1*$q_l - $q_g_sib) / $q_l; // газосодержание на выходе с ГУ добоваить переменную q_o
            //Qoil(m3/d)=(Qoil(t/d)*1000)/ρoil(kg/m3)- перевод массового расхода (т/сут) в объемный (м3/сут)
            //GOR2=(GOR1*Qoil(m3/d) - Qsib(m3/d)/))/Qoil(m3/d)-газосодержание на выходе с ГУ
            $q_o = $request->q_o;
            $rho_o = $request->rho_o;
            $q_o = $q_o * 1000 / $rho_o; // convert from t/day => m3/day
            $q_o = $q_o / 24.0 / 60.0 / 60.0; // convert from m3/day => m3/sec
            $GOR = ($GOR1 * $q_o - $q_g_sib) / $q_o; // газосодержание на выходе с ГУ добоваить переменную q_o

            if ($GOR <= 0) {
                $GOR = 0.001;
                ob_start(); //Start output buffer
                echo "GOR1 x q_o less or equal to q_g_sib";
                //$environment_a = "CO2";
                $warning = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
            }
            $q_g = $q_o * $GOR; // m3/sec расход газа в ГУ
            //density of gas
            //$SG = 0.64; //input pipesim
            //$rhog = $SG * 1.204; // 1.204 kg/m3 = SG of Air
            $rhog = $request->rhog; // БД Лабараторная по нефти и газу kg/m3 ???? надо перепроверить 06.11.2020
            //mass flowrate of liquid
            $m_dotl = $rhol * $q_l; // kg/m3 * m3/s = kg/s
            //mass flowrate of gas
            $m_dotg = $rhog * $q_g; // kg/s
            //combined mass flowrate of mixture
            $m_dot = $m_dotl + $m_dotg;
            //Density of two phase
            $x = $m_dotg / $m_dot;
            //Dead oil viscosity
            $mul = $request->mul; // mm2/m.s БД Лабараторная по нефти и газу
            $mul = $mul / 1000; // from mm2/sec to kg/(kg.s)
            //Viscosity of gas
            $mug = $request->mug; // mm2/s БД Лабараторная по нефти и газу
            $mug = $mug / 1000; // from mm2/sec to kg/(kg.s)
            //Surface tension
            $sigma = $request->sigma; // Внутренняя БД константа N/m
            //Outside diameter
            $do = $request->do; // Наружный диаметр Внутренняя БД константа mm
            $do = $do / 1000; // from mm to m
            $thickness = $request->thickness; // Внутренняя БД константа thickness  in mm
            $thickness = $thickness / 1000; // from mm to m
            //Inner diameter
            $d = $do - 2 * $thickness; // in m
            //Roughness of pipes
            $roughness = $request->roughness; // Внутренняя БД константа m
            //$roughness = $roughness / 1000; // from mm to m
            //Length
            $l = $request->l; // // Внутренняя БД константа в метрах
            //Pressure
            $P = $request->P; // БД ОМГ НГДУ bar
            $P_pump = $P; // в точке Е бар
            $P_bufer = $request->P_bufer; // БД ОМГ НГДУ в точке А bar
            //Gravitational acceleration
            $g = 9.81; // m2/s
            // $h = $request->h;
//          Liquid-only properties, for calculation of E, dP_lo
//          Calculate velocity
            $v_lo = $m_dot/$rhol/(pi()/4*$d**2);
//          Calculate Reynolds number
            $Re_lo = $v_lo * $d * $rhol / $mul; // m/s * m * kg/m3 / (kg/(m.s))
            $A = pow(2.457 * log(1 / (pow(7/$Re_lo,0.9)+(0.27 * $roughness / $d))),16);
            $B = pow(37530 / $Re_lo,16);
//          Calculate Friction factor
            $f_lo = 8 * pow(pow(8 / $Re_lo,12) + 1 / (pow($A+$B,1.5)),1 / 12);
            $dP_lo = $f_lo*$l/$d*(0.5*$rhol*$v_lo**2);

//          Gas-only properties, for calculation of E
            $v_go = $m_dot/$rhog/(pi()/4*$d**2);
            $Re_go = $v_go * $d * $rhog / $mug;
            $A_g = pow(2.457 * log(1 / (pow(7/$Re_go,0.9)+(0.27 * $roughness / $d))),16);
            $B_g= pow(37530 / $Re_go,16);
            $f_go = 8 * pow(pow(8 / $Re_go,12) + 1 / (pow($A_g+$B_g,1.5)),1 / 12);

            $F = $x**0.78*(1-$x)**0.224;
            $H = ($rhol/$rhog)**0.91*($mug/$mul)**0.19*(1 - $mug/$mul)**0.7;
            $E = (1-$x)**2 + $x**2*($rhol*$f_go/($rhog*$f_lo));

//          Homogeneous properties, for Froude/Weber numbers
//          Calculate voidage
            $eh = 1 / (1 + (1 - $x) * $rhog / $x / $rhol);
            $rho_h = $rhol*(1-$eh) + $rhog*$eh;
            $Q_h = $m_dot/$rho_h;
            $v_h = $Q_h/(pi()/4*$d**2);

//          Fr = Froude(m, D, rho=rho_h) # checked with (m/(pi/4*D**2))**2/g/D/rho_h**2
            $Fr = $m_dot**2 / ($g * $d * $rho_h**2);
//          We = Weber(m=m, D=D, rho=rho_h, sigma=sigma) # checked with (m/(pi/4*D**2))**2*D/sigma/rho_h
            $W = $m_dot**2 * $d / $sigma / $rho_h;
            $phi_lo2 = $E + 3.24*$F*$H/($Fr**0.0454*$W**0.035);
            $dP = $phi_lo2*$dP_lo;
//          return result

// dP =  Friedel(m, x, rhol, rhog, mul, mug, sigma, D, roughness, L)
            $P_final = $P - $dP/100000;

            //TEMPERATURE CALCULATIONS TO BE ADDED LATER!!! 12.10.2010
            //These variables are constant for only ONE simulation
            //To be as INPUT in future
            //$flow = $Q_h * 3600 * 24 * (1 - $WC);
            //Outside diameter in m
            $do = $do;
            //Inside diameter in m
            $di = $d;
            //Roughness in m
            $roughness = $roughness;
            //Density in kg / m3
            $density = $rho_h;
            //Fluid viscosity in Pa.s  x 1000 to cP
            $viscosity = $mul;
            //Length of the pipe in m
            $l = 1000.0;
            //thermal conductivity of piping material in W/(m*K)
            $k = 45;
            //thermal conductivity of fluid in W/(m*k)
            $k_f = 0.6;
            //thermal conductivity of ground
            $k_g = 0.774;
            //Outside temperature in K
            $to = 298.0;
            //Inside temperature in K
            $t_heater = $request->t_heater; // БД ОМГ НГДУ temperature from Печь taken from database in Celsius
            $ti = 273.0 + $t_heater;
            //heat capacity Cp fluid in J/kg*K
            $c_p = 4184.4;
            //Stefan-Boltzmann constant
            $sigma_s = 5.678 * pow(10,-8); # W/m^2 K
            //print("sigma_s = ", sigma_s)
            //Emissivity of pipe material mild steel @ 20 C
            $epsilon = 0.12;

            //Turn all values into floating points // from m3/day to kg/sec
            //$flow = $Q_h / 24 / 3600;
            //print("flow m3/sec = ", flow)


            // def temp_drop(flow,do,di,roughness,density,viscosity,l,k,k_f,k_g,to,ti,c_p,g,sigma_s,epsilon):
            // calculate the mass flow rate
            //$m_dot = $flow * $density;
            //calculate the cross sectional area of the inner pipe
            $ax = ($di**2) * pi() / 4;
            //Heat transfer coefficient outside pipe in W/(m^2*K)
            $Z = 1; #depth of pipe in ground
            $h_o = 2 * $k_g / $do / log(2*$Z + sqrt(4*$Z**2 - $do**2) / $do);
            //calculate the heat transfer coefficient inside pipe
            $h_i = 0.023*$c_p*$m_dot/ $ax / pow(($c_p*$viscosity/$k_f),2/3) / pow(($di*$m_dot/$ax/$viscosity),0.2);
            // U - the overall heat transfer coefficient for bare pipe that accounts for all the resistances involved
            // Assume little or no wind affects the pipe heat loss and we'll estimate the heat loss from the bare pipe
            $R_in = $do / ($h_i * $di);
            $R_1 = 0.5*$do * log($do/$di) / $k;
            $R_out = 1 / $h_o;
            $U = 1 / ($R_in + $R_1 + $R_out);
            // Now, we'll estimate the radiant heat losses:
            $A = pi() * $do;
            $diff_t = $ti**4 - $to**4;
            //qwerty = l * sigma_s * A * epsilon
            $Q_rad = $l* $sigma_s * $A * $epsilon * (($ti**4)-($to**4));
            //Now, we'll estimate the losses due to convection:
            $Q_conv = $U * $A * $l * ($ti - $to);
            //Add all these together to arrive at the total heat loss for the bare pipe
            $Q_total = $Q_rad + $Q_conv;
            //Calculate the temperature final
            $t_final = $to + ($ti - $to) * exp(-$U * pi() * $do * $l / $m_dot / $c_p);
            $t_final = $t_final - 273; //Kelvin to Celsius


            // Calculating the corrosion rate as per de Waard and Milliams, which is used in Royal Dutch Shell
            // log r = 7.96 - 2320 / (T + 273) - 5.55 * 10^-3 * T + 0.67 * log(pCo2)
            // pressure in bar
            // *********************************/
            //    GENERAL CORROSION POINT A    /
            // *********************************/
            $p = $P_bufer * 100; // from bar to kPa
            $t = 25;  //temperature in C
            //H2S concentration
            $conH2S = $request->conH2S; // БД Лаборатория жидкости, mg/l soluble in water previous was mole fraction ex: 0.0001
            $conH2S_frac = $conH2S * 0.07055; // from mg/l => volumetric fraction
            //CO2 concentraiton
            $conCO2 = $request->conCO2; // БД Лаборатория жидкости, mg/l soluble in water previous was mole fraction ex: 0.0001
            $conCO2_frac = $conCO2 * 0.05464; // from mg/l => volumetric fraction
            // //According to Dalton's law of partial pressures, the partial pressure of CO2 is proportional to the mole fraction
            // //First we need to get the solubility coefficient from the following formula:
            // //Henry's Law constant: kH(T) = kH * exp(d(ln(kH))/d(1/T) ((1/T) - 1/(298.15 K)))
            // //where kH as per NIST 0.034 mol/lg*bar,
            // //d(ln(kH))/d(1/T) = 2600
            // $khCO2 = 0.034;
            // $dtCO2 = 2600;

            // //Now let's calculate the partial pressure using the Henry's constant:
            // $kCO2 = $khCO2 * exp($dtCO2 * (1/($t + 273) - 1/285.15));   # mol/kg*bar
            // //print("kCO2 [mol/kg*bar]= ", kCO2)
            // //Converting from % to mg/l
            // $CO2 = $conCO2 * 44000 / 22.4 * 273 / (273 + $t) * 10 * $p / 1013;
            // // 1 mol/kg of CO2 => 44 g/l or 44000 mg/l assuming that 1l = 1kg the partial pressure equals:
            // $pCO2 = $CO2 / $kCO2 / 44000;   //kPa
            //print("pCO2 [kPa] = ", pCO2)
            $pCO2 = $conCO2_frac / 100 * $p; // measured in kPa as per formula

            //convert data to proper type
            $co2 = $pCO2 / 1000; //convert partial pressure CO2 from kPa => MPa

            //def corrosion_rate(co2,t):

            // $a = 7.96 - 2320 / ($t+273);
            // $b = $t * 5.55 * pow(10,-3);
            // $c = 0.67 * log10($co2);
            // $d = $a - $b + $c;
            // $r_a = pow(10,$d);
            // r = pow(10, (7.96 - 2320 / (ti + 273) - 5.55 * 10**(-3) * ti + 0.67 * math.log10(co2))
            // return r
            //x = corrosion_rate(co2,t)

            //******************************************//
            //GENERAL CORROSION CALCULATION in POINT A  //
            //******************************************//

            // According to Dalton's law of partial pressures, the partial pressure of CO2 is proportional to the mole fraction
            // First we need to get the solubility coefficient from the following formula:
            // Henry's Law constant: kH(T) = kH * exp(d(ln(kH))/d(1/T) ((1/T) - 1/(298.15 K)))
            // where kH as per NIST 0.034 mol/lg*bar,
            // d(ln(kH))/d(1/T) = 2600
            // $khCO2 = 0.034;
            // $dtCO2 = 2600;
            // //Convert pressure to kPa
            // $p = $p * 100;
            // //Now let's calculate the partial pressure using the Henry's constant:
            // $kCO2 = $khCO2 * exp($dtCO2 * (1/($t + 273) - 1/285.15));   # mol/kg*bar
            // //print("kCO2 [mol/kg*bar]= ", kCO2)
            // //Converting from % to mg/l
            // $CO2 = $conCO2 * 44000 / 22.4 * 273 / (273 + $t) * 10 * $p / 1013;
            // // 1 mol/kg of CO2 => 44 g/l or 44000 mg/l assuming that 1l = 1kg the partial pressure equals:
            // $pCO2 = $CO2 / $kCO2 / 44000;   # kPa
            // //print("pCO2 [kPa] = ", pCO2)
            // Same conversion for H2S partial pressure calculations
            // $khH2S = 0.10;
            // $dtH2S = 2600;
            // // Now let's calculate the partial pressure using the Henry's constant:
            // $kH2S = $khH2S * exp($dtH2S * (1/($t + 273) - 1/285.15));   # mol/kg*bar
            // // Converting from % to mg/l
            // $H2S = $conH2S * 34000 / 22.4 * 273 / (273 + $t) * 10 * $p / 1013;
            // // 1 mol/kg of CO2 => 34 g/l or 34000 mg/l assuming that 1l = 1kg the parital pressure equals:
            // $pH2S = $H2S / $kH2S / 34000;   # kPa
            // // Converting from % to ppm
            // $ppmH2S = $conH2S * 10000;
            // $pH2S = $pH2S / 1000;  #convert to float type and MPa
            $pH2S = $p * $conH2S_frac / 100; // partial pressure H2S in kPa
            $ratio = $pCO2 / $pH2S;

            if ($pCO2 / $pH2S >= 20){
            //if ($pH2S < 0.3){// in kPa
                $x = 7.96 - 2320 / ($t+273);
                $y = $t * 5.55 * pow(10,-3);
                $z = 0.67 * log10($co2);
                $omega = $x - $y + $z;
                $r_a = pow(10,$omega);
                ob_start(); //Start output buffer
                echo "CO2";
                $environment_a = "CO2";
                $output_a = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
                //return $r;
            }
                //r = pow(10, (7.96 - 2320 / (t + 273) - 5.55 * 10**(-3) * t + 0.67 * math.log10(co2))
            else if ($pCO2 / $pH2S < 20) {
            //else if ($pH2S > 0.3){
                //$r_a = -0.6274 + 0.01318 * $conCO2 + 0.02397 * $conH2S;
                //Скорость корр = -0,6274+16,9875*p(H2S)+12,0596*p(CO2)
                $r_a = -0.6274 + 16.9875 * $pH2S / 100 + 12.0596 * $pCO2 / 100; // Partial pressure was calculated in bar
                ob_start(); //Start output buffer
                echo "H2S+CO2";
                //$environment_a = "H2S+CO2";
                $output_a = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
                //return $r;
            }

            if  ($r_a > 0.125) {
                if ($conH2S < 17) {
                    $dose_a = 14.177 * log($r_a) + 35.222;
                    //return $dose;
                }
                else if ($conH2S > 17) {
                    $dose_a = 13.137 * log($r_a) + 26.859;
                    //return $dose;
                }
            }

            else {
                $dose_a = 0;
            }
            // //************************************************//
            // //LOCAL CORROSION CALCULATION IN POINT A*//
            // //************************************************//
                //H2O water concentration in %
                $H2O = $request->H2O; // БД ОМГ НГДУ
                //Please enter T temperature in C
                $T = 25; //
                //Pressure in bar [convert to psi]
                $P = $P_bufer * 14.503773773; //БД ОМГ НГДУ
                //pH2S partial pressure kPa [convert to psi]
                $pH2S = $pH2S * 0.1450377377;
                //pCO2 partial pressure kPa [convert to psi]
                $pCO2 = $pCO2 * 0.1450377377;
                //SO4 content in mg/dm3
                $SO4 = $request->SO4; // БД Лабораторная по жидкости
                $SO4 = $SO4 * 0.0208; // convert from mg/l => mgEq/l
                //HCO3 content in mg/dm3
                $HCO3 = $request->HCO3; // БД Лабораторная по жидкости
                $HCO3 = $HCO3 * 0.0164; // convert from mg/l => mgEq/l
                //CL content in mg/dm3
                $Cl = $request->Cl; // БД Лабораторная по жидкости
                $Cl = $Cl * 0.0282; // convert from mg/l => mgEq/l

                //def corrosion_rate(H2O,P,T,pH2S,pCO2,HCO3,Cl):

                //PAPAVINASAM Corrosion rate
                $pcr_W = 0.54 * $H2O + 12.13;
                $pcr_T = 0.57 * $T + 20;
                $pcr_P = -0.081 * $P + 88;
                $pcr_H2S = -0.54 * $pH2S + 67;
                $pcr_CO2 = -0.63 * $pCO2 + 74;
                $pcr_SO4 = -0.013 * $SO4 + 57;
                $pcr_HCO3 = -0.014 * $HCO3 + 81;
                $pcr_Cl = -0.0007 * $Cl + 9.2;

                $arr = array($pcr_W, $pcr_T, $pcr_P, $pcr_H2S, $pcr_CO2, $pcr_SO4, $pcr_HCO3, $pcr_Cl);
                $PCR = array_sum($arr)/8; // mpy
                // Local corrosion rate in point A
                $PCR_A = 0.0254  * $PCR; // convert mpy => mm per year


            //Calculating the corrosion rate as per de Waard and Milliams, which is used in Royal Dutch Shell
            //log r = 7.96 - 2320 / (T + 273) - 5.55 * 10^-3 * T + 0.67 * log(pCo2)
            //pressure in bar
            //***********************************//
            // GENERAL CORROSION RATE IN POINT E //
            //***********************************//
            $p = $P_pump * 100; // БД ОМГ НГДУ from bar to kPa
            $t_heater = $request->t_heater; // БД ОМГ НГДУ temperature from Печь taken from database
            $t = $t_heater; // measured in Celsius
            //H2S concentration
            $conH2S = $request->conH2S; // БД Лаборатория жидкости, mg/l soluble in water previous was mole fraction ex: 0.0001
            //$conH2S = $conH2S * 0.07055; // from mg/l => volumetric fraction
            $conH2S_frac = $conH2S * 0.07055; // from mg/l => volumetric fraction
            //CO2 concentration
            $conCO2 = $request->conCO2; // БД Лаборатория жидкости, mg/l soluble in water previous was mole fraction ex: 0.0001
            //$conCO2 = $conCO2 * 0.05464; // from mg/l => volumetric fraction
            $conCO2_frac = $conCO2 * 0.05464; // from mg/l => volumetric fraction
            $pCO2 = $conCO2_frac / 100 * $p;

            //convert data to proper type
            $co2 = $pCO2 / 1000; //convert partial pressure CO2 from kPa => MPa

            // //def corrosion_rate(co2,t):

            // $a = 7.96 - 2320 / ($t+273);
            // $b = $t * 5.55 * pow(10,-3);
            // $c = 0.67 * log10($co2);
            // $d = $a - $b + $c;
            // $r = pow(10,$d);
            // // r = pow(10, (7.96 - 2320 / (ti + 273) - 5.55 * 10**(-3) * ti + 0.67 * math.log10(co2))
            // // return r
            // //x = corrosion_rate(co2,t)

            //***************************************//
            //GENERAL CORROSION CALCULATION POINT E *//
            //***************************************//

            $pH2S = $p * $conH2S_frac / 100; // partial pressure H2S in kPa//
            $ratio = $pCO2 / $pH2S;

            if ($pCO2 / $pH2S >= 20){
            //if ($pH2S < 0.3){// in kPa
                $x = 7.96 - 2320 / ($t+273);
                $y = $t * 5.55 * pow(10,-3);
                $z = 0.67 * log10($co2);
                $omega = $x - $y + $z;
                $r_e = pow(10,$omega);
                ob_start(); //Start output buffer///
                echo "CO2";
                $output_e = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
            }
                //r = pow(10, (7.96 - 2320 / (t + 273) - 5.55 * 10**(-3) * t + 0.67 * math.log10(co2))
            else if ($pCO2 / $pH2S < 20) {
            //else if ($pH2S > 0.3){// in kPa
                //$r_e = -0.6274 + 0.01318 * $conCO2 + 0.02397 * $conH2S;
                //Скорость корр = -0,6274+16,9875*p(H2S)+12,0596*p(CO2)
                $r_e = -0.6274 + 16.9875 * $pH2S / 100 + 12.0596 * $pCO2 / 100; //Partial pressure calculated in bar
                ob_start(); //Start output buffer
                echo "H2S+CO2";
                $output_e = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
            }

            if  ($r_e > 0.125) {
                if ($conH2S < 17 ) {
                    $dose_e = 14.177 * log($r_e) + 35.222;
                    //return $dose;
                }
                else if ($conH2S > 17) {
                    $dose_e = 13.137 * log($r_e) + 26.859;
                    //return $dose;
                }
            }

            else {
                $dose_e = 0;
            }
            //************************************************//
            //LOCAL CORROSION CALCULATION IN POINT E PIPELINE*//
            //************************************************//
                //H2O water concentration in %
                $H2O = $request->H2O; // БД ОМГ НГДУ
                //Please enter T temperature in C
                $T = $t_heater; // БД ОМГ НГДУ
                //Pressure in bar [convert to psi]
                $P = $P_pump * 14.503773773; //БД ОМГ НГДУ
                //pH2S partial pressure kPa [convert to psi]
                $pH2S = $pH2S * 0.1450377377;
                //pCO2 partial pressure kPa [convert to psi]
                $pCO2 = $pCO2 * 0.1450377377;
                //SO4 content in mg/dm3
                $SO4 = $request->SO4; // БД Лабораторная по жидкости
                $SO4 = $SO4 * 0.0208; // convert from mg/l => mgEq/l
                //HCO3 content in mg/dm3
                $HCO3 = $request->HCO3; // БД Лабораторная по жидкости
                $HCO3 = $HCO3 * 0.0164; // convert from mg/l => mgEq/l
                //CL content in mg/dm3
                $Cl = $request->Cl; // БД Лабораторная по жидкости
                $Cl = $Cl * 0.0282; // convert from mg/l => mgEq/l

                //def corrosion_rate(H2O,P,T,pH2S,pCO2,HCO3,Cl):

                //PAPAVINASAM Corrosion rate
                $pcr_W = 0.54 * $H2O + 12.13;
                $pcr_T = 0.57 * $T + 20;
                $pcr_P = -0.081 * $P + 88;
                $pcr_H2S = -0.54 * $pH2S + 67;
                $pcr_CO2 = -0.63 * $pCO2 + 74;
                $pcr_SO4 = -0.013 * $SO4 + 57;
                $pcr_HCO3 = -0.014 * $HCO3 + 81;
                $pcr_Cl = -0.0007 * $Cl + 9.2;

                $arr = array($pcr_W, $pcr_T, $pcr_P, $pcr_H2S, $pcr_CO2, $pcr_SO4, $pcr_HCO3, $pcr_Cl);
                $PCR = array_sum($arr)/8; // mpy
                // Local corrosion rate in point G pipeline
                $PCR_E = 0.0254  * $PCR; // convert mpy => mm per year


            //***********************************//
            // GENERAL CORROSION RATE IN POINT F //
            //***********************************//
            $p = $P_final * 100; //from bar to kPa
            $t = $t_final; //
            //H2S concentration
            $conH2S = $request->conH2S; // БД Лаборатория жидкости, mg/l soluble in water previous was mole fraction ex: 0.0001
            //$conH2S = $conH2S * 0.07055; // from mg/l => volumetric fraction
            $conH2S_frac = $conH2S * 0.07055; // from mg/l => volumetric fraction
            //CO2 concentration
            $conCO2 = $request->conCO2; // БД Лаборатория жидкости, mg/l soluble in water previous was mole fraction ex: 0.0001
            //$conCO2 = $conCO2 * 0.05464; // from mg/l => volumetric fraction
            $conCO2_frac = $conCO2 * 0.05464; // from mg/l => volumetric fraction
            $pCO2 = $conCO2_frac * $p / 100;

            //convert data to proper type
            $co2 = $pCO2 / 1000; //convert partial pressure CO2 from kPa => MPa

            // //def corrosion_rate(co2,t):

            // $a = 7.96 - 2320 / ($t+273);
            // $b = $t * 5.55 * pow(10,-3);
            // $c = 0.67 * log10($co2);
            // $d = $a - $b + $c;
            // $r = pow(10,$d);
            // // r = pow(10, (7.96 - 2320 / (ti + 273) - 5.55 * 10**(-3) * ti + 0.67 * math.log10(co2))
            // // return r
            // //x = corrosion_rate(co2,t)

            //***************************************//
            //GENERAL CORROSION CALCULATION POINT F *//
            //***************************************//

            $pH2S = $p * $conH2S_frac / 100; // partial pressure H2S in kPa
            $ratio = $pCO2 / $pH2S;
            //$r_f = 0;

            if ($pCO2 / $pH2S >= 20){
            //if ($pH2S <= 0.3){// in kPa
                $x = 7.96 - 2320 / ($t+273);
                $y = $t * 5.55 * pow(10,-3);
                $z = 0.67 * log10($co2);
                $omega = $x - $y + $z;
                $r_f = pow(10,$omega);
                ob_start(); //Start output buffer
                echo "CO2";
                $output_f = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
            }
                //r = pow(10, (7.96 - 2320 / (t + 273) - 5.55 * 10**(-3) * t + 0.67 * math.log10(co2))
            else if ($pCO2 / $pH2S < 20) {
            //else if ($pH2S > 0.3){// in kPa
                //$r_f = -0.6274 + 0.01318 * $conCO2 + 0.02397 * $conH2S;
                //Скорость корр = -0,6274+16,9875*p(H2S)+12,0596*p(CO2)
                $r_f = -0.6274 + 16.9875 * $pH2S / 100 + 12.0596 * $pCO2 / 100; //Partial pressure calculated in bar
                ob_start(); //Start output buffer
                echo "H2S+CO2";
                $output_f = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
            }

            if  ($r_f > 0.125) {
                if ($conH2S < 17 ) {
                    $dose_f = 14.177 * log($r_f) + 35.222;
                    //return $dose;
                }
                else if ($conH2S > 17) {
                    $dose_f = 13.137 * log($r_f) + 26.859;
                    //return $dose;
                }
            }

            else {
                $dose_f = 0;
            }

            //************************************************//
            //LOCAL CORROSION CALCULATION IN POINT F PIPELINE*//
            //************************************************//
                //H2O water concentration in %
                $H2O = $request->H2O; // БД ОМГ НГДУ
                //Please enter T temperature in C
                $T = $t_final - 273; //
                //Pressure in bar [convert to psi]
                $P = $P_final * 14.503773773;
                //pH2S partial pressure kPa [convert to psi]
                $pH2S = $pH2S * 0.1450377377;
                //pCO2 partial pressure kPa [convert to psi]
                $pCO2 = $pCO2 * 0.1450377377;
                //SO4 content in mg/dm3
                $SO4 = $request->SO4; // БД Лабараторная по жидкости
                $SO4 = $SO4 * 0.0208; // convert from mg/l => mgEq/l
                //HCO3 content in mg/dm3
                $HCO3 = $request->HCO3; // БД Лабараторная по жидкости
                $HCO3 = $HCO3 * 0.0164; // convert from mg/l => mgEq/l
                //CL content in mg/dm3
                $Cl = $request->Cl; // БД Лабараторная по жидкости
                $Cl = $Cl * 0.0282; // convert from mg/l => mgEq/l

                //def corrosion_rate(H2O,P,T,pH2S,pCO2,HCO3,Cl):

                //PAPAVINASAM Corrosion rate
                $pcr_W = 0.54 * $H2O + 12.13;
                $pcr_T = 0.57 * $T + 20;
                $pcr_P = -0.081 * $P + 88;
                $pcr_H2S = -0.54 * $pH2S + 67;
                $pcr_CO2 = -0.63 * $pCO2 + 74;
                $pcr_SO4 = -0.013 * $SO4 + 57;
                $pcr_HCO3 = -0.014 * $HCO3 + 81;
                $pcr_Cl = -0.0007 * $Cl + 9.2;

                $arr = array($pcr_W, $pcr_T, $pcr_P, $pcr_H2S, $pcr_CO2, $pcr_SO4, $pcr_HCO3, $pcr_Cl);
                $PCR = array_sum($arr)/8; // mpy
                // Local corrosion rate in point F
                $PCR_F = 0.0254  * $PCR; // convert mpy => mm per year


                /////////////////////////////////
                //MAX DOSE
                $max_dose = max($dose_a, $dose_e, $dose_f);
                /////////////////////////////////

        $vdata = [
            'flow_velocity_meter_per_sec' => round($v_lo,1),
            'm_dot' => round($m_dot,2),
            'final_pressure_bar_point_F' => round($P_final,2),
            'corrosion_rate_mm_per_y_point_A' => round($r_a,1),
            'corrosion_rate_mm_per_y_point_E' => round($r_e,1),
            'corrosion_rate_mm_per_y_point_F' => round($r_f,1),
            'dose_mg_per_l_point_A' => round($dose_a,2),
            'dose_mg_per_l_point_E' => round($dose_e,2),
            'dose_mg_per_l_point_F' => round($dose_f,2),
            'max_dose' => round($max_dose,2),
            //'warning' => $warning,
            'GOR1' => $GOR1,
            'GOR' => $GOR,
            'q_o' => round($q_o,4),
            'q_g_sib' => round($q_g_sib,4),
            'q_l' => round($q_l,4),
            'q_g' => round($q_g,4),
            //'Q_h' => round($Q_h,4),
            //'dP' => round($dP,4),
            //'d' => round($d,4),
            //'GOR' => round($GOR,4),
            //'Re_lo' => round($Re_lo,4),
            //'Re_go' => round($Re_go,4),
            //'rho_h' => round($rho_h,4),
            //'mdotl' => round($m_dotl,4),
            //'mdotg' => round($m_dotg,4),
            't_final_celsius_point_F' => round($t_final,1),
            //'corrosion_mm_per_year' => round($r,4),
            'pCO2_kPa' => round($pCO2,4),
            'pH2S_kPa' => round($pH2S,4),
            //'dose_mg_per_l' => round($dose,4),
            //'H2S_mg_per_l' => round($H2S,4),
            //'CO2_mg_perl' => round($CO2,4),
            //'environment_point_A' => $environment_a,
            'environment_point_A' => $output_a,
            'environment_point_E' => $output_e,
            'environment_point_F' => $output_f,
            //'pCO2_per_pH2S' => $ratio,
            'papavinasam_corrosion_mm_per_y_point_A' => round($PCR_A,2),
            'papavinasam_corrosion_mm_per_y_point_E' => round($PCR_E,2),
            'papavinasam_corrosion_mm_per_y_point_F' => round($PCR_F,2),
        ];


        return response()->json($vdata);


        } else {
            return "Error. Invalid url";
        }
    }
    public function tr()
    {
        return view('tr.tr');
    }    ///
    public function fa()
    {
        return view('fa.fa');
    }    ///
    public function trfa()
    {
        return view('trfa.trfa');
    }    ///
}
