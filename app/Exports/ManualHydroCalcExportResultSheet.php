<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class ManualHydroCalcExportResultSheet implements FromView, ShouldAutoSize, WithTitle
{
    protected $data;

    function __construct($pipes) {
        $this->pipes = $pipes;
    }

    public function title(): string
    {
        return 'Результаты расчета';
    }

    public function view(): View
    {
        $columnNames = [
            '№',
            trans('monitoring.gu.gu'),
            trans('app.date'),
            trans('monitoring.pipe_types.fields.outside_diameter'),
            trans('monitoring.pipe_types.fields.thickness'),
            trans('monitoring.pipe.fields.length'),
            trans('monitoring.units.q_zh') . ', ' . trans('measurements.m3/day'),
            trans('monitoring.gu.fields.bsw') . ', ' . trans('measurements.percent'),
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
            'pipes' => $this->pipes,
            'columnNames' => $columnNames
        ];

        return view('exports.manual_calculate_export_to_excel', [
            'data' => $data
        ]);
    }
}
