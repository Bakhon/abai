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
    protected $signature = 'parse-usd:cron';

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

    public function getRateData($date, $type)
    {
        $url = "https://www.nationalbank.kz/rss/get_rates.cfm?fdate=" . date('d.m.Y', strtotime($date));
        $dataObj = simplexml_load_file($url);

        if ($dataObj) {
            foreach ($dataObj as $item) {
                if ($item->title == 'USD') {
                    if ($type == 'insert') {
                        DB::table('usd_rate')->insert(
                            [
                                'value' => $item->description,
                                'change' => $item->change,
                                'index' => $item->index,
                                'date' => $date,
                            ]
                        );
                    }

                    if ($type == 'update') {
                        DB::table('usd_rate')
                            ->where('date', '=', $date)
                            ->update(
                                [
                                    'value' => $item->description,
                                    'change' => $item->change,
                                    'index' => $item->index,
                                    'date' => $date,
                                ]
                        );
                    }
                }
            }
        }
    }

    public function getLastDayRate($searchDate)
    {
        $data = UsdRate::query()
            ->where('date', '=', $searchDate)
            ->get()
            ->toArray();

        if (!count($data)) {
            $this->parseDates[] = $searchDate;
            $newSearchDate = date('Y-m-d', strtotime($searchDate . '- 1 day'));
            $this->getLastDayRate($newSearchDate);
        }

        if (count($data) && count($this->parseDates)) {
            $this->parseDates = array_reverse($this->parseDates);

            foreach ($this->parseDates as $date) {
                $this->getRateData($date, 'insert');
            }
        }

        if (count($data) && !count($this->parseDates)) {
            $this->getRateData($searchDate, 'update');
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dateNow = date('Y-m-d');
        $this->getLastDayRate($dateNow);
    }
}
