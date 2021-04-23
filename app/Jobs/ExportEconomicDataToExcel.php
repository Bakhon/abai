<?php

namespace App\Jobs;

use App\Exports\EconomicDataExport;
use App\Http\Controllers\EconomicController;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use Level23\Druid\DruidClient;
use Level23\Druid\Extractions\ExtractionBuilder;
use Maatwebsite\Excel\Facades\Excel;

class ExportEconomicDataToExcel implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Trackable;

    public $tries = 1;

    protected $params;

    public function __construct(array $params)
    {
        $this->prepareStatus();

        $this->params = $params;
    }

    public function handle()
    {
        $interval = EconomicController::intervalMonths(
            $this->params['interval_start'] ?? null,
            $this->params['interval_end'] ?? null
        );

        $druid = new DruidClient(config('druid'));

        $granularity = $this->params['granularity'];
        $granularityFormat = EconomicController::granularityFormat($granularity);

        $builder = $druid
            ->query(EconomicController::DATA_SOURCE, $granularity)
            ->interval($interval)
            ->select('__time', EconomicDataExport::COLUMN_DATE, function (ExtractionBuilder $extBuilder) use ($granularityFormat) {
                $extBuilder->timeFormat($granularityFormat);
            });

        foreach (EconomicDataExport::COLUMNS_SELECT as $column) {
            $builder->select($column);
        }

        foreach (EconomicDataExport::COLUMNS_SUM as $column) {
            $builder->sum($column);
        }

        if (isset($this->params['org_id2'])) {
            $builder->where('org_id2', '=', $this->params['org_id2']);
        }

        if (isset($this->params['dpz'])) {
            $builder->where('dpz', '=', $this->params['dpz']);
        }

        $data = $builder->groupBy()->data();

        $fileName = '/export/economic_' . Carbon::now()->format('YmdHis') . '.xlsx';

        Excel::store(new EconomicDataExport($data), 'public' . $fileName);

        $this->setOutput([
            'filename' => '/storage' . $fileName
        ]);
    }
}
