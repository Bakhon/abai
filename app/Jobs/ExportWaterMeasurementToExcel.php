<?php

namespace App\Jobs;

use App\Exports\WaterMeasurementExport;
use App\Filters\WaterMeasurementFilter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;

class ExportWaterMeasurementToExcel implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Trackable;

    public $tries = 1;

    protected $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->prepareStatus();
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $query = \App\Models\ComplicationMonitoring\WaterMeasurement::query()
            ->with('other_objects')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->with('zu')
            ->with('well')
            ->with('waterTypeBySulin')
            ->with('sulphateReducingBacteria')
            ->with('hydrocarbonOxidizingBacteria')
            ->with('thionicBacteria');

        $watermeasurement = (new WaterMeasurementFilter($query, $this->params))
            ->filter()
            ->get();

        $fileName = '/export/watermeasurement_' . \Carbon\Carbon::now()->format('YmdHis') . '.xlsx';
        Excel::store(new WaterMeasurementExport($watermeasurement), 'public'.$fileName);

        $this->setOutput(
            [
                'filename' => '/storage'.$fileName
            ]
        );
    }
}
