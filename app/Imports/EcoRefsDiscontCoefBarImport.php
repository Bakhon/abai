<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\EcoRefsCompaniesId; 
use App\Models\EcoRefsDirectionId; 
use App\Models\EcoRefsRoutesId; 
use App\Models\EcoRefsDiscontCoefBar;                      // Here
use App\Models\Refs\EcoRefsScFa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EcoRefsDiscontCoefBarImport implements ToModel, WithBatchInserts, WithChunkReading
{
    protected $scFaId;

    protected $companies = [];
    
    protected $directions = [];

    protected $routes = [];

    const CHUNK = 1000;

    const ORG_COLUMN = 'Компания:';

    const COLUMNS = [
        // 'sc_fa' => 0,
        'company_id' => 0,
        'direction_id' => 1,
        'route_id' => 2,
        'date' => 3,
        'barr_coef' => 4,
        'discont' => 5,
        'macro' => 6
    ];

    function __construct(string $fileName)
    {
        $this->scFaId = EcoRefsScFa::firstOrCreate([
            'name' => $fileName,
        ])->id;
    }

    public function model(array $row): ?EcoRefsDiscontCoefBar
    {
        if (!isset($row[self::COLUMNS['company_id']]) || ($row[self::COLUMNS['company_id']] === 'Компания:')) {
            return null;
        }
        
        $companyName = $row[self::COLUMNS['company_id']];

        $companyId = $this->companies[$companyName]
            ?? EcoRefsCompaniesId::query()
                ->whereName($companyName)
                ->firstOrFail()
                ->id;

        $this->companies[$companyName] = $companyId;
        
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

        return new EcoRefsDiscontCoefBar([
            "sc_fa" => $this->scFaId,
            'company_id' =>  $companyId,
            "direction_id" => $directionId,
            "route_id" => $routeId,
            "date" => gmdate("Y-m-d", (($row[3]- 25569) * 86400)),
            "barr_coef" => round($row[4], 2),
            "discont" => round($row[5], 2),
            "macro" => round($row[6], 2),

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
