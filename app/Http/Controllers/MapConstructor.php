<?php

namespace App\Http\Controllers;

use App\Services\PolygonsService;
use Illuminate\Http\Request;

class MapConstructor extends Controller
{
    protected $service;

    public function __construct(PolygonsService $service)
    {
        $this->service = $service;
    }

    public function importFile(Request $request) {
        $file = $request->file('file');
        $numberOfLevels = (int)$request->get('number_of_levels');
        $type = $request->get('type');

        return $this->service->getPolygons($file, $numberOfLevels, $type);
    }
}