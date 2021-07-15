<?php

namespace App\Http\Controllers\Refs\bigdata\mapping;

use App\Models\BigData\Dictionaries\GeoMapping;
use App\Http\Resources\GeoMappingListResource;

class GeoMappingController extends MappingController
{
    protected $modelName = 'geo_mapping';
    protected $model = GeoMapping::class;
    protected $resource = GeoMappingListResource::class;
    protected $link = 'geo-mapping';
    protected $view = 'bigdata.geo_mapping';
}
