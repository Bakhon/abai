<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportChemistry;
use App\Models\VisCenter\ExcelForm\DzoImportOtm;
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
    protected $types = array(
        2 => 'DzoImportChemistry',
        3 => 'DzoImportOtm'
    );

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
            if (array_key_exists($situation->type,$this->types)) {
                $this->processChemistryWorkoverSituation($situation,$this->types[$situation->type]);
            } else {
                $this->processSituation($situation);
            }
        }
    }

    private function getSituations()
    {
        return EmergencyHistory::query()
                  ->select('description','date','id','type')
                  ->whereNull('approved')
                  ->get();
    }

    private function processSituation($situation)
    {
        $dzoRecord = DzoImportData::query()
            ->select('created_at')
            ->where('dzo_name',$situation->description)
            ->whereDate('date',Carbon::parse($situation->date)->subDays(1))
            ->whereNull('is_corrected')
            ->first();

        if (!is_null($dzoRecord)) {
            $this->resolveSituation($dzoRecord->created_at,$situation->id);
        }
    }

    private function processChemistryWorkoverSituation($situation,$type)
    {
        $model = '\App\Models\VisCenter\ExcelForm\\' . $type;
        $dzoRecord = $model::query()
            ->select('date','dzo_name')
            ->where('dzo_name',$situation->description)
            ->whereMonth('date', Carbon::now()->month-1)
            ->whereYear('date', Carbon::now()->year)
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
