<?php

namespace App\Http\Controllers;


class OrganizationsController extends Controller
{
    public function index()
    {
        $organizations = auth()->user()->getOrganizations();

        return response()->json([
            'organizations' => \App\Http\Resources\OrganizationResource::collection($organizations)
        ]);

    }
}
