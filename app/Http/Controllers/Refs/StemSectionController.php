<?php

namespace App\Http\Controllers\Refs;

class StemSectionController extends LasDictionariesController
{
    protected $modelName = 'stem_section';
    protected $model = 'App\Models\BigData\Dictionaries\StemSection';
    protected $resource = 'App\Http\Resources\StemSectionResource';
}
