<?php

namespace App\Http\Controllers\Refs\bigdata\las;

class RecordingMethodController extends LasDictionariesController
{
    protected $modelName = 'recording_method';
    protected $model = 'App\Models\BigData\Dictionaries\RecordingMethod';
    protected $resource = 'App\Http\Resources\RecordingMethodResource';
    protected $link = 'recording-method';
}
