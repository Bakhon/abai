<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Models\Refs\TechnicalStructureSource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TechnicalStructureSourceController extends TechnicalStructureController
{
    protected $model = "App\Models\Refs\TechnicalStructureSource";

    protected $controller_name = 'source';
    protected $index_route = "tech_struct_source.index";
}
