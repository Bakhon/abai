<?php


namespace App\Services\BigData;

use App\Exceptions\DictionaryNotFound;
use App\Models\BigData\Dictionaries\Block;
use App\Models\BigData\Dictionaries\Brigade;
use App\Models\BigData\Dictionaries\Brigadier;
use App\Models\BigData\Dictionaries\CasingType;
use App\Models\BigData\Dictionaries\ChemicalReagentType;
use App\Models\BigData\Dictionaries\Company;
use App\Models\BigData\Dictionaries\CoordSystem;
use App\Models\BigData\Dictionaries\Device;
use App\Models\BigData\Dictionaries\DocumentType;
use App\Models\BigData\Dictionaries\DrillChisel;
use App\Models\BigData\Dictionaries\DrillColumnType;
use App\Models\BigData\Dictionaries\Equip;
use App\Models\BigData\Dictionaries\EquipFailReasonType;
use App\Models\BigData\Dictionaries\EquipType;
use App\Models\BigData\Dictionaries\ExplTypePlanGDIS;
use App\Models\BigData\Dictionaries\FileOrigin;
use App\Models\BigData\Dictionaries\FileStatus;
use App\Models\BigData\Dictionaries\FileType;
use App\Models\BigData\Dictionaries\GdisConclusion;
use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\GeoIdentifier;
use App\Models\BigData\Dictionaries\GeoRockType;
use App\Models\BigData\Dictionaries\GisKind;
use App\Models\BigData\Dictionaries\GisMethod;
use App\Models\BigData\Dictionaries\GisMethodType;
use App\Models\BigData\Dictionaries\GisType;
use App\Models\BigData\Dictionaries\GtmType;
use App\Models\BigData\Dictionaries\InjAgentType;
use App\Models\BigData\Dictionaries\IsoMaterialType;
use App\Models\BigData\Dictionaries\LabResearchType;
use App\Models\BigData\Dictionaries\MachineType;
use App\Models\BigData\Dictionaries\Mark;
use App\Models\BigData\Dictionaries\NoBtmReason;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\PackerType;
use App\Models\BigData\Dictionaries\PatronType;
use App\Models\BigData\Dictionaries\PerforatorType;
use App\Models\BigData\Dictionaries\PerfType;
use App\Models\BigData\Dictionaries\PlanGISType;
use App\Models\BigData\Dictionaries\ProcedTypePlanGDIS;
use App\Models\BigData\Dictionaries\PumpType;
use App\Models\BigData\Dictionaries\ReasonEquipFail;
use App\Models\BigData\Dictionaries\RecordingMethod;
use App\Models\BigData\Dictionaries\RecordingState;
use App\Models\BigData\Dictionaries\RepairWorkType;
use App\Models\BigData\Dictionaries\ResearchMethod;
use App\Models\BigData\Dictionaries\ResearchTarget;
use App\Models\BigData\Dictionaries\SaturationType;
use App\Models\BigData\Dictionaries\StemType;
use App\Models\BigData\Dictionaries\Tag;
use App\Models\BigData\Dictionaries\Tech;
use App\Models\BigData\Dictionaries\TechConditionOfWells;
use App\Models\BigData\Dictionaries\TechStateCasing;
use App\Models\BigData\Dictionaries\TreatType;
use App\Models\BigData\Dictionaries\TubeNom;
use App\Models\BigData\Dictionaries\Well;
use App\Models\BigData\Dictionaries\WellActivity;
use App\Models\BigData\Dictionaries\WellCategory;
use App\Models\BigData\Dictionaries\WellExplType;
use App\Models\BigData\Dictionaries\WellPrsRepairType;
use App\Models\BigData\Dictionaries\WellStatus;
use App\Models\BigData\Dictionaries\WellType;
use App\Models\BigData\Dictionaries\WorkStatus;
use App\Models\BigData\Dictionaries\Zone;
use App\Services\BigData\DictionaryServices\UndergroundEquipElement;
use App\Services\BigData\DictionaryServices\UndergroundEquipType;
use Carbon\Carbon;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DictionaryService
{
    const DICTIONARIES = [
        'well_categories' => [
            'class' => WellCategory::class,
            'name_field' => 'name_ru'
        ],
        'well_types' => [
            'class' => WellType::class,
            'name_field' => 'name_ru'
        ],
        'companies' => [
            'class' => Company::class,
            'name_field' => 'name_ru'
        ],
        'equips' => [
            'class' => Equip::class,
            'name_field' => 'name_ru'
        ],
        'equip_type' => [
            'class' => EquipType::class,
            'name_field' => 'name_ru'
        ],
        'casings' => [
            'class' => CasingType::class,
            'name_field' => 'CONCAT(\'Наружный диаметр, (мм): \', od, \', Внутренний диаметр, (мм):\', vd, \', Класс прочности / Марка стали:\' , sg, \', Погонный вес, (кг/м): \', wpm, \', Проходной диаметр, (мм): \', td, \', Предел текучести, (т): \', ys, \', Номинальный вес, (кг/м): \', nw, \', Номинальный диаметр, дюйм: \', nd)'
        ],
        'repair_work_types' => [
            'class' => RepairWorkType::class,
            'name_field' => 'name_ru'
        ],
        'gtm_types' => [
            'class' => GtmType::class,
            'name_field' => 'name_ru'
        ],
        'brigades' => [
            'class' => Brigade::class,
            'name_field' => 'name_ru',
            'additional_fields' => ['org']
        ],
        'brigadiers' => [
            'class' => Brigadier::class,
            'name_field' => 'name_ru'
        ],
        'no_btm_reasons' => [
            'class' => NoBtmReason::class,
            'name_field' => 'name_ru'
        ],
        'well_statuses' => [
            'class' => WellStatus::class,
            'name_field' => 'name_ru'
        ],
        'fail_reason_types' => [
            'class' => EquipFailReasonType::class,
            'name_field' => 'equil_fail_reason_type'
        ],
        'wells_tech_conditions' => [
            'class' => TechConditionOfWells::class,
            'name_field' => 'name_ru'
        ],
        'pump_types' => [
            'class' => PumpType::class,
            'name_field' => 'name_ru'
        ],
        'drill_chisels' => [
            'class' => DrillChisel::class,
            'name_field' => 'name_ru'
        ],
        'drill_column_types' => [
            'class' => DrillColumnType::class,
            'name_field' => 'name_ru'
        ],
        'zone' => [
            'class' => Zone::class,
            'name_field' => 'name_ru'
        ],
        'inj_agent_types' => [
            'class' => InjAgentType::class,
            'name_field' => 'name_ru'
        ],
        'well_activity' => [
            'class' => WellActivity::class,
            'name_field' => 'name_ru'
        ],
        'tube_nom' => [
            'class' => TubeNom::class,
            'name_field' => 'model'
        ],
        'blocks' => [
            'class' => Block::class,
            'name_field' => 'name_ru'
        ],
        'device' => [
            'class' => Device::class,
            'name_field' => 'name_ru'
        ],
        'geo_identifier' => [
            'class' => GeoIdentifier::class,
            'name_field' => 'name_ru'
        ],
        'coord_systems' => [
            'class' => CoordSystem::class,
            'name_field' => 'name_ru'
        ],
        'well_expl_types' => [
            'class' => WellExplType::class,
            'name_field' => 'name_ru'
        ],
        'perf_types' => [
            'class' => PerfType::class,
            'name_field' => 'name_ru'
        ],
        'perforator_types' => [
            'class' => PerforatorType::class,
            'name_field' => 'name_ru'
        ],
        'patron_types' => [
            'class' => PatronType::class,
            'name_field' => 'name_ru'
        ],
        'packer_types' => [
            'class' => PackerType::class,
            'name_field' => 'name_ru'
        ],
        'iso_material_types' => [
            'class' => IsoMaterialType::class,
            'name_field' => 'name_ru'
        ],
        'wells' => [
            'class' => Well::class,
            'name_field' => 'uwi'
        ],
        'gis_method_types' => [
            'class' => GisMethodType::class,
            'name_field' => 'name_ru'
        ],
        'saturation_types' => [
            'class' => SaturationType::class,
            'name_field' => 'name_ru'
        ],
        'geo_rock_types' => [
            'class' => GeoRockType::class,
            'name_field' => 'name_ru'
        ],
        'geo_type' => [
            'class' => Geo::class,
            'name_field' => 'name_ru'
        ],
        'gis_kinds' => [
            'class' => GisKind::class,
            'name_field' => 'name_ru'
        ],
        'gis_methods' => [
            'class' => GisMethod::class,
            'name_field' => 'name_ru'
        ],
        'document_types' => [
            'class' => DocumentType::class,
            'name_field' => 'name_ru'
        ],
        'tag' => [
            'class' => Tag::class,
            'name_field' => 'name_ru'
        ],
        'lab_research_type' => [
            'class' => LabResearchType::class,
            'name_field' => 'name_ru'
        ],
        'treat_type' => [
            'class' => TreatType::class,
            'name_field' => 'name_ru'
        ],
        'research_methods' => [
            'class' => ResearchMethod::class,
            'name_field' => 'name_ru'
        ],
        'research_target' => [
            'class' => ResearchTarget::class,
            'name_field' => 'name_ru'
        ],
        'gdis_conclusion' => [
            'class' => GdisConclusion::class,
            'name_field' => 'name_ru'
        ],
        'marks' => [
            'class' => Mark::class,
            'name_field' => 'name_ru'
        ],
        'reason_equip_fail' => [
            'class' => ReasonEquipFail::class,
            'name_field' => 'name_ru'
        ],
        'chemical_reagent_types' => [
            'class' => ChemicalReagentType::class,
            'name_field' => 'name_ru'
        ],
        'well_prs_repair_types' => [
            'class' => WellPrsRepairType::class,
            'name_field' => 'name_ru'
        ],
        'tech_state_casings' => [
            'class' => TechStateCasing::class,
            'name_field' => 'name_ru'
        ],
        'machine_types' => [
            'class' => MachineType::class,
            'name_field' => 'name_ru'
        ],        
        'plan_gis_type' => [
            'class' => PlanGISType::class,
            'name_field' => 'name'
        ],
        'proced_type_plan_gdis' => [
            'class' => ProcedTypePlanGDIS::class,
            'name_field' => 'name'
        ],
        'file_origin' => [
            'class' => FileOrigin::class,
            'name_field' => 'name_ru'
        ],
        'stem_type' => [
            'class' => StemType::class,
            'name_field' => 'name_ru'
        ],
        'recording_method' => [
            'class' => RecordingMethod::class,
            'name_field' => 'name_ru'
        ],
        'file_type' => [
            'class' => FileType::class,
            'name_field' => 'name_ru'
        ],
        'file_status' => [
            'class' => FileStatus::class,
            'name_field' => 'name_ru'
        ],
        'recording_state' => [
            'class' => RecordingState::class,
            'name_field' => 'name_ru'
        ],
        'work_status' => [
            'class' => WorkStatus::class,
            'name_field' => 'name_ru'
        ]

    ];

    const TREE_DICTIONARIES = [
        'orgs' => [
            'class' => Org::class,
            'name_field' => 'name_ru'
        ],
        'expl_type_plan_gdis' => [
            'class' => ExplTypePlanGDIS::class,
            'name_field' => 'name',
            'parent_field' => 'parent_id'
        ]
    ];

    const CACHE_TTL = 60;

    protected $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function getWithPermissions(string $dict)
    {
        $dictionary = $this->get($dict);
        if ($dict === 'orgs') {
            return $this->getOrgDictionaryWithPermissions($dictionary);
        }
        return $dictionary;
    }

    private function getOrgDictionaryWithPermissions($dictionary)
    {
        $userSelectedTreeItems = collect(auth()->user()->org_structure)
            ->filter(function ($item) {
                list($type, $id) = explode(':', $item);
                return $type === 'org';
            })
            ->map(function ($item) {
                list($type, $id) = explode(':', $item);
                return $id;
            })
            ->toArray();
        $tree = $this->fillTree($dictionary, [], $userSelectedTreeItems);
        return $tree;
    }

    public function fillTree($branch, $tree, $userSelectedTreeItems): array
    {
        foreach ($branch as $item) {
            if (in_array($item['id'], $userSelectedTreeItems)) {
                $tree[] = $item;
                continue;
            }
            if (!empty($item['children'])) {
                $tree = $this->fillTree($item['children'], $tree, $userSelectedTreeItems);
            }
        }
        return $tree;
    }

    public function get(string $dict)
    {
        $cacheKey = 'bd_dict_' . $dict;

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        if (key_exists($dict, self::DICTIONARIES)) {
            $dict = $this->getPlainDict($dict); 
        } elseif (key_exists($dict, self::TREE_DICTIONARIES)) {
            $dict = $this->getTreeDict($dict);
        } else {
            switch ($dict) {
                case 'geos':
                    $dict = $this->getGeoDict();
                    break;
                case 'equip_type_casc':
                    $dict = $this->getEquipTypeCascDict();
                    break;
                case 'geo_type_hrz':
                    $dict = $this->getGeoDictByType('HRZ');
                    break;
                case 'geo_type_field':
                    $dict = $this->getGeoDictByType('FLD');
                    break;
                case 'reason_ref':
                    $dict = $this->getReasonTypeDict("REF");
                    break;
                case 'reason_rst':
                    $dict = $this->getReasonTypeDict("RST");
                    break;
                case 'reason_type_rtr':
                    $dict = $this->getReasonTypeDict("RTR");
                    break;
                case 'reason_rls':
                    $dict = $this->getReasonTypeDict("RLS");
                    break;
                case 'reason_rrd':
                    $dict = $this->getReasonTypeDict("RRD");
                    break;
                case 'las_mnemonics':
                    $dict = $this->getLasMnemonics();
                    break;
                case 'repair_type_prs':
                    $dict = $this->getRepairTypeDict("WLO"); 
                    break;
                case 'repair_type_krs':
                    $dict = $this->getRepairTypeDict("CWO");
                    break;           
                case 'well_tech_state_type':
                    $dict = $this->getWellTechStateDict();
                    break;
                case 'well_statuses_drill':
                    $dict = $this->getWellStatusesForDrill();
                    break;
                case 'techs':
                    $dict = $this->getWellTechsDict();
                    break;
                case 'underground_equip_type':
                    $dict = UndergroundEquipType::getDict();
                    break;
                case 'underground_equip_element':
                    $dict = UndergroundEquipElement::getDict();
                    break;
                case 'res_type_dict':
                    $dict = $this->getResTypeDict();
                    break;
                case 'res_method_dict':
                    $dict = $this->getResMethodDict();
                    break;
                case 'gis_method_types_gis_type':
                    $dict = $this->getGisMethodTypesForGisTypeForm();
                    break;
                case 'gis_kinds_gis_type':
                    $dict = $this->getGisKindsForGisTypeForm();
                    break;
                case 'repair_type_krs_ktm':
                    $dict = $this->getRepairTypeDictKrsPrs("CWO");
                    break;
                case 'repair_type_prs_ktm':
                    $dict = $this->getRepairTypeDictKrsPrs("WLO");
                    break;
                default:
                    throw new DictionaryNotFound();
            }
        }

        $this->cache->set($cacheKey, $dict, Carbon::now()->addMinutes(self::CACHE_TTL));
        return $dict;
    }

    public function getFlatten(array $dict)
    {
        $result = [];
        foreach ($dict as $dictItem) {
            if (isset($dictItem['children'])) {
                $result = array_merge($result, $this->getFlatten($dictItem['children']));
                unset($dictItem['children']);
            }
            $result[] = $dictItem;
        }
        return $result;
    }

    public function getDictValueById(string $dict, string $type, int $id): ?string
    {
        $dict = $this->get($dict);
        if ($type === 'dict_tree') {
            $dict = $this->getFlatten($dict);
            foreach ($dict as $item) {
                if ($item['id'] === $id) {
                    return $item['label'];
                }
            }
            return null;
        }

        foreach ($dict as $item) {
            if ($item['id'] === $id) {
                return $item['name'];
            }
        }

        return null;
    }

    public function getFullPath(string $dict, int $id): ?string
    {
        $dict = collect($this->getFlatten($this->get($dict)));
        $value = $dict->where('id', $id)->first();
        if (empty($value)) {
            return '';
        }

        $path = [$value['label']];
        while (isset($value['parent'])) {
            $value = $dict->where('id', $value['parent'])->first();
            if ($value) {
                $path[] = $value['label'];
            }
        }
        return implode(' / ', array_reverse($path));
    }

    private function getPlainDict(string $dict): array
    {
        $dictClass = self::DICTIONARIES[$dict]['class'];
        $nameField = self::DICTIONARIES[$dict]['name_field'] ?? 'name';

        $selectFields = ['id'];
        if (Schema::connection('tbd')->hasColumn((new $dictClass)->getTable(), 'code')) {
            $selectFields[] = 'code';
        }
        if (!empty(self::DICTIONARIES[$dict]['additional_fields'])) {
            $selectFields = array_merge($selectFields, self::DICTIONARIES[$dict]['additional_fields']);
        }

        $query = $dictClass::query()
            ->select($selectFields)
            ->selectRaw("$nameField as name")
            ->orderBy('name', 'asc');

        $result = $query->get()->toArray();

        return $result;
    }

    private function getTreeDict(string $dict): array
    {
        $dictClass = self::TREE_DICTIONARIES[$dict]['class'];
        $nameField = self::TREE_DICTIONARIES[$dict]['name_field'] ?? 'name';
        $parentField = self::TREE_DICTIONARIES[$dict]['parent_field'] ?? 'parent';

        $items = $dictClass::query()
            ->select('id', "$parentField as parent")
            ->selectRaw("$nameField as label")
            ->orderBy('parent', 'asc')
            ->orderBy($nameField, 'asc')
            ->get()
            ->toArray();
        return $this->generateTree($items);
    }

    private function generateTree($items): array
    {
        $new = [];
        foreach ($items as $item) {
            $new[$item['parent']][] = $item;
        }
        return $this->createTree($new, $new[null]);
    }

    private function createTree(&$list, $parent)
    {
        $tree = array();
        foreach ($parent as $k => $l) {
            if (isset($list[$l['id']])) {
                $l['children'] = $this->createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }

    private function getGeoDict(): array
    {
        $items = DB::connection('tbd')
            ->table('dict.geo as g')
            ->select('g.id', 'g.name_ru as label', 'gp.parent as parent', 'gt.code as type')
            ->distinct()
            ->orderBy('parent')
            ->orderBy('label')
            ->leftJoin(
                'dict.geo_parent as gp',
                function ($join) {
                    $join->on('gp.geo', '=', 'g.id');
                    $join->on('gp.dbeg', '<=', DB::raw("NOW()"));
                    $join->on('gp.dend', '>=', DB::raw("NOW()"));
                }
            )
            ->leftJoin('dict.geo_type as gt', 'g.geo_type', 'gt.id')
            ->get()
            ->map(
                function ($item) {
                    return (array)$item;
                }
            )
            ->toArray();

        $tree = [];
        $items = $this->generateTree($items);
        $geoPermissionsIds = $this->getUserGeoPermissionIds();
        $this->filterTree($items, $tree, $geoPermissionsIds);
        return $tree;
    }

    public function getUserGeoPermissionIds() {
        $orgIds = $this->getUserOrgPermissionIds();
        $result = DB::connection('tbd')
            ->table('prod.org_geo as og')
            ->select('og.geo as geo')
            ->whereIn('og.org', $orgIds)
            ->get()
            ->toArray();

        $result = array_unique(array_map(function ($item) {
            return (int)$item->geo;
        }, $result));
        return $result;
    }

    private function getWellTechsDict(): array
    {
        $dictClass = Tech::class;

        $items = $dictClass::query()
            ->select('id', "parent as parent")
            ->selectRaw("name_ru as label")
            ->orderBy('parent', 'asc')
            ->orderBy('name_ru', 'asc')
            ->get()
            ->toArray();
        
        $tree = [];
        $items = $this->generateTree($items);
        $techPermissionsIds = $this->getUserTechPermissionIds();
        $this->filterTree($items, $tree, $techPermissionsIds);
        return $tree;
    }
    
    public function getUserTechPermissionIds() {
        $orgIds = $this->getUserOrgPermissionIds();
        $result = [];
        foreach($orgIds as $id) {
            $itemElements = DB::connection('tbd')
                ->table('prod.org_tech_link as otl')
                ->select('otl.tech as tech')
                ->where('otl.org', $id)
                ->get()
                ->toArray();
            $result = array_merge($result, $itemElements);
        }
        $result = array_unique(array_map(function ($item) {
            return (int)$item->tech;
        }, $result));
        return $result;
    }

    public function getUserOrgPermissionIds()
    {
        $orgIds = array_filter(auth()->user()->org_structure, function ($item) {
            return substr($item, 0, strpos($item, ":")) == 'org';
        });
        $orgIds = array_map(function ($item) {
            return (int)substr($item, strpos($item, ":") + 1);
        }, $orgIds);

        $parentOrganizations = Org::whereIn('id', $orgIds)->get();
        $allOrganizations = Org::select('id', 'parent')->get();

        $orgIds = $this->getOrgWithChildren($parentOrganizations, $allOrganizations);
        return $orgIds;
    }

    private function getOrgWithChildren($parentOrganizations, $allOrganizations)
    {
        $result = [];
        foreach ($parentOrganizations as $organization) {
            $result[] = $organization->id;
            $children = $allOrganizations->where('parent', $organization->id);

            $result = array_merge($result, $this->getOrgWithChildren($children, $allOrganizations));
        }

        return $result;
    }

    public function filterTree($items, &$tree, &$userTreeAccessedItems)
    {
        foreach($items as $item) {
            if(isset($item['id']) && in_array($item['id'], $userTreeAccessedItems)) {
                $tree[] = $item;
                continue;
            }
            if(!empty($item['children'])) {
                $this->filterTree($item['children'], $tree, $userTreeAccessedItems);
            }
        }
    }

    private function getWellTechStateDict(): array
    {
        $items = DB::connection('tbd')
            ->table('dict.well_tech_state_type as w')
            ->select('w.id', 'w.name_ru as label', 'w.parent as parent')
            ->distinct()
            ->orderBy('label', 'asc')
            ->leftJoin(
                'dict.well_tech_state_type as wp',
                function ($join) {
                    $join->on('wp.id', '=', 'w.parent');
                }
            )
            ->get()
            ->map(
                function ($item) {
                    return (array)$item;
                }
            )
            ->toArray();
        
        return $this->generateTree((array)$items);
    }

    private function getEquipTypeCascDict()
    {
        $dictClass = self::DICTIONARIES['equip_type']['class'];
        $nameField = self::DICTIONARIES['equip_type']['name_field'] ?? 'name';

        return $dictClass::query()
            ->select('id')
            ->selectRaw("$nameField as name")
            ->where(
                'parent',
                function ($query) {
                    return $query->select('id')
                        ->from('dict.equip_type')
                        ->where('code', 'CASC')
                        ->limit(1);
                }
            )
            ->orderBy('name', 'asc')
            ->get()
            ->toArray();
    }

    private function getGeoDictByType($type)
    {
        $items = DB::connection('tbd')
            ->table('dict.geo as g')
            ->select('g.id', 'g.name_ru as name', 'gp.parent as parent')
            ->where('gt.code', $type)
            ->distinct()
            ->orderBy('parent', 'asc')
            ->orderBy('name', 'asc')
            ->join('dict.geo_type as gt', 'g.geo_type', 'gt.id')
            ->leftJoin(
                'dict.geo_parent as gp',
                function ($join) {
                    $join->on('gp.geo', '=', 'g.id');
                    $join->on('gp.dbeg', '<=', DB::raw("NOW()"));
                    $join->on('gp.dend', '>=', DB::raw("NOW()"));
                }
            )
            ->get()
            ->map(
                function ($item) {
                    return (array)$item;
                }
            )
            ->toArray();

        return $items;                  

    }     
    
    private function getReasonTypeDict(string $type){
        $items = DB::connection('tbd')
            ->table('dict.reason as r')
            ->select('r.id', 'r.name_ru as name')
            ->where('rt.code', $type)
            ->distinct()
            ->orderBy('name', 'asc')
            ->join('dict.reason_type as rt', 'r.reason_type', 'rt.id')
            ->get()
            ->map(
                function ($item) {
                    return (array)$item;
                }
            )
            ->toArray();

        return $items;
    }

    private function getLasMnemonics()
    {
        $items = DB::connection('tbd')
            ->table('dict.metric as m')
            ->select('m.id', 'm.code')
            ->join('dict.metric as parent', 'm.parent', 'parent.id')
            ->where('parent.code', 'LASS')
            ->get()
            ->map(
                function ($item) {
                    return (array)$item;
                }
            )
            ->toArray();

        return $items;
    }

    private function getRepairTypeDict(string $type){
        $items = DB::connection('tbd')
            ->table('dict.repair_work_type as dr')
            ->select('dr.id','dr.name_ru as name')
            ->where('dw.code', $type)
            ->distinct()
            ->orderBy('name', 'asc')
            ->join('dict.well_repair_type as dw', 'dr.well_repair_type', 'dw.id')           
            ->get()
            ->map(
                function ($item) {
                    return (array)$item;
                }
            )
            ->toArray();


        return $items;
    }

    private function getWellStatusesForDrill()
    {
        return array_values(
            array_filter($this->get('well_statuses'), function ($item) {
                return in_array($item['code'], ['WRK', 'DWN']);
            })
        );
    }

    private function getResTypeDict(){
        $codes = ['CAO','SCWA','PVTPD','PVTP'];
        $items = DB::connection('tbd')
            ->table('dict.lab_research_type as r')
            ->select('r.id', 'r.name_ru as name', 'r.code')
            ->whereNotIn('r.code', $codes)
            ->orderBy('name', 'asc')
            ->get()
            ->map(
                function ($item) {
                    return (array)$item;
                }
            )
            ->toArray();
        return $items;
    }

    private function getResMethodDict(){
        $codes = ['NONE','PDC','IC'];
        $items = DB::connection('tbd')
            ->table('dict.research_method as r')
            ->select('r.id', 'r.name_ru as name', 'r.code')
            ->whereNotIn('r.code', $codes)
            ->orderBy('name', 'asc')
            ->get()
            ->map(
                function ($item) {
                    return (array)$item;
                }
            )
            ->toArray();
        return $items;
    }

    private function getGisMethodTypesForGisTypeForm()
    {
        $dict = $this->get('gis_method_types');
        return array_filter($dict, function ($item) {
            return !in_array($item['code'], ['GATR']);
        });
    }

    private function getGisKindsForGisTypeForm()
    {
        $gisType = GisType::where('code', 'WLS')->first();
        return DB::connection('tbd')
            ->table('dict.gis_kind')
            ->select('id', 'name_ru as name')
            ->where('gis_type', $gisType->id)
            ->orderBy('name', 'asc')
            ->get()
            ->map(
                function ($item) {
                    return (array)$item;
                }
            )
            ->toArray();
    }

    private function getRepairTypeDictKrsPrs($type){
        $items = DB::connection('tbd')
            ->table('dict.repair_work_type as dr')
            ->select('dr.id','dr.name_ru as name', 'pr.org as org')
            ->where('dw.code', $type)          
            ->leftJoin('prod.well_workover as p', 'p.repair_work_type', 'dr.id')  
            ->leftJoin('dict.well_repair_type as dw', 'dr.well_repair_type', 'dw.id')   
            ->leftJoin('prod.rwt_to_org as pr', 'p.repair_work_type', 'pr.rwt')  
            ->distinct()
            ->orderBy('name', 'asc') 
            ->get()
            ->map(
                function ($item) {
                    return (array)$item;
                }
            )
            ->toArray();


        return $items;
    }
}    