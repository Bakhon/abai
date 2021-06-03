<?php

namespace App\Http\Controllers\Refs\bigdata\las;

class RecordingStateController extends LasDictionariesController
{
    protected $modelName = 'recording_state';
    protected $model = 'App\Models\BigData\Dictionaries\RecordingState';
    protected $resource = 'App\Http\Resources\RecordingStateResource';
    protected $link = 'recording-state';
}
