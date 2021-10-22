<?php

namespace App\Jobs;

use App\Exports\ManualHydroCalcExport;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;

class ExportManualHydroCalc implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Trackable;

    public $tries = 1;

    protected $params;
    protected $pipes;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params, \Illuminate\Database\Eloquent\Collection $pipes)
    {
        $this->prepareStatus();
        $this->params = $params;
        $this->pipes = $pipes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fileName = '/export/manual_hydro_calc_' . Carbon::now()->format('YmdHis') . '.xlsx';
        Excel::store(new ManualHydroCalcExport($this->params, $this->pipes), 'public' . $fileName);

        $this->setOutput(
            [
                'filename' => '/storage' . $fileName
            ]
        );
    }
}
