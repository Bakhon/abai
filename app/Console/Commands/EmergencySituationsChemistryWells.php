<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\VisCenter\ExcelForm\DzoImportChemistry;
use App\Models\VisCenter\ExcelForm\DzoImportOtm;
use App\Models\VisCenter\EmergencyHistory;

class EmergencySituationsChemistryWells extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-emergency-chemistry-wells:cron';
    protected $companies = array('КОА','КГМ','ЭМГ','КТМ','КБМ','ММГ','ОМГ');
    protected $typeMapping = array(
         'chemistry' => 'Не заполнена Химизация',
         'wellsWorkover' => 'Не заполнен Ремонт скважин'
    );
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create records on incident situations for chemistry and wells workover';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    private function verificationOfCompletedCompanies()
    {
        $chemistryCompleted = $this->getCompletedCompanies('DzoImportChemistry');
        if (count($chemistryCompleted) < 7) {
            $this->createIncidents($chemistryCompleted,'chemistry');
        }
        $otmCompleted = $this->getCompletedCompanies('DzoImportOtm');
        if (count($otmCompleted) < 7) {
            $this->createIncidents($otmCompleted,'wellsWorkover');
        }
    }
    private function getCompletedCompanies($modelName)
    {
        $model = '\App\Models\VisCenter\ExcelForm\\' . $modelName;
        return $model::query()
            ->select('dzo_name')
            ->whereMonth('date', Carbon::now()->month-1)
            ->whereYear('date', Carbon::now()->year)
            ->get()
            ->toArray();
    }
    private function createIncidents($existingCompanies,$type)
    {
        $companyDifference = $this->getDifference($existingCompanies);
        foreach($companyDifference as $company) {
            $this->store($company,$this->typeMapping[$type]);
        }
    }
    private function getDifference($existingCompanies)
    {
        $presentCompanies = array();
        foreach($existingCompanies as $company) {
            $presentCompanies[] = $company['dzo_name'];
        }
       return array_diff($this->companies,$presentCompanies);
    }
    private function store($company,$type)
    {
        $incident = array (
            'date' => Carbon::now(),
            'type' => 1,
            'title' => $type,
            'description' => $company
        );
        EmergencyHistory::create($incident);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->verificationOfCompletedCompanies();
    }
}
