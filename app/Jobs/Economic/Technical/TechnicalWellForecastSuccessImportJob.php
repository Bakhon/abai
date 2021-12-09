<?php

namespace App\Jobs\Economic\Technical;

use App\Models\Refs\EconomicDataLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TechnicalWellForecastSuccessImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $logId;

    public function __construct(int $logId)
    {
        $this->logId = $logId;
    }

    public function handle()
    {
        EconomicDataLog::query()
            ->where([
                'id' => $this->logId,
                'is_processed' => false,
            ])
            ->update([
                'is_processed' => true
            ]);
    }
}
