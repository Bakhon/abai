<?php

namespace App\Http\Controllers\Refs\bigdata\las;

class StemTypeController extends LasDictionariesController
{
    protected $modelName = 'stem_type';
    protected $model = 'App\Models\BigData\Dictionaries\StemType';
    protected $resource = 'App\Http\Resources\StemTypeResource';
    protected $link = 'stem-type';
}
