<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\EmergencyHistory;

class EmergencySituations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-emergency:cron';
    protected $allCompanies = array('КГМ','КБМ','ОМГ','КТМ','НКО','ПКИ','КПО','ТП','ПКК','ТШО','АГ','ММГ','КОА','ЭМГ','УО');
    protected $typeMapping = array(
        'Не заполнена форма ввода' => array('КБМ','ОМГ','КТМ','ММГ','КОА','ЭМГ','УО'),
        'Не сработал парсер отчета ИАЦНГ' => array('НКО','ПКИ','КПО','ТП','ПКК','ТШО','АГ'),
        'Не сработал программный код Avocet' => array('КГМ')
    );
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create records on incident situations';

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
        $todayCompanies = $this->getCompletedCompanies();
        $dzoKey = array_search('КГМ', array_column($todayCompanies, 'dzo_name'));
        if ($dzoKey) {
            $isFilledCorrectly = $this->isDzoFilledCorrectly($todayCompanies[$dzoKey]['dzo_name']);
            if ($isFilledCorrectly) {
                unset($todayCompanies[$dzoKey]);
            }
        }

        if (count($todayCompanies) !== 15) {
            $this->createIncidents($todayCompanies);
        }

    }
    private function getCompletedCompanies()
    {
        $startDay = Carbon::yesterday()->startOfDay();
        $endDay = $startDay->copy()->endOfDay();
        return DzoImportData::query()
            ->select('dzo_name')
            ->whereDate('date', '>=', $startDay)
            ->whereDate('date', '<=', $endDay)
            ->get()
            ->toArray();
    }
    private function createIncidents($existingCompanies)
    {
        $companyDifference = $this->getDifference($existingCompanies);
        foreach($companyDifference as $company) {
            $key = $this->getKey($company,$this->typeMapping);
            $this->store($company,$key);
        }
    }
    private function getDifference($existingCompanies)
    {
        $companies = array();
        foreach($existingCompanies as $company) {
            $companies[] = $company['dzo_name'];
        }
       return array_diff($this->allCompanies,$companies);
    }
    private function getKey($id, $array) {
        foreach ($array as $key => $val) {
            $elementKey = array_search($id, $val);
            if (is_numeric($elementKey)) {
                return $key;
            }
        }
        return null;
    }
    private function store($company,$type)
    {
        if ($company === 'ПКК') {
            $company = 'ПККР';
        }
        $incident = array (
            'date' => Carbon::now(),
            'type' => 1,
            'title' => $type,
            'description' => $company
        );
        EmergencyHistory::create($incident);
    }
    private function isDzoFilledCorrectly($dzo)
    {
        $startDay = Carbon::yesterday()->startOfDay();
        $endDay = $startDay->copy()->endOfDay();
        $record = DzoImportData::query()
            ->select('oil_production_fact')
            ->where('dzo_name',$dzo)
            ->whereDate('date', '>=', $startDay)
            ->whereDate('date', '<=', $endDay)
            ->first();
        return !is_null($record) && $record->oil_production_fact > 0;
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
