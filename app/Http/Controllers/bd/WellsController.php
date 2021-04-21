<?php

namespace App\Http\Controllers\bd;

use App\Http\Controllers\Controller;
use App\Http\Requests\BigData\WellCreateRequest;
use App\Models\BigData\Well;
use Carbon\Carbon;

class WellsController extends Controller
{
    public function index()
    {
        $wells = Well::active(Carbon::now())->paginate(20);
        return view('bigdata.wells.index', compact('wells'));
    }

    public function show(Well $well)
    {
        return view('bigdata.wells.show', compact('well'));
    }

    public function create()
    {
        return view('bigdata.wells.create');
    }

    public function store(WellCreateRequest $request): WellResource
    {
        $well = Well::create($request->all());
        return $well;
    }
}
