<?php

namespace App\Jobs;

use App\Models\ComplicationMonitoring\Corrosion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;
use App\Filters\BufferTankFilter;
use App\Exports\BufferTankExport;
use Carbon\Carbon;

class ExportBufferTankToExcel implements ShouldQueue
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
        $query = BufferTank::query()
            ->with('other_objects')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu');

        $bufferTank = (new BufferTankFilter($query, $this->params))
            ->filter()
            ->get();

        $fileName = '/export/corrosion_' . Carbon::now()->format('YmdHis') . '.xlsx';
        Excel::store(new BufferTankExport($bufferTank), 'public'.$fileName);

        $this->setOutput(
            [
                'filename' => '/storage'.$fileName
            ]
        );
    }
}
