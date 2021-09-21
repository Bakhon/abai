<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Services\BigData\StructureService;
use Level23\Druid\DruidClient;

class EconomicAnalysisController extends Controller
{
    protected $druidClient;
    protected $structureService;

    public function __construct(DruidClient $druidClient, StructureService $structureService)
    {
        $this
            ->middleware('can:economic view main')
            ->only('index', 'getData');

        $this->druidClient = $druidClient;

        $this->structureService = $structureService;
    }

    public function index()
    {
        return view('economic.analysis');
    }
}
