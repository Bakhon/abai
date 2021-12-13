<?php

namespace App\Http\Controllers;

use App\Models\BigData\DailyInjectionOil;
use App\Models\BigData\DailyProdOil;
use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\OrgType;
use App\Repositories\WellCardGraphRepository;
use App\Services\BigData\StructureService;
use App\Services\PolygonsService;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapConstructorController extends Controller
{
    protected $polygonsService;
    protected $structureService;
    protected $wellCardGraphRepo;
    protected $orgs;
    protected $horizons;

    const TYPE_DZO = 'dzo';
    const TYPE_FIELD = 'field';
    const TYPE_HORIZON = 'horizon';
    const CODE_DZO = 'SUBC';

    public function __construct(
        PolygonsService $polygonsService,
        StructureService $structureService,
        WellCardGraphRepository $wellCardGraphRepo
    )
    {
        $this->polygonsService = $polygonsService;
        $this->structureService = $structureService;
        $this->wellCardGraphRepo = $wellCardGraphRepo;

    }

    public function importFile(Request $request): string {
        $file = $request->file('file');
        $numberOfLevels = (int)$request->get('number_of_levels');
        $type = $request->get('type');

        return $this->polygonsService->getPolygons($file, $numberOfLevels, $type);
    }

    public function getGridByBase64(Request $request): array {
        $base64Data = $request->get('base64Data');
        $selectedFilterType = $request->get('selectedFilterType');
        $selectedFilterValue = $request->get('selectedFilterValue');

        return $this->polygonsService->getGridByBase64($base64Data, $selectedFilterType, $selectedFilterValue);
    }

    public function getDataFromExcel(Request $request): array {
        $file = $request->file('file');

        return $this->polygonsService->getDataFromExcel($file);
    }

    public function getInterpolationData(Request $request): array {
        $dataFile = $request->file('dataFile');
        $files = [[
            'name' => 'wells_file',
            'contents' => Utils::tryFopen($dataFile->path(), 'r'),
            'filename' => $dataFile->getClientOriginalName()
        ]];
        $contourFiles = $request->file('contourFiles');
        if ($contourFiles) {
            foreach ($contourFiles as $contourFile) {
                $files[] = [
                    'name' => 'external_contours_files',
                    'contents' => Utils::tryFopen($contourFile->path(), 'r'),
                    'filename' => $contourFile->getClientOriginalName()
                ];
            }
        }
        $params = json_decode($request->get('params'), true);

        return $this->polygonsService->getInterpolationData($files, $params);
    }

    public function getStructure(Request $request): array {
        $type = $request->get('type');
        $id = (int)$request->get('id');
        $result = [];
        switch ($type) {
            case self::TYPE_DZO:
                $orgType = OrgType::where('code', self::CODE_DZO)->first();
                $result = Org::select('id', 'name_ru')
                    ->where('org_type', $orgType->id)
                    ->orderBy('name_ru')
                    ->get()
                    ->toArray();
                break;
            case self::TYPE_FIELD:
                $orgsTree = $this->structureService->getTree(Carbon::now());
                $this->orgs[] = $id;
                foreach ($orgsTree as $org) {
                    if ($org['id'] === $id) {
                        $this->getOrgIdsRecursive($org['children']);
                    }
                }
                $itemElements = array_map( function ($item) {
                        return $item->geo;
                    },
                    DB::connection('tbd')
                    ->table('prod.org_geo as og')
                    ->select('og.geo as geo')
                    ->whereIn('og.org', $this->orgs)
                    ->get()
                    ->toArray()
                );
                $result = Geo::select('id', 'name_ru')
                    ->whereIn('id', $itemElements)
                    ->where('geo_type', 3)
                    ->orderBy('name_ru')
                    ->get()
                    ->toArray();
                break;
            case self::TYPE_HORIZON:
                $this->getHorizonsRecursive($id);
                $result = $this->horizons;
                break;
            default:
                break;
        }

        return $result;
    }

    public function getWells(Request $request): array {
        $result = [];
        $period = null;
        $geo = (int)$request->get('geo');
        $date = $request->get('date');
        $dataType = $request->get('dataType');
        $selectedDzo = (int)$request->get('selectedDzo');
        $dzoCode = Org::select('code')->where('id', $selectedDzo)->first()->code;
        $wells = DB::connection('tbd')->table('dict.well')
            ->select('dict.well.id', 'dict.well.uwi', 'geo.spatial_object.coord_point')
            ->join('prod.well_geo', 'dict.well.id', '=', 'prod.well_geo.well')
            ->join('geo.spatial_object', 'dict.well.whc', '=', 'geo.spatial_object.id')
            ->where('prod.well_geo.geo', '=', $geo)
            ->get();

        $coords = [];
        if ($dataType && $dataType === 'kto') {
            $dateObj = $date ? new \DateTime($date) : new \DateTime();
            $dateObj->modify('first day of this month');
            $period = $dateObj->diff((new \DateTime($date))->modify('last day of this month'))->days + 1;
            $date = (new \DateTime($date))->modify('last day of this month')->format('Y-m-d');
        }
        $wellIds = array_map(function($item) {
            return $item->id;
        }, $wells->toArray());
        $pressureData = $this->getWellsPressure($wellIds, $period, $date);
        $pressureMax = 0;
        foreach ($pressureData as $pressureDataItem) {
            $pressureMax = $pressureDataItem > $pressureMax ? $pressureDataItem : $pressureMax;
        }
        $oilWithWaterData = $this->getOilWithWaterData($wellIds, $period, $date);
        foreach ($wells as $well) {
            if ($well->coord_point) {
                $result[] = [
                    'id' => $well->id,
                    'name' => $well->uwi,
                    'oilWithWaterData' => isset($oilWithWaterData[$well->id]) ? $oilWithWaterData[$well->id] : [],
                    'pressure' => isset($pressureData[$well->id]) ? $pressureData[$well->id] : null,
                    'pressureMax' => $pressureMax,
                ];
                $coords[] = $well->coord_point;
            }
        }

        $coords = array_map(function ($item) {
            return array_map(function ($item) {
                return (float)$item;
            }, explode(',', str_replace(['(', ')'], '', $item)));
        }, $coords);
        $convertedCoords = $this->polygonsService->convertCoords($coords, $dzoCode, 'to_cartesian');
        foreach ($convertedCoords as $convertedCoordsKey => $convertedCoordsItem) {
            $result[$convertedCoordsKey]['coords'] = $convertedCoordsItem;
        }

        return $result;
    }

    private function getOrgIdsRecursive(array $orgs): void {
        foreach ($orgs as $orgsItem) {
            $this->orgs[] = $orgsItem['id'];
            if (isset($orgsItem['children'])) {
                $this->getOrgIdsRecursive($orgsItem['children']);
            }
        }
    }

    private function getHorizonsRecursive(int $id): void {
        $children = DB::connection('tbd')
                ->table('dict.geo')
                ->select('dict.geo.id', 'dict.geo.name_ru', 'dict.geo.geo_type')
                ->leftJoin('dict.geo_parent', 'dict.geo_parent.geo', 'dict.geo.id')
                ->where('dict.geo_parent.parent', $id)
                ->get()
                ->toArray();
        foreach ($children as $child) {
            if ($child->geo_type == 4) {
                $this->horizons[] = $child;
            } else {
                $this->getHorizonsRecursive($child->id);
            }
        }
    }

    private function getWellsPressure(array $wellIds, $period, $date): array {
        $result = [];
        $dateFrom = $period ? (new \DateTime($date))
            ->modify("-" . $period . " days")
            ->modify("+1 day")
            ->format('Y-m-d') : null;
        $dateTo = $date ? (new \DateTime($date))
            ->modify('last day of this month')
            ->modify("+1 day")
            ->format('Y-m-d') : null;
        $query = DailyInjectionOil::whereIn('well', $wellIds);
        if ($dateFrom) {
            $query->where('date','>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('date','<', $dateTo);
        }
        $pressures = $query->select([
            'well',
            'water_vol',
        ])->groupBy(['well', 'water_vol'])->get()->toArray();
        foreach ($pressures as $pressure) {
            $result[$pressure['well']] = isset($result[$pressure['well']]) ?
                $result[$pressure['well']] + $pressure['water_vol'] :
                $pressure['water_vol'];
        }
        return $result;
    }

    private function getOilWithWaterData(array $wellIds, $period, $date): array {
        $result = [];

        $dateFrom = $period ? (new \DateTime($date))
            ->modify("-" . $period . " days")
            ->modify("+1 day")
            ->format('Y-m-d') : null;
        $dateTo = $date ? (new \DateTime($date))
            ->modify('last day of this month')
            ->modify("+1 day")
            ->format('Y-m-d') : null;

        $query = DailyProdOil::select([
            'well as id',
            DB::raw('COUNT(well) as cnt'),
            DB::raw('SUM(liquid) as liquid'),
            DB::raw('AVG(wcut) as wcut'),
            DB::raw('SUM(oil) as oil'),
        ])
            ->whereIn('well', $wellIds)
            ->groupBy('well');
        if ($dateFrom) {
            $query = $query->where('date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query = $query->where('date', '<', $dateTo);
        }

        $wellsData = $query->get();

        foreach($wellsData as $item)
        {
            $result[$item->id] = $item;
        }

        return $result;
    }
}