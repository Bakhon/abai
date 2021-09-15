<?php

namespace App\Http\Controllers\bd;

use App\Http\Controllers\Controller;
use App\Http\Requests\BigData\WellCreateRequest;
use App\Models\BigData\Well;
use Illuminate\Support\Facades\File;

class WellsController extends Controller
{
    public function index()
    {
        return view('bigdata.wells.index');
    }

    public function show(Well $well)
    {
        return view('bigdata.wells.show', compact('well'));
    }

    public function create()
    {
        $forms = collect(json_decode(File::get(resource_path("/js/json/bd/forms.json"))));
        $params = $forms->where('code', 'well_register')->first();

        return view('bigdata.wells.create', compact('params'));
    }

    public function store(WellCreateRequest $request): WellResource
    {
        $well = Well::create($request->all());
        return $well;
    }
}
