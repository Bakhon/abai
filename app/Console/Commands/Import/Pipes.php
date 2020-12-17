<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Command;
use Level23\Druid\Types\Granularity;
use Maatwebsite\Excel\Facades\Excel;

class Pipes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:pipes {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import coordinates of pipes in GUs';

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
    public function handle(): void
    {
        Excel::import(new \App\Imports\PipesImport(), base_path($this->argument('path')));
        $this->calculateCoordinates();
    }

    private function calculateCoordinates(): void
    {

        $gus = \App\Models\Refs\Gu::query()
            ->whereHas('zuPipes')
            ->orWhereHas('wellPipes')
            ->get();

        foreach ($gus as $gu) {
            if ($gu->wellPipes->isNotEmpty()) {
                $zuWellPipes = $gu->wellPipes->groupBy('zu_id');
                $zuCoords = null;
                foreach ($zuWellPipes as $zuId => $wellPipes) {
                    if (empty($zuId)) {
                        continue;
                    }
                    $zuCoords = null;
                    if ($wellPipes->count() > 2) {
                        $firstPipe = $wellPipes->first();
                        $secondPipe = $wellPipes->last();

                        $firstLine = [
                            implode(',', $firstPipe->coordinates[0]),
                            implode(',', last($firstPipe->coordinates)),
                        ];
                        $secondLine = [
                            implode(',', $secondPipe->coordinates[0]),
                            implode(',', last($secondPipe->coordinates)),
                        ];
                        $intersect = array_intersect($firstLine, $secondLine);

                        if (!empty($intersect) && count($intersect) === 1) {
                            $zuCoords = explode(',', array_values($intersect)[0]);
                            $zu = \App\Models\Refs\Zu::find($zuId);
                            $zu->lat = $zuCoords[0];
                            $zu->lon = $zuCoords[1];
                            $zu->save();
                        }
                    }
                    if (!empty($zuCoords)) {

                        foreach ($wellPipes as $wellPipe) {
                            $firstPoint = $wellPipe->coordinates[0];
                            $lastPoint = last($wellPipe->coordinates);

                            $wellCoords = null;
                            if ($firstPoint == $zuCoords) {
                                $wellCoords = $lastPoint;
                            } elseif ($lastPoint == $zuCoords) {
                                $wellCoords = $firstPoint;
                            }

                            if (!empty($wellCoords)) {
                                if (!empty($wellPipe->well)) {
                                    $wellPipe->well->lat = $wellCoords[0];
                                    $wellPipe->well->lon = $wellCoords[1];
                                    $wellPipe->well->save();
                                }
                            }
                        }
                    }
                }
            }
            if ($gu->zuPipes->isNotEmpty()) {
                foreach($gu->zuPipes as $zuPipe) {
                    if($zuPipe->zu->lat && $zuPipe->zu->lon) {

                        $zuCoords = [
                            $zuPipe->zu->lat,
                            $zuPipe->zu->lon
                        ];

                        $firstPoint = $zuPipe->coordinates[0];
                        $lastPoint = last($zuPipe->coordinates);

                        if ($firstPoint == $zuCoords) {
                            $guCoords = $lastPoint;
                            break;
                        } elseif ($lastPoint == $zuCoords) {
                            $guCoords = $firstPoint;
                            break;
                        }

                    }
                }

                if(!empty($guCoords)) {
                    $gu->lat = $guCoords[0];
                    $gu->lon = $guCoords[1];
                    $gu->save();
                }
            }
        }
    }
}
