<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\ReverseCalculationFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\IndexTableRequest;
use App\Http\Resources\ReverseCalculationResource;
use App\Jobs\ReverseCalculateHydroDynamics;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\HydroCalcResult;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\OmgNGDUWell;
use App\Models\ComplicationMonitoring\Zu;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;

class ReverseCalculationController extends CrudController
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
                'oil_pipe_id' => [
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
                'bsw' => [
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

        return view('reverse_calc.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $input = $request->validated();
        $prepairedData = $this->getPreparedAndCalculatedPipes($input);
        $pipes = $prepairedData['pipes'];
        $alerts = $prepairedData['alerts'];

        $pipes = $this->paginate($pipes, 25, (int)$input['page']);
        $list = json_decode(ReverseCalculationResource::collection($pipes)->toJson());

        if (count($alerts)) {
            $list->alerts = $alerts;
        }

        return response()->json($list);
    }

    public function getPreparedAndCalculatedPipes(array $input): array
    {
        $calculatedPipes = null;
        $calculatedPipesIds = [];

        if (isset($input['date'])) {
            $calculatedPipes = $this->getCalculatedData($input['date']);

            if ($calculatedPipes) {
                $calculatedPipesIds = $calculatedPipes->pluck('oil_pipe_id')->toArray();
            }
        }

        $prepairedData = $this->getPrepairedData($input, $calculatedPipesIds);
        $pipes = $prepairedData['pipes'];
        $alerts = $prepairedData['alerts'];

        if ($calculatedPipes) {
            $pipes = $calculatedPipes->merge($pipes);
        }

        return ['pipes' => $pipes, 'alerts' => $alerts];
    }

    public function getCalculatedData(string $date)
    {
        return HydroCalcResult::with('oilPipe.pipeType', 'oilPipe.gu')
            ->where('date', $date)
            ->orderBy('id')
            ->get();
    }

    public function getPrepairedData(array $input = [],  array $calculatedPipesIds): array
    {
        $guNames = [
            'ГУ-107',
            'ГУ-24',
            'ГУ-22'
        ];

        $gu_ids = Gu::whereIn('name', $guNames)->get()->pluck('id');
        $query = OilPipe::query()
            ->with('firstCoords', 'lastCoords', 'pipeType', 'gu');

        $pipes = $this
            ->getFilteredQuery($input, $query)
            ->whereNotNull('start_point')
            ->whereNotNull('end_point')
            ->whereIn('between_points', ['well-zu', 'well_collector-zu', 'zu-gu', 'zu-zu_coll', 'zu_coll-gu'])
            ->whereNotIn('id', $calculatedPipesIds)
            ->whereIn('gu_id', $gu_ids)
            ->orderBy('gu_id')
            ->orderBy('zu_id')
            ->get();

        $alerts = [];

        foreach ($pipes as $key => $pipe) {
            if (!$pipe->lastCoords || !$pipe->firstCoords) {
                unset($pipes[$key]);
                continue;
            }

            if ($pipe->between_points == 'well-zu') {
                $query = OmgNGDUWell::where('well_id', $pipe->well_id);

                if (isset($input['date'])) {
                    $query = $query->where('date', '<=', $input['date']);
                }

                $pipe->omgngdu = $query->orderBy('date', 'desc')->first();

                if (!$pipe->omgngdu) {
                    $zu = Zu::find($pipe->zu_id);
                    $message = $pipe->start_point . ' -> '.$zu->name.' '.trans('monitoring.hydro_calculation.message.no-omgdu-data');

                    if (isset($input['date'])) {
                        $message .= ' на ' . $input['date'].' или раньше';
                    }

                    $alerts[] = [
                        'message' => $message . ' !',
                        'variant' => 'danger'
                    ];
                    continue;
                }
            }

            if ($pipe->between_points == 'zu-gu' || $pipe->between_points == 'zu_coll-gu') {
                $query = OmgNGDU::where('gu_id', $pipe->gu_id);

                if (isset($input['date'])) {
                    $query = $query->where('date', $input['date']);
                }

                $pipe->omgngdu_gu = $query->orderBy('date', 'desc')->first();

                if (!$pipe->omgngdu_gu) {
                    $gu = Gu::find($pipe->gu_id);
                    $message =  trans('monitoring.hydro_calculation.message.no-pressure-omgdu-data').' '.$gu->name;

                    if (isset($input['date'])) {
                        $message .= ' на ' . $input['date'];
                    }

                    $alerts[] = [
                        'message' => $message . ' !',
                        'variant' => 'danger'
                    ];
                }
            }
        }

        return ['pipes' => $pipes, 'alerts' => $alerts];
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new ReverseCalculationFilter($query, $filter))->filter();
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

    /**
     * Generates the pagination of items in an array or collection.
     *
     * @param array|Collection $items
     */
    protected function paginate($items, int $perPage = 15, int $page = null, array $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
