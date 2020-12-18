<?php

namespace App\Http\Controllers;

class RefsController extends Controller
{
    public function getMaterials()
    {
        $materials = \App\Models\ComplicationMonitoring\Material::all();

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $materials
            ]
        );
    }

    public function getInhibitors()
    {
        $inhibitors = \App\Models\Inhibitor::all();

        return response()->json(
            [
                'code' => 200,
                'message' => 'success',
                'data' => $inhibitors
            ]
        );
    }
}
