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
        'Форма ввода' => array('КБМ','ОМГ','КТМ','ММГ','КОА','ЭМГ','УО'),
        'Парсинг неоперационных активов' => array('НКО','ПКИ','КПО','ТП','ПКК','ТШО','АГ'),
        'Интеграция Avoset' => array('КГМ')
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
        $incident = array (
            'date' => Carbon::now(),
            'type' => 1,
            'title' => 'Отсутствие суточных данных - ' . $type,
            'description' => 'Сегодня отсутствуют - ' . $company
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
