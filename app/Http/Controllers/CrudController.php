<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexTableRequest;

class CrudController extends Controller
{

    protected $modelName;

    public function __construct()
    {
        $this->middleware('can:monitoring list '.$this->modelName, ['only' => ['index','list']]);
        $this->middleware('can:monitoring create '.$this->modelName, ['only' => ['create','store']]);
        $this->middleware('can:monitoring read '.$this->modelName, ['only' => ['show']]);
        $this->middleware('can:monitoring update '.$this->modelName, ['only' => ['edit','update']]);
        $this->middleware('can:monitoring delete '.$this->modelName, ['only' => ['destroy']]);
        $this->middleware('can:monitoring export '.$this->modelName, ['only' => ['export']]);
        $this->middleware('can:monitoring view history '.$this->modelName, ['only' => ['history']]);
    }

    public function list (IndexTableRequest $request) {
        $input = $request->validated();
        $model_name_filter = $this->modelName.'_filter';
        session([$model_name_filter => $input]);
    }

}