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
    public function index()
    {

        // $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);
        // $response = $client->query('well_daily_oil2_v4', Granularity::ALL)
        //     ->interval('2012-12-24 20:00:00', '2020-12-24 22:00:00')
        //     ->count('totalNrRecords')
        //     ->execute();

        return view('druid');
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
        if ($request->has('q_l') && $request->has('rhol') && $request->has('GOR') && $request->has('SG') && 
        $request->has('d') && $request->has('mul') && $request->has('l') && $request->has('roughness') &&
        $request->has('mug') && $request->has('mug') && $request->has('P')) {
            //$flow = $request->flow;
            //flowrate of liquid            
            $q_l = $request->q_l; // input in pipesim
            $WC = 30; // input in pipesim
            $q_l = $q_l / 24.0 / 60.0 / 60.0 * (1 - $WC); // input in pipesim
            //liquid density
            $rhol = $request->rhol; //input in pipesim 
            //flowrate of gas
            $GOR = $request->GOR; // input in pipesim
            $q_g = $q_l * $GOR;
            //density of gas
            $SG = $request-> SG;
            $rhog = $SG * 1.204 // 1.204 kg/m3 = SG of Water
            //mass flowrate of liquid
            $m_dotl = $rhol * $q_l;
            //mass flowrate of gas
            $m_dotg = $rhog * $q_g;
            //combined mass flowrate of mixture
            $m_dot = $m_dotl + $m_dotg;
            //Density of two phase
            $x = $m_dotg / $m_dot;
            //Dead oil viscosity
            $mul = $request->mul;
            // //Viscosity of gas
            $mug = $request->mug;
            $sigma = $request->sigma;
            $d = $request->d;
            $roughness = $request->roughness;
            $l = $request->l;
            $P = $request->P;
            //Gravitational acceleration
            $g = 9.8;
            // $h = $request->h;
//          Liquid-only properties, for calculation of E, dP_lo
//          Calculate velocity
            $v_lo = $m_dot/$rhol/(pi()/4*$d**2);
//          Calculate Reynolds number 
            $Re_lo = $v_lo * $d * $rhol / $mul;
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
            $flow = $Q_h * 3600 * 24 * (1-$GOR);
            //Outside diameter in m
            $do = 0.110;
            //Inside diameter in m
            $di = 0.100;
            //Roughness in m
            $roughness = 0.00004572;
            //Density in kg / m3
            $density = $rho_h;
            //Fluid viscosity in Pa.s  x 1000 to cP
            $viscosity = 7.974;
            //Length of the pipe in m
            $l = 1000.0;
            //thermal conductivity of piping material in W/(m*K)
            $k = 45;
            //thermal conductivity of fluid in W/(m*k)
            $k_f = 0.6;
            //thermal conductivity of ground 
            $k_g = 0.774;
            //Outside temperature in K
            $to = 288.0;
            //Inside temperature in K
            $ti = 313.0;
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


            //def temp_drop(flow,do,di,roughness,density,viscosity,l,k,k_f,k_g,to,ti,c_p,g,sigma_s,epsilon):
            //calculate the mass flow rate
            $m_dot = $flow * $density;
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


            //Calculating the corrosion rate as per de Waard and Milliams, which is used in Royal Dutch Shell
            //log r = 7.96 - 2320 / (T + 273) - 5.55 * 10^-3 * T + 0.67 * log(pCo2)
            //pressure in bar
            $p = 7;//$P_final;
            $t = 40;//$t_final - 273;  //temperature in K
            //H2S concentration
            $conH2S = 0.01;  //0.0008;
            //CO2 concentraiton
            $conCO2 = 0.008; //0.008;

            //According to Dalton's law of partial pressures, the partial pressure of CO2 is proportional to the mole fraction
            //First we need to get the solubility coefficient from the following formula:
            //Henry's Law constant: kH(T) = kH * exp(d(ln(kH))/d(1/T) ((1/T) - 1/(298.15 K)))
            //where kH as per NIST 0.034 mol/lg*bar, 
            //d(ln(kH))/d(1/T) = 2600
            $khCO2 = 0.034;
            $dtCO2 = 2600;

            //Now let's calculate the partial pressure using the Henry's constant:
            $kCO2 = $khCO2 * exp($dtCO2 * (1/($t + 273) - 1/285.15));   # mol/kg*bar
            //print("kCO2 [mol/kg*bar]= ", kCO2)
            //Converting from % to mg/l
            $CO2 = $conCO2 * 44000 / 22.4 * 273 / (273 + $t) * 10 * $p / 1013;
            // 1 mol/kg of CO2 => 44 g/l or 44000 mg/l assuming that 1l = 1kg the partial pressure equals:
            $pCO2 = $CO2 / $kCO2 / 44000;   # kPa
            //print("pCO2 [kPa] = ", pCO2)

            //convert data to proper type
            $co2 = $pCO2 / 1000; //convert to float type and MPa

            //def corrosion_rate(co2,t):
                
            $a = 7.96 - 2320 / ($t+273);
            $b = $t * 5.55 * pow(10,-3);
            $c = 0.67 * log10($co2);
            $d = $a - $b + $c;
            $r = pow(10,$d);
            // r = pow(10, (7.96 - 2320 / (ti + 273) - 5.55 * 10**(-3) * ti + 0.67 * math.log10(co2))
            // return r
            //x = corrosion_rate(co2,t)

            //******************************//
            //GENERAL CORROSION CALCULATION*//
            //******************************//

            // According to Dalton's law of partial pressures, the partial pressure of CO2 is proportional to the mole fraction
            // First we need to get the solubility coefficient from the following formula:
            // Henry's Law constant: kH(T) = kH * exp(d(ln(kH))/d(1/T) ((1/T) - 1/(298.15 K)))
            // where kH as per NIST 0.034 mol/lg*bar, 
            // d(ln(kH))/d(1/T) = 2600
            $khCO2 = 0.034;
            $dtCO2 = 2600;
            //Convert pressure to kPa
            $p = $p * 100;
            //Now let's calculate the partial pressure using the Henry's constant:
            $kCO2 = $khCO2 * exp($dtCO2 * (1/($t + 273) - 1/285.15));   # mol/kg*bar
            //print("kCO2 [mol/kg*bar]= ", kCO2)
            //Converting from % to mg/l
            $CO2 = $conCO2 * 44000 / 22.4 * 273 / (273 + $t) * 10 * $p / 1013;
            // 1 mol/kg of CO2 => 44 g/l or 44000 mg/l assuming that 1l = 1kg the partial pressure equals:
            $pCO2 = $CO2 / $kCO2 / 44000;   # kPa
            //print("pCO2 [kPa] = ", pCO2)

            // Same conversion for H2S partial pressure calculations
            $khH2S = 0.10;
            $dtH2S = 2600;

            // Now let's calculate the partial pressure using the Henry's constant:
            $kH2S = $khH2S * exp($dtH2S * (1/($t + 273) - 1/285.15));   # mol/kg*bar
            // Converting from % to mg/l
            $H2S = $conH2S * 34000 / 22.4 * 273 / (273 + $t) * 10 * $p / 1013;
            // 1 mol/kg of CO2 => 34 g/l or 34000 mg/l assuming that 1l = 1kg the parital pressure equals:
            $pH2S = $H2S / $kH2S / 34000;   # kPa


            // Converting from % to ppm
            $ppmH2S = $conH2S * 10000;
            $pH2S = $pH2S / 1000;  #convert to float type and MPa

            $ratio = $pCO2 / $pH2S; 

            if ($pCO2 / $pH2S >= 500){
                $x = 7.96 - 2320 / ($t+273);
                $y = $t * 5.55 * pow(10,-3);
                $z = 0.67 * log10($pCO2);
                $omega = $x - $y + $z;
                $r = pow(10,$omega);
                ob_start(); //Start output buffer
                echo "CO2";
                $output = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
                //return $r;
            }
                //r = pow(10, (7.96 - 2320 / (t + 273) - 5.55 * 10**(-3) * t + 0.67 * math.log10(co2))
            else if ($pCO2 / $pH2S < 500) {
                $r = -0.605 + 0.390 * $conCO2 + 0.0000932 * $ppmH2S; //ppmH2w parts per million & conCO2 %
                ob_start(); //Start output buffer
                echo "H2S";
                $output = ob_get_contents(); //Grab output
                ob_end_clean(); //Discard output buffer
                //return $r;
            }

            if  ($r > 0 && $r <= 0.125) {
                if ($H2S < 17 && $CO2 < 121) {
                    $dose = 22.725 * log($r) + 58.968;
                    //return $dose;
                }
                else if ($H2S > 17 && $CO2 > 121) {
                    $dose = 26.868 * log($r) + 55.793;
                    //return $dose;
                }
            }
            
            else {
                $dose = 0; }
            
            //****************************//
            //LOCAL CORROSION CALCULATION*//
            //****************************//
                //H2O water concentration in %
                $H2O = 0.90;                  
                //Please enter T temperature in C
                $T = $t_final - 273;
                //Pressure in bar [convert to psi]
                $P = $P_final * 14.503773773;
                //pH2S partial pressure kPa [convert to psi]
                $pH2S = $pH2S * 0.1450377377;
                //pCO2 partial pressure kPa [convert to psi]
                $pCO2 = $pCO2 * 0.1450377377;
                //SO4 partial pressure in mg/dm3 [convert to ppm]
                $SO4 = 200;
                $SO4 = $SO4 * 1; 
                //HCO3 partial pressure in mg/dm3 [convert to ppm]
                $HCO3 = 200;
                $HCO3 = $HCO3 * 1; 
                //CL partial pressure in mg/dm3 [convert to ppm] :  "))
                $Cl = 200;
                $Cl = $Cl * 1; 
                
                //def corrosion_rate(H2O,P,T,pH2S,pCO2,HCO3,Cl):

                $pcr_W = 0.51 * $H2O + 12.13;
                $pcr_T = 0.57 * $T + 20;
                $pcr_P = -0.081 * $P + 88;
                $pcr_H2S = -0.54 * $pH2S + 67;
                $pcr_CO2 = -0.63 * $pCO2 + 74;
                $pcr_SO4 = -0.013 * $SO4 + 57;
                $pcr_HCO3 = -0.014 * $HCO3 + 81;
                $pcr_Cl = -0.0007 * $Cl + 9.2;
                    
                $arr = array($pcr_W, $pcr_T, $pcr_P, $pcr_H2S, $pcr_CO2, $pcr_SO4, $pcr_HCO3, $pcr_Cl);
                $PCR = array_sum($arr)/8;
                    

        $vdata = [
            'Final pressure' => $P_final,
            'corrosion rate in mm' => $r,
            'final temperature' => $t_final,
            'dose' => $dose,
            'dP' => $dP,
            't_final K' => round($t_final,4),
            'corrosion mm per year' => round($r,4),
            'pCO2 kPa' => round($pCO2,4),
            'pH2S kPa' => round($pH2S,4),
            'dose mg per l' => round($dose,4),
            'H2S mg per l' => round($H2S,4),
            'CO2 mg perl' => round($CO2,4),
            'environment' => $output,
            'pCO2 per pH2S' => $ratio,
            'Papavinasam corrosion' => $PCR,
            //var_dump(round(5.045, 2));
            // 'averageProfitlessCat1MonthCount' => round($averageProfitlessCat1Month),
            // 'prs' => round($array5[0]["prs1"]),
            // 'wellsList' => $data['wellsList'],
            // 'OperatingProfitMonth' => $data['OperatingProfitMonth'],
            // 'OperatingProfitYear' => $data['OperatingProfitYear'],
            // 'prs1' => $data['prs1'],
            // 'chart1' => $dataChart,
            // 'chart2' => $dataChart2,
            // 'chart3' => $dataChart3,
            // 'chart4' => $dataChart4,
        ];


        return response()->json($vdata); 
 

        } else {
            return "Error. Invalid url";
        }
    }
    ///
}
