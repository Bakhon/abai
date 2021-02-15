<?php

namespace App\Http\Controllers\bd;

use App\Exceptions\DictionaryNotFound;
use App\Http\Controllers\Controller;
use App\Services\BigData\DictionaryService;

class DictionariesController extends Controller
{

    protected $service;

    public function __construct(DictionaryService $service)
    {
        $this->service = $service;
    }

    public function get(string $dict)
    {
        try {
            $result = $this->service->get($dict);
            return $result;
        } catch (DictionaryNotFound $e) {
            return response()->json([], \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

}
