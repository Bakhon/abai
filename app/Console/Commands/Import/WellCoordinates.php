<?php

namespace App\Console\Commands\Import;

use Carbon\Carbon;
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
    public function handle(\App\Services\DruidService $druidService)
    {
        $wells = \App\Models\Refs\Well::query()
            ->where('updated_at', '>', Carbon::now()->subDay(2))
            ->get()
            ->keyBy('name');

        $coordinates = $druidService->getWellCoordinates();
        foreach($coordinates as $wellCoord) {

            if($wellCoord['surfy'] > 45 || $wellCoord['surfy'] < 42) continue;
            if($wellCoord['surfx'] > 54 || $wellCoord['surfx'] < 51) continue;

            $well = $wells->get($wellCoord['uwi']);
            if(!empty($well)) {
                $well->lat = $wellCoord['surfy'];
                $well->lon = $wellCoord['surfx'];
                $well->save();
            }
        }

    }
}
