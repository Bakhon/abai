<?php

namespace App\Imports;

use App\Models\EcoRefsBranchId;      
use App\Models\EcoRefsCompaniesId; 
use App\Models\EcoRefsDirectionId; 
use App\Models\EcoRefsRoutesId;
use App\Models\EcoRefsRouteTnId;      
use App\Models\EcoRefsExc;      
use App\Models\EcoRefsTarifyTn;                      
use App\Models\Refs\EcoRefsScFa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EcoRefsTarifyTnImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $scFaId;

    protected $companies = [];
    
    protected $branches = [];
    
    protected $directions = [];

    protected $routes = [];
    
    protected $route_tns = [];
    
    protected $excs = [];

    const CHUNK = 1000;

    const ORG_COLUMN = 'Компания:';

    const COLUMNS = [
        'branch_id' => 0,
        'company' => 1,
        'direction_id' => 2,
        'route_id' =>3,
        'route_tn_id' => 4,
        'exc_id' => 5,
        'date' => 6,
        'tn_rate' => 7
    ];

    function __construct(string $fileName)
    {
        $this->scFaId = EcoRefsScFa::firstOrCreate([
            'name' => $fileName,
        ])->id;
    }

    public function model(array $row): ?EcoRefsTarifyTn
    {
        if (!isset($row[self::COLUMNS['company']]) || ($row[self::COLUMNS['company']] === 'Компания:')) {
            return null;
        }
        
        $companyName = $row[self::COLUMNS['company']];

        $companyId = $this->companies[$companyName]
            ?? EcoRefsCompaniesId::query()
                ->whereName($companyName)
                ->firstOrFail()
                ->id;

        $this->companies[$companyName] = $companyId;

        $branchName = $row[self::COLUMNS['branch_id']];

        $branchId = $this->branches[$branchName]
            ?? EcoRefsBranchId::query()
                ->whereName($branchName)
                ->firstOrFail()
                ->id;

        $this->branches[$branchName] = $branchId;
        
        $directionName = $row[self::COLUMNS['direction_id']];

        $directionId = $this->directions[$directionName]
            ?? EcoRefsDirectionId::query()
                ->whereName($directionName)
                ->firstOrFail()
                ->id;

        $this->directions[$directionName] = $directionId;
        
        $routeName = $row[self::COLUMNS['route_id']];

        $routeId = $this->routes[$routeName]
            ?? EcoRefsRoutesId::query()
                ->whereName($routeName)
                ->firstOrFail()
                ->id;

        $this->routes[$routeName] = $routeId;
        
        $routetnName = $row[self::COLUMNS['route_tn_id']];

        $routetnId = $this->route_tns[$routetnName]
            ?? EcoRefsRouteTnId::query()
                ->whereName($routetnName)
                ->firstOrFail()
                ->id;

        $this->route_tns[$routetnName] = $routetnId;
       
        $excName = $row[self::COLUMNS['exc_id']];

        $excId = $this->excs[$excName]
            ?? EcoRefsExc::query()
                ->whereName($excName)
                ->firstOrFail()
                ->id;

        $this->excs[$excName] = $excId;

        return new EcoRefsTarifyTn([
            "sc_fa" => $this->scFaId,
            'company_id' =>  $companyId,
            'branch_id' =>  $branchId,
            "direction_id" => $directionId,
            "route_id" => $routeId,
            "route_tn_id" => $routetnId,
            "exc_id" => $excId,
            "date" => gmdate("Y-m-d", (($row[self::COLUMNS['date']]- 25569) * 86400)),
            "tn_rate" => round($row[self::COLUMNS['tn_rate']], 2),

        ]);
    }

    public function batchSize(): int
    {
        return self::CHUNK;
    }

    public function chunkSize(): int
    {
        return self::CHUNK;
    }
}
