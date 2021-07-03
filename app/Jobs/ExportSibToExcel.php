<?php

namespace App\Jobs;

use App\Models\ComplicationMonitoring\Sib;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;
use App\Filters\SibFilter;
use App\Exports\SibExport;
use Carbon\Carbon;

class ExportAgzuToExcel implements ShouldQueue
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
        $query = Sib::query()
            ->with('gu');

        $sib = (new SibFilter($query, $this->params))
            ->filter()
            ->get();

        $fileName = '/export/sib_' . Carbon::now()->format('YmdHis') . '.xlsx';
        Excel::store(new SibExport($sib), 'public'.$fileName);

        $this->setOutput(
            [
                'filename' => '/storage'.$fileName
            ]
        );
    }
}
