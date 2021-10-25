<?php

namespace App\Console\Commands;

use App\Models\ComplicationMonitoring\OmgCA;
use App\Models\ComplicationMonitoring\OmgUHE;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateCurrentDosageOmgUhe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc_dosage_omg_uhe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate OMG UHE dosage';

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
        $omg_uhes = OmgUHE::get();
        foreach ($omg_uhes as $key => $omg_uhe) {
            $previous_data = OmgUHE::where('gu_id', $omg_uhe->gu_id)
                ->where('date', '<', $omg_uhe->date)
                ->where('out_of_service_of_dosing', '!=', '1')
                ->orderByDesc('date')
                ->first();

            $ddng = OmgCA::where('gu_id', $omg_uhe->gu_id)
                ->where('date', Carbon::parse($omg_uhe->date)->year . "-01-01")
                ->first();

            if (!($previous_data && $ddng && $ddng->q_v)) {
                continue;
            }

            $qv = ($ddng->q_v * 1000) / 365;
            $previous_level = $previous_data->fill ?? $previous_data->level;
            $level = $omg_uhe->level > $previous_level ? $previous_level : $omg_uhe->level;
            $consumption = $previous_level - $level;
            $currentDosage = ($consumption / $qv) * 954;
            $currentDosage = $currentDosage > 0 ? $currentDosage : 0;
            $daily_inhibitor_flowrate = ($currentDosage * $qv / 1000);

            $omg_uhe->current_dosage = $currentDosage;
            $omg_uhe->daily_inhibitor_flowrate = $daily_inhibitor_flowrate;
            $omg_uhe->save();
        }
    }
}
