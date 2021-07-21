<?php

namespace App\Http\Controllers;

use App\Services\BigData\StructureService;
use Illuminate\Http\JsonResponse;

class OrganizationsController extends Controller
{
    private static $childrenIds = [];

    public function index()
    {
        $organizations = auth()->user()->getOrganizations();

        return response()->json([
            'organizations' => \App\Http\Resources\OrganizationResource::collection($organizations)
        ]);

    }

    public function getUserOrganizations(StructureService $structureService): JsonResponse
    {

        return response()->json([
            'organizations' => auth()->user()->getUserOrganizations($structureService)
        ]);

    }

    public static function getChildIds(array $orgs, int $selectedUserDzo): array
    {
        self::$childrenIds[] = $selectedUserDzo;
        foreach ($orgs as $child) {
            self::getChildsRecursive($child);
        }

        return self::$childrenIds;
    }

    private static function getChildsRecursive(array $child): void
    {
        if (isset($child['children'])) {
            if (in_array($child['id'], self::$childrenIds)) {
                self::$childrenIds = array_merge(self::$childrenIds, array_map(function ($item) {
                    return $item['id'];
                }, $child['children']));
            }
            foreach ($child['children'] as $childrenItem) {
                self::getChildsRecursive($childrenItem);
            }
        }
    }
}
