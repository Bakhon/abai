<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\ManualReverseCalculationFilter;
use App\Filters\ReverseCalculationFilter;
use App\Http\Requests\IndexTableRequest;
use App\Http\Controllers\CrudController;
use App\Http\Resources\ReverseCalculationResource;
use App\Jobs\ReverseCalculateHydroDynamics;
use App\Models\ComplicationMonitoring\ManualOilPipe;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\OmgNGDUWell;
use App\Models\ComplicationMonitoring\ReverseCalculation;
use App\Models\ComplicationMonitoring\TrunklinePoint;
use Illuminate\Support\Facades\Session;

class ManualReverseCalc extends CrudController
{
    protected $modelName = 'manual_reverse_calculation';

    public function index () {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('manual_reverse_calculation.list'),
            ],
            'title' => trans('monitoring.manual_reverse_calculation.table_title'),
            'fields' => [
                'id' => [
                    'title' => '№',
                    'type' => 'numeric',
                ],
                'date' => [
                    'title' => trans('app.date'),
                    'type' => 'date',
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
                'daily_fluid_production' => [
                    'title' => trans('monitoring.units.q_zh').', '.trans('measurements.m3/day'),
                    'type' => 'numeric',
                ],
                'wc' => [
                    'title' => trans('monitoring.gu.fields.bsw').', '.trans('measurements.percent'),
                    'type' => 'numeric',
                ],
                'gas_factor' => [
                    'title' => trans('monitoring.omgngdu.fields.gas_factor'),
                    'type' => 'numeric',
                ],
                'pressure_start' => [
                    'title' => trans('monitoring.hydro_calculation.fields.pressure_start'),
                    'type' => 'numeric',
                ],
                'pressure_end' => [
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

        $params['links']['calc']['link'] = route($this->modelName.'.calculate');
        $params['links']['date'] = true;

        return view('complicationMonitoring.manual_reverse_calc.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $query = ReverseCalculation::with('oilPipe.pipeType');

        $reverse_calculations = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(ReverseCalculationResource::collection($reverse_calculations)->toJson()));
    }

    public function getPrepairedData(array $input = []): array
    {
        $query = ManualOilPipe::query()
            ->with('firstCoords', 'lastCoords');

        $pipes = $this
            ->getFilteredQuery($input, $query)
            ->whereNotNull('start_point')
            ->whereNotNull('end_point')
            ->get();

        $pipes->load('pipeType');

        foreach ($pipes as $key => $pipe) {
            if ($pipe->between_points == 'well-zu') {
//                $pipe->load('well');

                $query = OmgNGDUWell::where('well_id', $pipe->well_id);

                if (isset($input['date'])) {
                    $query = $query->where('date', $input['date']);
                }

                $pipe->omgngdu = $query->orderBy('date', 'desc')->first();

                if (!$pipe->omgngdu) {
                    $message = $pipe->start_point . ' ' . trans('monitoring.hydro_calculation.message.no-omgdu-data');

                    if (isset($input['date'])) {
                        $message .= ' на ' . $input['date'];
                    }

                    $alerts[] = [
                        'message' => $message . ' !',
                        'variant' => 'danger'
                    ];
                    continue;
                }
            }
        }

        $pipes = $this->paginate($pipes, 25, (int)$input['page']);
        return ['points' => $pipes, 'alerts' => $alerts];
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new ManualReverseCalculationFilter($query, $filter))->filter();
    }

    public function calculate(IndexTableRequest $request)
    {
        $job = new ReverseCalculateHydroDynamics($request->validated());
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
    }
}
