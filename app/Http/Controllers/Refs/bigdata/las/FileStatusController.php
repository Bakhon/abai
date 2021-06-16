<?php

namespace App\Http\Controllers\Refs\bigdata\las;

class FileStatusController extends LasDictionariesController
{
    protected $modelName = 'file_status';
    protected $model = 'App\Models\BigData\Dictionaries\FileStatus';
    protected $resource = 'App\Http\Resources\FileStatusListResource';
    protected $link = 'file-status';
}
