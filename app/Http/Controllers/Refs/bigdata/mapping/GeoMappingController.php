<?php

namespace App\Http\Controllers\Refs\bigdata\mapping;

use Illuminate\Support\Facades\Session;
use App\Http\Requests\WellMappingRequest;
use App\Http\Controllers\Refs\bigdata\las\LasDictionariesController;

class GeoMappingController extends MappingController
{
    protected $modelName = 'file_status';
    protected $model = 'App\Models\BigData\Dictionaries\GeoMapping';
    protected $resource = 'App\Http\Resources\GeoMappingListResource';
    protected $link = 'geo-mapping';
    protected $view = 'bigdata.well_mapping';
}
