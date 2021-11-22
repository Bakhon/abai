<?php

namespace App\Http\Controllers;

use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\GeoParent;
use App\Models\BigData\Dictionaries\GeoType;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\OrgType;
use App\Repositories\WellCardGraphRepository;
use App\Services\BigData\StructureService;
use App\Services\PolygonsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapConstructorController extends Controller
{
    protected PolygonsService $polygonsService;
    protected StructureService $structureService;
    protected WellCardGraphRepository $wellCardGraphRepo;
    protected array $orgs;
    protected array $horizons;

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

    public function getDataFromExcel(Request $request): array {
        $file = $request->file('file');

        return $this->polygonsService->getDataFromExcel($file);
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
        $geo = (int)$request->get('geo');
        $selectedDzo = (int)$request->get('selectedDzo');
        $dzoCode = Org::select('code')->where('id', $selectedDzo)->first()->code;
        $wells = DB::connection('tbd')->table('dict.well')
            ->select('dict.well.id', 'dict.well.uwi', 'geo.spatial_object.coord_point')
            ->join('prod.well_geo', 'dict.well.id', '=', 'prod.well_geo.well')
            ->join('geo.spatial_object', 'dict.well.whc', '=', 'geo.spatial_object.id')
            ->where('prod.well_geo.geo', '=', $geo)
            ->get();

        $coords = [];
        foreach ($wells as $well) {
            if ($well->coord_point) {
                $result[] = [
                    'id' => $well->id,
                    'name' => $well->uwi,
                    'data' => $this->wellCardGraphRepo->wellItems($well->id, 30),
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

}