<?php

function getCurrencyPeriod()
{

    $type = 1; // or $type = -1
    $current_month = date('m');
   // $begin = mktime(0, 0, 0, $current_month + $type, 1, date("Y"));
    echo $current_month ;

    for ($i = 01; $i <= $current_month; $i++) {
        $dates = "01.0" . $i . ".2020";
        $url = "https://www.nationalbank.kz/rss/get_rates.cfm?fdate=" . $dates;
        $dataObj = simplexml_load_file($url);
        if ($dataObj) {
            foreach ($dataObj as $item) {
                if ($item->title == 'USD') {
                    // echo $dates;
                    $description = $item->description;
                  //  echo $description;
                    //$z[$i] = $i;
                    $array[$i] =  array(
                        "dates" => $dates,
                        "description" => $description,
                    );
                }
            }
        }
    }    
    //return $array;
    echo '<pre>';
    print_r ($array);
    echo '</pre>';
}


print_r(getCurrencyPeriod());
