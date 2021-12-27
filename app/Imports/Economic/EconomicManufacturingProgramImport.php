<?php

namespace App\Imports\Economic;

use App\Models\EcoRefsCompaniesId;
use App\Models\Refs\EconomicDataLog;
use App\Models\Refs\EconomicDataLogType;
use App\Models\Refs\EcoRefsManufacturingProgram;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EconomicManufacturingProgramImport implements ToModel, WithStartRow, WithLimit
{
    protected $userId;

    protected $logId;

    protected $companyIds = [];

    const COLUMNS = [
        'company_id' => ['index' => 0, 'is_relation' => true],
        'dollar_rate' => ['index' => 1],
        'oil_price' => ['index' => 2],
        'oil' => ['index' => 3],
        'oil_from_transfer_wells' => ['index' => 4],
        'oil_from_new_wells' => ['index' => 5],
        'oil_from_gtm' => ['index' => 6],
        'oil_sale' => ['index' => 7],
        'oil_sale_export' => ['index' => 8],
        'oil_sale_local' => ['index' => 9],
        'wells' => ['index' => 10, 'is_int' => true],
        'transfer_wells' => ['index' => 11, 'is_int' => true],
        'new_wells' => ['index' => 12, 'is_int' => true],
        'prs' => ['index' => 13, 'is_int' => true],
        'brigade_prs' => ['index' => 14, 'is_int' => true],
        'krs' => ['index' => 15, 'is_int' => true],
        'pp' => ['index' => 16, 'is_int' => true],
        'aup' => ['index' => 17, 'is_int' => true],
        'revenue' => ['index' => 18],
        'expenditures' => ['index' => 19],
        'cost_price' => ['index' => 20],
        'cost_price_variable' => ['index' => 21],
        'cost_price_staff' => ['index' => 22],
        'cost_price_ndpi' => ['index' => 23],
        'cost_price_permanent' => ['index' => 24],
        'cost_price_amort' => ['index' => 25],
        'realization_cost' => ['index' => 26],
        'realization_cost_rent_tax' => ['index' => 27],
        'realization_cost_etp' => ['index' => 28],
        'realization_cost_trans_expenditures' => ['index' => 29],
        'oar_financing_expenditures' => ['index' => 30],
        'revenue_before_tax' => ['index' => 31],
        'kpn' => ['index' => 32],
        'ept' => ['index' => 33],
        'operating_profit' => ['index' => 34],
        'capital_investment' => ['index' => 35],
        'capital_investment_drilling' => ['index' => 36],
        'capital_investment_os' => ['index' => 37],
        'capital_investment_building' => ['index' => 38],
        'capital_investment_other' => ['index' => 39],
        'cash_flow' => ['index' => 40],
    ];

    function __construct(int $userId, string $fileName)
    {
        $this->userId = $userId;

        $this->logId = EconomicDataLog::create([
            'name' => $fileName,
            'type_id' => EconomicDataLogType::MANUFACTURING_PROGRAM,
            'author_id' => $userId
        ])->id;
    }

    public function model(array $row): EcoRefsManufacturingProgram
    {
        $params = [
            'user_id' => $this->userId,
            'log_id' => $this->logId,
            'company_id' => $this->getCompanyId($row)
        ];

        foreach (self::COLUMNS as $key => $column) {
            if (isset($column['is_relation'])) continue;

            $params[$key] = isset($column['is_int'])
                ? (int)$row[$column['index']]
                : round($row[$column['index']], 10);
        }

        return new EcoRefsManufacturingProgram($params);
    }

    public function startRow(): int
    {
        return 5;
    }

    public function limit(): int
    {
        return 1;
    }

    private function getCompanyId(array $row): int
    {
        $name = $row[self::COLUMNS['company_id']['index']];

        if (isset($this->companyIds[$name])) {
            return $this->companyIds[$name];
        }

        $this->companyIds[$name] = EcoRefsCompaniesId::query()
            ->whereName($name)
            ->firstOrFail()
            ->id;

        return $this->companyIds[$name];
    }
}
