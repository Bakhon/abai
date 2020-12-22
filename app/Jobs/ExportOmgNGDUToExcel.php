<?php

namespace App\Jobs;

use App\Models\ComplicationMonitoring\OmgNGDU;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;

class ExportOmgNGDUToExcel implements ShouldQueue
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
        $query = OmgNGDU::query()
            ->with('field')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->with('zu')
            ->with('well');

        $omgngdu = (new \App\Filters\OmgNGDUFilter($query, $this->params))
            ->filter()
            ->get();

        $fileName = '/export/omgngdu_' . \Carbon\Carbon::now()->format('YmdHis') . '.xlsx';
        Excel::store(new \App\Exports\OmgNGDUExport($omgngdu), 'public'.$fileName);

        $this->setOutput(
            [
                'filename' => '/storage'.$fileName
            ]
        );
    }
}
