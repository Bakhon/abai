<?php

namespace App\Http\Controllers\Refs\bigdata\mapping;

class GeoMappingController extends MappingController
{
    protected $modelName = 'geo_mapping';
    protected $model = 'App\Models\BigData\Dictionaries\GeoMapping';
    protected $resource = 'App\Http\Resources\GeoMappingListResource';
    protected $link = 'geo-mapping';
    protected $view = 'bigdata.geo_mapping';
}
