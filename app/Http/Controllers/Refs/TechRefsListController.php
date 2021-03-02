<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class TechRefsListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function refsList(){
        return view('tech_refs.list');
    }

}
