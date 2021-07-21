<?php

namespace App\Http\Controllers\Api\DB;

use App\Models\BigData\Dictionaries\Org;
use App\Services\BigData\StructureService;

class StructureController
{

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