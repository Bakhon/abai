<?php

namespace App\Jobs;

use App\Models\ComplicationMonitoring\OilPipes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;

class ExportOilPipesToExcel implements ShouldQueue
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
        $query = OilPipes::query()
            ->with('ngdu')
            ->with('gu')
            ->with('zu')
            ->with('well');

        $oilpipes = (new \App\Filters\OilPipesFilter($query, $this->params))
            ->filter()
            ->get();

        $fileName = '/export/oilpipes_' . \Carbon\Carbon::now()->format('YmdHis') . '.xlsx';
        Excel::store(new \App\Exports\OilPipesExport($oilpipes), 'public'.$fileName);

        $this->setOutput(
            [
                'filename' => '/storage'.$fileName
            ]
        );
    }
}
