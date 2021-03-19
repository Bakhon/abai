<?php

namespace App\Http\Controllers;

use App\Models\ComplicationMonitoring\PipeType;
use App\Models\Pipes\MapPipe;
use App\Models\Pipes\PipeCoord;
use App\Models\Refs\Ngdu;
use Illuminate\Http\Request;
use App\Services\MapService;
use App\Models\Refs\Gu;
use App\Models\Refs\Zu;
use App\Models\Refs\Cdng;
use App\Models\Refs\Well;
use App\Services\DruidService;
use App\Http\Requests\POSTCaller;

use App\Http\Controllers\ComplicationMonitoring\OmgNGDUController;
use App\Http\Controllers\ComplicationMonitoring\WaterMeasurementController;
use App\Http\Controllers\DruidController;

class MapsController extends Controller
{
    protected $mapService;

    public function __construct(MapService $mapService)
    {
        $this->middleware('can:monitoring view pipes map');

        $this->mapService = $mapService;
    }

    public function guMap()
    {
        return view('maps.gu_map');
    }

    public function getMapCenter()
    {
        $coordinates = [];
        $this->getPipesWithCoords($coordinates);

        foreach ($coordinates as $guId => $coords) {
            $guCenters[$guId] = !empty($coords) ? $this->mapService->calculateCenterOfCoordinates($coords) : null;
        }

        $center = $this->mapService->calculateCenterOfCoordinates($guCenters);

        return $center;
    }

    public function mapData(Request $request, DruidService $druidService): array
    {
        $pipes = MapPipe::with('coords', 'pipeType')->get();

        $center = [52.854602599069, 43.426262258809];

        $wellPoints = Well::query()
            ->whereHas('zu.gu')
            ->whereHas('ngdu')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        $zuPoints = Zu::query()
            ->whereHas('gu')
            ->whereHas('ngdu')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get();

        $guPoints = Gu::with(
            [
                'omgngdu' => function ($query) {
                    $query->select(
                        'id',
                        'date',
                        'gu_id',
                        'daily_fluid_production',
                        'daily_oil_production',
                        'bsw',
                        'pump_discharge_pressure',
                        'heater_output_pressure',
                        'editable'
                    )->orderBy('date', 'desc')->first();
                }
            ]
        )
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->orderByRaw('lpad(name, 10, 0) asc')
            ->get();

        $pipeTypes = PipeType::all();
        $ngdus = Ngdu::all();
        $cdngs = Cdng::all();

        return [
            'pipes' => $pipes,
            'ngdus' => $ngdus,
            'cdngs' => $cdngs,
            'wellPoints' => $wellPoints,
            'zuPoints' => $zuPoints,
            'guPoints' => $guPoints,
            'center' => $center,
            'pipeTypes' => $pipeTypes,
        ];
    }

    private function getPipesWithCoords(array &$coordinates): \Illuminate\Database\Eloquent\Collection
    {
        $map_pipes = MapPipe::with('coords', 'pipeType')->get();
        $coords = [];

        $map_pipes->map(
            function ($map_pipe) use (&$coordinates, &$coords) {
                $map_pipe->coords->map(
                    function ($coord) use (&$coordinates, &$map_pipe, &$coords) {
                        $coords[] = [$coord->lon, $coord->lat];

                        return $coord;
                    }
                );

                if (!isset($coordinates[$map_pipe->gu_id])) {
                    $coordinates[$map_pipe->gu_id] = [];
                }

                $coordinates[$map_pipe->gu_id] = array_merge(
                    $coordinates[$map_pipe->gu_id],
                    $coords
                );

                return $map_pipe;
            }
        );

        return $map_pipes;
    }

    private function getWellOilInfo(DruidService $druidService): array
    {
        $wellOil = $druidService->getWellOil();
        foreach ($wellOil as $row) {
            $result[$row['uwi']] = $row['oil'];
        }
        return $result;
    }

    public function storeGu(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $gu_input = $request->input('gu');
        $gu = new Gu;

        $gu->fill($gu_input);
        $gu->save();

        $gu = Gu::with(
            [
                'omgngdu' => function ($query) {
                    $query->select(
                        'id',
                        'date',
                        'gu_id',
                        'daily_fluid_production',
                        'daily_oil_production',
                        'bsw',
                        'pump_discharge_pressure',
                        'heater_output_pressure',
                        'editable'
                    )->orderBy('date', 'desc')->first();
                }
            ]
        )
            ->find($gu->id);

        return response()->json(
            [
                'gu' => $gu,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function storeZu(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $zu_input = $request->input('zu');
        $zu = new Zu;

        $zu->fill($zu_input);
        $zu->save();

        return response()->json(
            [
                'zu' => $zu,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function storeWell(Request $request, DruidService $druidService): \Symfony\Component\HttpFoundation\Response
    {
        $well_input = $request->input('well');
        $well = new Well;

        $well->fill($well_input);
        $well->save();

        return response()->json(
            [
                'well' => $well,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function storePipe(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $pipe_input = $request->input('pipe');
        $pipe = new MapPipe;
        $pipe->fill($pipe_input);
        $pipe->save();

        foreach ($pipe_input['coords'] as $coord) {
            $pipe_coord = new PipeCoord;
            $pipe_coord->fill($coord);
            $pipe_coord->map_pipe_id = $pipe->id;
            $pipe_coord->save();
        }

        $pipe = MapPipe::with('coords', 'pipeType')->find($pipe->id);

        return response()->json(
            [
                'pipe' => $pipe,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function updateGu(Request $request, Gu $gu): \Symfony\Component\HttpFoundation\Response
    {
        $gu_input = $request->input('gu');

        $gu->fill($gu_input);
        $gu->save();

        $gu = Gu::with(
            [
                'omgngdu' => function ($query) {
                    $query->select(
                        'id',
                        'date',
                        'gu_id',
                        'daily_fluid_production',
                        'daily_oil_production',
                        'bsw',
                        'pump_discharge_pressure',
                        'heater_output_pressure',
                        'editable'
                    )->orderBy('date', 'desc')->first();
                }
            ]
        )
            ->find($gu->id);

        return response()->json(
            [
                'gu' => $gu,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function updateZu(Request $request, Zu $zu): \Symfony\Component\HttpFoundation\Response
    {
        $zu_input = $request->input('zu');

        $zu->fill($zu_input);
        $zu->save();

        return response()->json(
            [
                'zu' => $zu,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function updateWell(Request $request, Well $well): \Symfony\Component\HttpFoundation\Response
    {
        $well_input = $request->input('well');

        $well->fill($well_input);
        $well->save();

        return response()->json(
            [
                'well' => $well,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function updatePipe(Request $request, MapPipe $pipe): \Symfony\Component\HttpFoundation\Response
    {
        $pipe_input = $request->input('pipe');
        $pipe->fill($pipe_input);
        $pipe->save();

        foreach ($pipe_input['coords'] as $coord) {
            $pipe_coord = PipeCoord::find($coord['id']);
            $pipe_coord->fill($coord);
            $pipe_coord->save();
        }

        $pipe = MapPipe::with('coords', 'pipeType')->find($pipe->id);

        return response()->json(
            [
                'pipe' => $pipe,
                'status' => config('response.status.success'),
            ]
        );
    }

    public function deleteGu(Gu $gu): \Symfony\Component\HttpFoundation\Response
    {
        $gu->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    public function deleteZu(Zu $zu): \Symfony\Component\HttpFoundation\Response
    {
        $zu->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    public function deleteWell(Well $well): \Symfony\Component\HttpFoundation\Response
    {
        $well->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    public function deletePipe(MapPipe $pipe): \Symfony\Component\HttpFoundation\Response
    {
        PipeCoord::where('map_pipe_id', $pipe->id)->delete();
        $pipe->delete();

        return response()->json(
            [
                'status' => config('response.status.success'),
            ]
        );
    }

    public function test()
    {
        $date = "2020-12-05";
        $guId = 38;

        $post = new POSTCaller(
            WaterMeasurementController::class,
            'getGuData',
            Request::class,
            [
                'gu_id' => $guId
            ]
        );

        $guData = $post->call()->getData();

        dump($guData);

        $post = new POSTCaller(
            OmgNGDUController::class,
            'getGuDataByDay',
            Request::class,
            [
                'dt' => $date,
                'gu_id' => $guId
            ]
        );
        $guDataByDay = $post->call()->getData();


        dump($guDataByDay);

        $data = [
            "WC" => $guDataByDay->ngdu->bsw,
            "GOR1" => $guData->constantsValues[0]->value,
            "sigma" => $guData->constantsValues[1]->value,
            "do" => $guData->pipe->outside_diameter,
            "roughness" => $guData->pipe->roughness,
            "l" => $guData->pipe->length,
            "thickness" => $guData->pipe->thickness,
            "P" => $guDataByDay->ngdu->pump_discharge_pressure,
            "t_heater" => $guDataByDay->ngdu->heater_output_pressure,
            "conH2S" => $guDataByDay->wmLastH2S->hydrogen_sulfide,
            "conCO2" => $guDataByDay->wmLastCO2->carbon_dioxide,
            "q_l" => $guDataByDay->ngdu->daily_fluid_production,
            "H2O" => $guDataByDay->ngdu->bsw,
            "HCO3" => $guDataByDay->wmLastHCO3->hydrocarbonate_ion,
            "Cl" => $guDataByDay->wmLastCl->chlorum_ion,
            "SO4" => $guDataByDay->wmLastSO4->sulphate_ion,
            "q_g_sib" => $guDataByDay->ngdu->daily_gas_production_in_sib,
            "P_bufer" => $guDataByDay->ngdu->surge_tank_pressure,
            "rhol" => $guDataByDay->wmLastH2S->density,
            "rho_o" => $guDataByDay->oilGas->water_density_at_20,
            "rhog" => $guDataByDay->oilGas->gas_density_at_20,
            "mul" => $guDataByDay->oilGas->oil_viscosity_at_20,
            "mug" => $guDataByDay->oilGas->gas_viscosity_at_20,
            "q_o" => $guDataByDay->ngdu->daily_oil_production
        ];

        dump($data);

        $post = new POSTCaller(
            DruidController::class,
            'corrosion',
            Request::class,
            $data
        );
        $corrosion = $post->call()->getData();

        dd($corrosion->corrosion_rate_mm_per_y_point_A);
    }

}
