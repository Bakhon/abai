<?php

namespace App\Http\Controllers\Refs;

class FileStatusController extends LasDictionariesController
{
    protected $modelName = 'file_status';
    protected $model = 'App\Models\BigData\Dictionaries\FileStatus';
    protected $resource = 'App\Http\Resources\FileStatusListResource';
}
