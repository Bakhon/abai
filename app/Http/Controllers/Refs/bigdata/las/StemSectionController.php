<?php

namespace App\Http\Controllers\Refs\bigdata\las;

class StemSectionController extends LasDictionariesController
{
    protected $modelName = 'stem_section';
    protected $model = 'App\Models\BigData\Dictionaries\StemSection';
    protected $resource = 'App\Http\Resources\StemSectionResource';
    protected $link = 'stem-section';
}
