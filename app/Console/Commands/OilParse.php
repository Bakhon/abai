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
      $data = json_decode(file_get_contents($url), true);
      if (!$data) return;
      $oilPricesByDate = array_values($data['prices']);
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
      OilRate::create([
        'value' => $price,
        'date' => $this->formatDate($date),
      ]);
    }

    public function formatDate($dateInMs)
    {
      $msInThreeHours = 3 * 60 * 60 * 1000;
      $seconds = ($dateInMs - $msInThreeHours) / 1000;
      return date('Y-m-d H:i:s', $seconds);
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
