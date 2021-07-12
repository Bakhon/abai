<?php

namespace App\Http\Controllers\bd;

use App\Http\Controllers\Controller;
use App\Http\Requests\BigData\WellCreateRequest;
use App\Models\BigData\Well;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class WellsController extends Controller
{
    public function index()
    {
        $wells = Well::active(Carbon::now())->orderBy('uwi', 'asc')->paginate(20);
        return view('bigdata.wells.index', compact('wells'));
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
