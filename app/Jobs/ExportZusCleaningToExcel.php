<?php

namespace App\Jobs;

use App\Models\ComplicationMonitoring\ZusCleaning;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;
use App\Filters\ZusCleaningFilter;
use App\Exports\ZusCleaningExport;
use Carbon\Carbon;

class ExportZusCleaningToExcel implements ShouldQueue
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
        $query = ZusCleaning::query()
            ->with('zu');

        $zus_cleaning = (new ZusCleaningFilter($query, $this->params))
            ->filter()
            ->get();

        $fileName = '/export/zus_cleaning_' . Carbon::now()->format('YmdHis') . '.xlsx';
        Excel::store(new ZusCleaningExport($zus_cleaning), 'public'.$fileName);

        $this->setOutput(
            [
                'filename' => '/storage'.$fileName
            ]
        );
    }
}
