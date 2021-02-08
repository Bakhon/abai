<?php

namespace App\Console\Commands;

use App\Models\OilRate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OilParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse-oil:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is designed to parse the oil rate from the data of the Yandex quote news';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getOilRates()
    {
      $this->deleteOldRates();

      $url = "https://yandex.ru/news/quotes/graph_1006.json";
      $dataObj = json_decode(file_get_contents($url), true);
      if (!$dataObj) return;

      $oilPricesByDate = array_values($dataObj['prices']);
      foreach($oilPricesByDate as $item) {
        list($date,$price) = $item;
        $this->insertOilRatesInDB($price,$date);
      }

    }

    public function deleteOldRates()
    {
      return OilRate::query()
          ->delete();
    }

    public function insertOilRatesInDB ($price, $date)
    {
      $priceDate = $this->formatDate($date, 'Y.m.d');
        DB::table('oil_rate')->insert(
          [
              'value' => $price,
              'date' => $priceDate,
          ]
        );
    }

    public function formatDate($dateInMs, $format)
    {
      $seconds = $dateInMs / 1000;
      return date($format, $seconds);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
     public function handle()
     {
         $this->getOilRates();
     }
}
