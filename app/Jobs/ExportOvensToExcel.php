<?php

namespace App\Jobs;

use App\Models\ComplicationMonitoring\Oven;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;
use App\Filters\OvenFilter;
use App\Exports\OvensExport;
use Carbon\Carbon;

class ExportOvensToExcel implements ShouldQueue
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
        $query = Oven::query()
            ->with('gu');

        $oven = (new OvenFilter($query, $this->params))
            ->filter()
            ->get();

        $fileName = '/export/ovens_' . Carbon::now()->format('YmdHis') . '.xlsx';
        Excel::store(new OvensExport($oven), 'public'.$fileName);

        $this->setOutput(
            [
                'filename' => '/storage'.$fileName
            ]
        );
    }
}
