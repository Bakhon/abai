<?php

namespace App\Jobs;

use App\Exports\OmgCAExport;
use App\Filters\OmgCAFilter;
use App\Models\ComplicationMonitoring\OmgCA;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;

class ExportOmgCAToExcel implements ShouldQueue
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
        $query = OmgCA::query()
            ->with('gu');

        $omgca = (new OmgCAFilter($query, $this->params))
            ->filter()
            ->get();

        $fileName = '/export/omgca_' . Carbon::now()->format('YmdHis') . '.xlsx';
        Excel::store(new OmgCAExport($omgca), 'public'.$fileName);

        $this->setOutput(
            [
                'filename' => '/storage'.$fileName
            ]
        );
    }
}
