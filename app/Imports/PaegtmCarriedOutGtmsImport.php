<?php

namespace App\Imports;

use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\GtmType;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Well;
use App\Models\Paegtm\CarriedOutGtm;
use Carbon\Carbon;
use ErrorException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PaegtmCarriedOutGtmsImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading, WithMultipleSheets
{
    const CHUNK = 100;

    const COLUMNS = [
        'org_name_short' => 0,
        'oilfield' => 1,
        'uwi' => 3,
        'date_stop_before_gtm' => 4,
        'date_start_after_gtm' => 5,
        'gtm' => 6,
        'planned_increase' => 7,
    ];

    private $_orgs;
    private $_geos;
    private $_gtm_kinds;
    private $_wells;

    public function __construct()
    {
        $this->_orgs = Org::all();
        $this->_geos = Geo::all();
        $this->_gtm_kinds = GtmType::all();
        $this->_wells = Well::select('id','uwi')->get()->mapWithKeys(function ($item) {
            return [$item['uwi'] => $item['id']];
        })->toArray();
    }

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $dzoNameShort = $row[self::COLUMNS['org_name_short']];
        $gtmKindName = $row[self::COLUMNS['gtm']];
        $geoCode = $row[self::COLUMNS['oilfield']];
        $uwi = $row[self::COLUMNS['uwi']];

        $org = $this->_orgs->where('name_short_ru', $dzoNameShort)->first();
        $gtmKind = $this->_gtm_kinds->where('name_short_ru', $gtmKindName)->first();
        $geo = $this->_geos->where('field_code', $geoCode)->first();
        $well = $this->_wells[$uwi] ?? null;

        return new CarriedOutGtm([
            'org_id' => $org ? $org->id : null,
            'org_name_short' => $row[self::COLUMNS['org_name_short']],
            'oilfield' => $row[self::COLUMNS['oilfield']],
            'geo_id' => $geo ? $geo->id : null,
            'uwi' => $row[self::COLUMNS['uwi']],
            'well' => $well,
            'date_stop_before_gtm' => Date::excelToDateTimeObject($row[self::COLUMNS['date_stop_before_gtm']]),
            'date_start_after_gtm' => Date::excelToDateTimeObject($row[self::COLUMNS['date_start_after_gtm']]),
            'gtm' => $row[self::COLUMNS['gtm']],
            'gtm_type_id' => $gtmKind ? $gtmKind->id : null,
            'planned_increase' => $row[self::COLUMNS['planned_increase']],
        ]);
    }

    public function transformDate($value, $format = 'd.m.Y')
    {
        if (empty($value)) {
            return null;
        }

        try {
            return Carbon::instance(Date::excelToDateTimeObject($value));
        } catch (ErrorException $e) {
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

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
}
