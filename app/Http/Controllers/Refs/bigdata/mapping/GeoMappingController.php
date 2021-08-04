<?php

namespace App\Http\Controllers\Refs\bigdata\mapping;

use App\Models\BigData\Dictionaries\GeoMapping;
use App\Http\Resources\GeoMappingListResource;
use App\Http\Requests\GeoMappingRequest;

class GeoMappingController extends MappingController
{
    protected $modelName = 'geo_mapping';
    protected $model = GeoMapping::class;
    protected $resource = GeoMappingListResource::class;
    protected $request = GeoMappingRequest::class;
    protected $link = 'geo-mapping';
    protected $view = 'bigdata.geo_mapping';
    protected $queryMethod = 'geo';
    protected $rules = [
        'name_ru' => 'required|string',
        'geo_id' => 'required|numeric',
    ];
}
