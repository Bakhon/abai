<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\BigData\StructureService;
use Carbon\Carbon;

class OrgsController extends Controller
{

    public function index(StructureService $structureService)
    {
        $orgs = $this->mapTree($structureService->getTree(Carbon::now()));

        return [
            'orgs' => $orgs
        ];
    }

    public function mapTree(array $tree)
    {
        foreach ($tree as &$item) {
            $item['id'] = $item['type'] . ':' . $item['id'];
            $item['label'] = $item['name'];

            if (isset($item['children'])) {
                $item['children'] = $this->mapTree($item['children']);
            }
        }
        return $tree;
    }

}
