<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ModuleListResource;
use App\Module;

class ModulesController extends Controller
{

    public function index()
    {
        return [
            'modules' => ModuleListResource::collection(Module::all())
        ];
    }

}
