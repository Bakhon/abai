<?php

namespace App\Http\Controllers;

use App\Services\BigData\StructureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationsController extends Controller
{
    public function index()
    {
        $organizations = auth()->user()->getOrganizations();

        return response()->json([
            'organizations' => \App\Http\Resources\OrganizationResource::collection($organizations)
        ]);

    }

    public function getUserOrganizations(Request $request, StructureService $structureService): JsonResponse
    {
        $onlyMain = (bool)$request->get('only_main');
        if ($onlyMain) {
            return response()->json([
                'organizations' => auth()->user()->getUserOrganizations($structureService)
            ]);
        }
        return response()->json([
            'organizations' => auth()->user()->getUserAllOrganizations($structureService)
        ]);

    }
}
