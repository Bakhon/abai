<?php

namespace App\Http\Controllers\Refs\bigdata\las;

class FileTypeController extends LasDictionariesController
{
    protected $modelName = 'file_type';
    protected $model = 'App\Models\BigData\Dictionaries\FileType';
    protected $resource = 'App\Http\Resources\FileTypeListResource';
    protected $link = 'file-type';
}
