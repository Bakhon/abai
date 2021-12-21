<?php

namespace App\Console\Commands;

use App\Models\ComplicationMonitoring\OmgNGDU;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ParseOmgNgduTempPressData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse_omg_ngdu_temp_press_data:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse data from omg_n_g_d_u_s_temperature_pressure table to omg_n_g_d_u_s_1 table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!Schema::hasTable('omg_n_g_d_u_s_temperature_pressure')) {
            $message = 'omg_n_g_d_u_s_temperature_pressure table not exists';
            Log::channel('parse_omg_ngdu_temp_press_data')->info($message);
            $this->info($message);
            return;
        }

        $lastDays = Carbon::now()->subDays(4)->format('Y-m-d');
        $temp_press = DB::table('omg_n_g_d_u_s_temperature_pressure')
            ->where('date', '>=', $lastDays)
            ->orderByDesc('date')
            ->get();

        $message = 'Total '.$temp_press->count().' rows data';
        Log::channel('parse_omg_ngdu_temp_press_data')->info($message);
        $this->info($message);

        foreach ($temp_press as $row) {
            $omgNgdu = OmgNGDU::where('date', $row->date)
                ->where('gu_id', $row->gu_id)->first();

            if (!$omgNgdu) {
                $omgNgdu = new OmgNGDU();
                $omgNgdu->date = $row->date;
                $omgNgdu->gu_id = $row->gu_id;
                $omgNgdu->cruser_id = 1;
            }

            $omgNgdu->heater_output_temperature = $row->heater_output_temperature;
            $omgNgdu->surge_tank_pressure = $row->surge_tank_pressure;
            $omgNgdu->save();

            $message = 'OMG NGDU with date '.$row->date.' and gu_id '.$row->gu_id.' updated!';
            Log::channel('parse_omg_ngdu_temp_press_data')->info($message);
            $this->info($message);
        }
    }
}
