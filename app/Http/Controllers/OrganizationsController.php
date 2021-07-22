<?php

namespace App\Http\Controllers;

use App\Services\BigData\StructureService;
use Illuminate\Http\JsonResponse;

class OrganizationsController extends Controller
{
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
}
