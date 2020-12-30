<?php

namespace App\Console\Commands;

use App\Models\UsdRate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsdParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is designed to parse the dollar rate from the data of the National Bank of Kazakhstan';

    private $parseDates = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getLastDayRate($searchDate)
    {
        $data = UsdRate::query()
            ->where('date', '=', $searchDate)
            ->get()
            ->toArray();

        if (!count($data)) {
            error_log('За указанную дату записи не найдено');

            $this->parseDates[] = $searchDate;
            $newSearchDate = date('Y-m-d', strtotime($searchDate . '- 1 day'));
            $this->getLastDayRate($newSearchDate);
        }

        if (count($data) && count($this->parseDates)) {
            $this->parseDates = array_reverse($this->parseDates);
            dd($this->parseDates);
        }

        if (count($data) && !count($this->parseDates)) {
            dd('Update');
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        echo date('d.m.Y');

//        $testDate = strtotime('17.11.1999');
//
////        dd($testDate);
//
////        $url = "https://www.nationalbank.kz/rss/get_rates.cfm?fdate=" . date('d.m.Y');
//        $url = "https://www.nationalbank.kz/rss/get_rates.cfm?fdate=" . date('d.m.Y', $testDate);
//        $dataObj = simplexml_load_file($url);
//
//        if ($dataObj) {
//            foreach ($dataObj as $item) {
//                if ($item->title == 'USD') {
//                    dd($item);
//                }
//            }
//        }

//        exit;

        $datesNow = date('d.m.Y');
        $dateNowDb = date('Y-m-d');
        $period = 5;
        $datesNowString = strtotime($datesNow);
        $last = strtotime('17.11.1999');
//        $last = strtotime($datesNow . '- 1 month');
        $countDay = ($datesNowString - $last) / 86400;


//        $data = UsdRate::query()
//            ->where('date', '=', $dateNowDb)
//            ->get()
//            ->toArray();

//        dd($data);

//        $this->getLastDayRate($dateNowDb);

//        exit;

        for (
            $i = 1;
            $i <= $countDay;
            $i++
        ) {
            $last = $last + 86400;
            $parseDate = date('d.m.Y', $last);
            $dateForDb = date('Y-m-d', $last);
            $url = "https://www.nationalbank.kz/rss/get_rates.cfm?fdate=" . $parseDate;
            $dataObj = simplexml_load_file($url);
            if ($dataObj) {
                foreach ($dataObj as $item) {
                    if ($item->title == 'USD') {
                        DB::table('usd_rate')->insert(
                            [
                                'value' => $item->description,
                                'change' => $item->change,
                                'index' => $item->index,
                                'date' => $dateForDb,
                            ]
                        );

                        error_log($item->description);
                        error_log($item->index);
                        error_log($item->change);
                        error_log($parseDate);
                        error_log('==============================================');

//                        echo($test);

//                        $description = $item->description;
//                        $array[$i] =  array(
//                            "dates" => $dates,
//                            "description" => $description,
//                            "change" => $item->change,
//                            "index" => $item->index,
//                        );
                    }
                }
            }
        }
    }
}
