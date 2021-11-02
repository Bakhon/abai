<?php

namespace App\Console\Commands;

use App\Models\ComplicationMonitoring\ManualGu;
use App\Models\ComplicationMonitoring\ManualHydroCalcLong;
use App\Models\ComplicationMonitoring\ManualHydroCalcResult;
use App\Models\ComplicationMonitoring\ManualOilPipe;
use App\Models\ComplicationMonitoring\ManualWell;
use App\Models\ComplicationMonitoring\ManualZu;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\OmgNGDUWell;
use App\Models\ComplicationMonitoring\OmgNGDUZu;
use App\Models\ComplicationMonitoring\PipeCoord;
use App\Traits\ParseOmgNgduWellTrait;
use Illuminate\Console\Command;

class DeleteManualMapObjects extends Command
{
    use ParseOmgNgduWellTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete_manual_map_objects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear map data, delete manual objects except Gu-22';

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
        $manual_pipes = ManualOilPipe::where('gu_id', '!=', 10010)->get();
        $pipe_coords = PipeCoord::whereIn('oil_pipe_id', $manual_pipes->pluck('id'))->get();
        $calc_long = ManualHydroCalcLong::whereIn('oil_pipe_id', $manual_pipes->pluck('id'))->delete();
        $calc = ManualHydroCalcResult::whereIn('oil_pipe_id', $manual_pipes->pluck('id'))->delete();
        $manual_zus = ManualZu::where('gu_id', '!=', 10010)->get();
        $manual_gus = ManualGu::where('id', '!=', 10010)->get();
        $manual_wells = ManualWell::where('gu_id', '!=', 10010)->get();
        $omgngdu_wells = OmgNGDUWell::whereIn('well_id', $manual_wells->pluck('id'))->get();
        $omgngdu_zus = OmgNGDUZu::whereIn('zu_id', $manual_zus->pluck('id'))->get();
        $omgngdu_gus = OmgNGDU::whereIn('gu_id', $manual_gus->pluck('id'))->get();

        $variables_to_delete = [
            'pipe_coords',
            'manual_zus',
            'manual_gus',
            'manual_wells',
            'omgngdu_wells',
            'omgngdu_zus',
            'omgngdu_gus',
            'manual_pipes'
        ];

        foreach ($variables_to_delete as $var) {
            $var_name = substr($var,0,-1);

            foreach ($$var as $$var_name) {
                $$var_name->forceDelete();
            }
        }
    }
}
