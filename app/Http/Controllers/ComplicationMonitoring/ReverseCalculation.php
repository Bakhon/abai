<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\ReverseCalculationFilter;
use App\Http\Requests\IndexTableRequest;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReverseCalculationResource;
use Illuminate\Support\Facades\Session;

class ReverseCalculation extends CrudController
{
    protected $modelName = 'reverse_calculation';

    public function index () {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('reverse_calculation.list'),
            ],
            'title' => trans('monitoring.reverse_calculation.table_title'),
            'fields' => [
                'id' => [
                    'title' => '№',
                    'type' => 'numeric',
                ],
                'out_dia' => [
                    'title' => trans('monitoring.pipe_types.fields.outside_diameter'),
                    'type' => 'numeric',

                ],
                'wall_thick' => [
                    'title' => trans('monitoring.pipe_types.fields.thickness'),
                    'type' => 'numeric',
                ],
                'length' => [
                    'title' => trans('monitoring.hydro_calculation.fields.length'),
                    'type' => 'numeric',
                ],
                'qliq' => [
                    'title' => trans('monitoring.units.q_zh').', '.trans('measurements.m3/day'),
                    'type' => 'numeric',
                ],
                'wc' => [
                    'title' => trans('monitoring.gu.fields.bsw').', '.trans('measurements.percent'),
                    'type' => 'numeric',
                ],
                'gazf' => [
                    'title' => trans('monitoring.omgngdu.fields.gas_factor'),
                    'type' => 'numeric',
                ],
                'press_start' => [
                    'title' => trans('monitoring.hydro_calculation.fields.pressure_start'),
                    'type' => 'numeric',
                ],
                'press_end' => [
                    'title' => trans('monitoring.hydro_calculation.fields.pressure_end'),
                    'type' => 'numeric',
                ],
                'temp_start' => [
                    'title' => trans('monitoring.hydro_calculation.fields.temperature_start'),
                    'type' => 'numeric',
                ],
                'temp_end' => [
                    'title' => trans('monitoring.hydro_calculation.fields.temperature_end'),
                    'type' => 'numeric',
                ],
                'start_point' => [
                    'title' => trans('monitoring.hydro_calculation.fields.start_point'),
                    'type' => 'numeric',
                ],
                'end_point' => [
                    'title' => trans('monitoring.hydro_calculation.fields.end_point'),
                    'type' => 'numeric',
                ],
                'name' => [
                    'title' => trans('monitoring.hydro_calculation.fields.pipe_name'),
                    'type' => 'numeric',
                ],
                'mix_speed_avg' => [
                    'title' => trans('monitoring.hydro_calculation.fields.mix_speed_avg'),
                    'type' => 'numeric',
                ],
                'fluid_speed' => [
                    'title' => trans('monitoring.hydro_calculation.fields.fluid_speed'),
                    'type' => 'numeric',
                ],
                'gaz_speed' => [
                    'title' => trans('monitoring.hydro_calculation.fields.gaz_speed'),
                    'type' => 'numeric',
                ],
                'flow_type' => [
                    'title' => trans('monitoring.hydro_calculation.fields.flow_type'),
                    'type' => 'numeric',
                ],
                'press_change' => [
                    'title' => trans('monitoring.hydro_calculation.fields.press_change'),
                    'type' => 'numeric',
                ],
                'break_qty' => [
                    'title' => trans('monitoring.hydro_calculation.fields.break_qty'),
                    'type' => 'numeric',
                ],
                'height_drop' => [
                    'title' => trans('monitoring.hydro_calculation.fields.height_drop'),
                    'type' => 'numeric',
                ],
            ],
        ];

        $params['links']['date'] = true;

        return view('reverse_calc.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = ReverseCalculation::query();

        $reverse_calculations = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(ReverseCalculationResource::collection($reverse_calculations)->toJson()));
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new ReverseCalculationFilter($query, $filter))->filter();
    }
}
