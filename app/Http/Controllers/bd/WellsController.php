<?php

namespace App\Http\Controllers\bd;

use App\Http\Controllers\Controller;
use App\Http\Requests\BigData\WellCreateRequest;
use Illuminate\Http\Request;

class WellsController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('bigdata.wells.create');
    }

    public function store(WellCreateRequest $request): \App\Models\BigData\Well
    {
        $well = \App\Models\BigData\Well::create($request->all());
        return $well;
    }
}
