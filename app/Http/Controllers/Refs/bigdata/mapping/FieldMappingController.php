<?php

namespace App\Http\Controllers\Refs\bigdata\mapping;

use Illuminate\Support\Facades\Session;
use App\Http\Requests\WellMappingRequest;
use App\Http\Controllers\Refs\bigdata\las\LasDictionariesController;

class WellMappingController extends LasDictionariesController
{
    protected $modelName = 'file_status';
    protected $model = 'App\Models\BigData\Dictionaries\WellMapping';
    protected $resource = 'App\Http\Resources\WellMappingListResource';
    protected $link = 'well-mapping';
    protected $view = 'bigdata.well_mapping';
}
