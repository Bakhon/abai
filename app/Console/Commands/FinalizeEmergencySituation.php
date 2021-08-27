<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\EmergencyHistory;

class FinalizeEmergencySituation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'finalize-emergency:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finalize an emergency situations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function processEmergencySituations()
    {
        $emergencySituations = $this->getSituations();
        foreach($emergencySituations as $situation) {
            $status = $this->processSituation($situation);
        }
    }

    private function getSituations()
    {
        return EmergencyHistory::query()
                  ->select('description','date','id')
                  ->whereNull('approved')
                  ->get();
    }

    private function processSituation($situation)
    {
        $dzoRecord = DzoImportData::query()
            ->select('date')
            ->where('dzo_name',$situation->description)
            ->whereDate('date',Carbon::parse($situation->date)->subDays(1))
            ->first();

        if (!is_null($dzoRecord)) {
            $this->resolveSituation($dzoRecord->date,$situation->id);
        }
    }

    private function resolveSituation($resolveDate,$situationId)
    {
        EmergencyHistory::query()
            ->where('id', $situationId)
            ->update(
                [
                    'approve_date' => $resolveDate,
                    'approved' => true
                ]
            );
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->processEmergencySituations();
    }
}
