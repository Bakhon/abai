<?php

namespace App\Http\Controllers\Refs;

class StemTypeController extends LasDictionariesController
{
    protected $modelName = 'stem_type';
    protected $model = 'App\Models\BigData\Dictionaries\StemType';
    protected $resource = 'App\Http\Resources\StemTypeResource';
}
