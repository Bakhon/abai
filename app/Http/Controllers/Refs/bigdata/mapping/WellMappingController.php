<?php

namespace App\Http\Controllers\Refs\bigdata\mapping;

use App\Models\BigData\Dictionaries\WellMapping;
use App\Http\Resources\WellMappingListResource;

class WellMappingController extends MappingController
{
    protected $modelName = 'well_mapping';
    protected $model = WellMapping::class;
    protected $resource = WellMappingListResource::class;
    protected $link = 'well-mapping';
    protected $view = 'bigdata.geo_mapping';
    protected $queryMethod = 'well';
    protected $rules = [
        'name_ru' => 'required|string',
        'geo_id' => 'required|numeric',
        'well_id' => 'required|numeric',
    ];
}
