<?php

namespace App\Imports;

use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\GtmType;
use App\Models\BigData\Dictionaries\Org;
use App\Models\Paegtm\EcoRefs\GtmFactCost;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PaegtmRefsGtmFactCostsImport implements ToModel, WithBatchInserts, WithChunkReading, WithStartRow
{
    const CHUNK = 100;

    const COLUMNS = [
        'dzo_name' => 0,
        'dzo_name_short' => 1,
        'oilfield' => 2,
        'well_name' => 3,
        'gtm_name' => 4,
        'gtm_date' => 5,
        'price' => 6,

    ];

    private $_orgs;
    private $_geos;
    private $_gtm_kinds;

    public function __construct()
    {
        $this->_orgs = Org::all();
        $this->_geos = Geo::all();
        $this->_gtm_kinds = GtmType::all();
    }

    public function model(array $row): ?GtmFactCost
    {
        $dzoNameShort = $row[self::COLUMNS['dzo_name_short']];
        $oilFieldName = $row[self::COLUMNS['oilfield']];
        $gtmKindName = $row[self::COLUMNS['gtm_name']];

        $org = $this->_orgs->where('name_short_ru', $dzoNameShort)->first();
        $geo = $this->_geos->where('name_ru', $oilFieldName)->first();
        $gtmKind = $this->_gtm_kinds->where('name_short_ru', $gtmKindName)->first();

        return new GtmFactCost([
            'org_id' => $org ? $org->id : null,
            'dzo_name' => $row[self::COLUMNS['dzo_name']],
            'dzo_name_short' => $row[self::COLUMNS['dzo_name_short']],
            'oilfield' => $row[self::COLUMNS['oilfield']],
            'geo_id' => $geo ? $geo->id : null,
            'well_name' => $row[self::COLUMNS['well_name']],
            'gtm_type_id' => $gtmKind ? $gtmKind->id : null,
            'gtm_name' => $row[self::COLUMNS['gtm_name']],
            'gtm_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[self::COLUMNS['gtm_date']]),
            'price' => $row[self::COLUMNS['price']],
        ]);
    }

    public function transformDate($value, $format = 'd.m.Y')
    {
        if (empty($value)) {
            return null;
        }

        try {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return Carbon::createFromFormat($format, $value);
        }
    }

    public function batchSize(): int
    {
        return self::CHUNK;
    }

    public function chunkSize(): int
    {
        return self::CHUNK;
    }

    public function startRow(): int
    {
        return 2;
    }
}
