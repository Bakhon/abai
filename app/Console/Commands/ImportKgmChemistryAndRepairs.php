<?php

namespace App\Console\Commands;

use App\Http\Controllers\VisCenter\VisualCenterController;
use App\Http\Requests\POSTCaller;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class ImportKgmChemistryAndRepairs extends Command
{
    protected $signature = 'import-kgm-chemistry-and-repairs:cron';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $this->getKGMData();

    }

    public function getKGMData()
    {

        $date = Carbon::now();
        $lastMonth = $date->subMonth()->firstOfMonth();
        $post = new POSTCaller(
            VisualCenterController::class,
            'storeKGMChemistryAndRepairsByMonth',
            Request::class,
            [
                'date' => $lastMonth,
            ]
        );
        echo $post->call();
    }
}
