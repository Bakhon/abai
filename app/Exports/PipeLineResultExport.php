<?php

namespace App\Exports;

use App\Models\ComplicationMonitoring\HydroCalcResult;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PipeLineResultExport implements FromView, ShouldAutoSize
{
    protected $date;

    function __construct($date)
    {
        $this->date = $date;
    }

    public function view(): View
    {
        $results = HydroCalcResult::where('date', $this->date)->with('oilPipe.pipeType')->get();

        $columnNames = [
            '№',
            trans('monitoring.pipe_types.fields.outside_diameter'),
            trans('monitoring.pipe_types.fields.thickness'),
            trans('monitoring.pipe.fields.length'),
            trans('monitoring.omgngdu.fields.daily_fluid_production'),
            trans('monitoring.omgngdu.fields.bsw'),
            trans('monitoring.omgngdu.fields.gas_factor'),
            trans('monitoring.hydro_calculation.fields.pressure_start'),
            trans('monitoring.hydro_calculation.fields.pressure_end'),
            trans('monitoring.hydro_calculation.fields.temperature_start'),
            trans('monitoring.hydro_calculation.fields.temperature_end'),
            trans('monitoring.hydro_calculation.fields.start_point'),
            trans('monitoring.hydro_calculation.fields.end_point'),
            trans('monitoring.hydro_calculation.fields.pipe_name'),
            trans('monitoring.hydro_calculation.fields.mix_speed_avg'),
            trans('monitoring.hydro_calculation.fields.fluid_speed'),
            trans('monitoring.hydro_calculation.fields.gaz_speed'),
            trans('monitoring.hydro_calculation.fields.flow_type'),
            trans('monitoring.hydro_calculation.fields.press_change'),
            trans('monitoring.hydro_calculation.fields.break_qty'),
            trans('monitoring.hydro_calculation.fields.height_drop'),
        ];

        $data = [
            'results' => $results,
            'columnNames' => $columnNames
        ];

        return view(
            'exports.pipeline_calc_result',
            [
                'data' => $data
            ]
        );
    }
}
