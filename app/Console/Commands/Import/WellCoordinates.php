<?php

namespace App\Console\Commands\Import;

use App\Models\ComplicationMonitoring\Well;
use App\Services\DruidService;
use Illuminate\Console\Command;

class WellCoordinates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:well_coordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import well coordinates';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(DruidService $druidService)
    {
        $wells = Well::query()
            ->get()
            ->keyBy('name');

        $coordinates = $druidService->getWellCoordinates();
        foreach($coordinates as $wellCoord) {

            if($wellCoord['surfy'] > 45 || $wellCoord['surfy'] < 42) continue;
            if($wellCoord['surfx'] > 54 || $wellCoord['surfx'] < 51) continue;

            $well = $wells->get($wellCoord['uwi']);
            if(!empty($well) && empty($well->lat) && empty($well->lon)) {
                $well->lat = $wellCoord['surfy'];
                $well->lon = $wellCoord['surfx'];
                $well->save();
            }
        }

    }
}
