<?php

namespace App\Http\Controllers\Api\DB;

use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Well;
use App\Services\BigData\StructureService;

class StructureController
{

    public function getOrgIdsByWellId(StructureService $structureService, Well $well)
    {
        $orgIds = [];
        $orgs = $well->orgs;
        foreach ($orgs as $org) {
            $orgWithParents = $structureService->getPath($org->id, 'org')->pluck('id')->toArray();
            $orgIds = array_merge($orgIds, $orgWithParents);
        }

        return [
            'orgs' => $orgIds
        ];
    }

    public function getDzo(StructureService $structureService)
    {
        $tree = $structureService->getTreeWithPermissions();
        $orgIds = $this->fillOrgIds($tree, []);

        $orgs = [];
        if (!empty($orgIds)) {
            $orgs = Org::query()
                ->select('id', 'name_ru', 'name_short_ru')
                ->whereIn('id', $orgIds)
                ->get();
        }

        return [
            'orgs' => $orgs
        ];
    }

    private function fillOrgIds(array $tree, array $orgIds)
    {
        foreach ($tree as $item) {
            if ($item['type'] === 'org' && $item['sub_type'] === 'SUBC') {
                $orgIds[] = $item['id'];
            }
            if (!empty($item['children'])) {
                $orgIds = $this->fillOrgIds($item['children'], $orgIds);
            }
        }
        return $orgIds;
    }

}