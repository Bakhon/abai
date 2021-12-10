<?php

namespace App\Imports;

use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Dictionaries\GtmKind;
use App\Models\BigData\Dictionaries\Org;
use App\Models\BigData\Dictionaries\Well;
use App\Models\Paegtm\GtmFactorAnalysis;
use Carbon\Carbon;
use ErrorException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PaegtmGtmFactorAnalysisImport implements ToModel, WithStartRow, WithBatchInserts, WithChunkReading, WithMultipleSheets
{
    const CHUNK = 100;

    const COLUMNS = [
        'org_name' => 1,
        'org_name_short' => 2,
        'uwi' => 3,
        'oilfield' => 4,
        'formation_index_before_gtm' => 5,
        'q_l_before_gtm' => 6,
        'q_o_before_gtm' => 7,
        'wct_before_gtm' => 8,
        'gtm' => 9,
        'gtm_date' => 10,
        'q_l_plan' => 11,
        'q_o_plan' => 12,
        'wct_plan' => 13,
        'formation_index_after_gtm' => 14,
        'q_l_after_gtm' => 15,
        'q_o_after_gtm' => 16,
        'wct_after_gtm' => 17,
        'q_l_deviation' => 18,
        'q_o_deviation' => 19,
        'failure_factor' => 20,
        'failure_reason' => 21,
        'status' => 22,
    ];

    private $_orgs;
    private $_geos;
    private $_gtm_kinds;
    private $_wells;

    public function __construct()
    {
        $this->_orgs = Org::all();
        $this->_geos = Geo::all();
        $this->_gtm_kinds = GtmKind::all();
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

        return new GtmFactorAnalysis([
            'org_id' => $org ? $org->id : null,
            'org_name' => $row[self::COLUMNS['org_name']],
            'org_name_short' => $row[self::COLUMNS['org_name_short']],

            'oilfield' => $row[self::COLUMNS['oilfield']],
            'geo_id' => $geo ? $geo->id : null,
            'uwi' => $row[self::COLUMNS['uwi']],
            'well' => $well,

            'formation_index_before_gtm' => $row[self::COLUMNS['formation_index_before_gtm']],
            'formation_index_after_gtm' => $row[self::COLUMNS['formation_index_after_gtm']],

            'q_l_before_gtm' => $row[self::COLUMNS['q_l_before_gtm']],
            'q_o_before_gtm' => $row[self::COLUMNS['q_o_before_gtm']],
            'wct_before_gtm' => $row[self::COLUMNS['wct_before_gtm']],

            'gtm' => $row[self::COLUMNS['gtm']],
            'gtm_kind_id' => $gtmKind ? $gtmKind->id : null,
            'gtm_date' => $row[self::COLUMNS['gtm_date']] ? Date::excelToDateTimeObject($row[self::COLUMNS['gtm_date']]) : null,

            'q_l_plan' => $row[self::COLUMNS['q_l_plan']],
            'q_o_plan' => $row[self::COLUMNS['q_o_plan']],
            'wct_plan' => $row[self::COLUMNS['wct_plan']],

            'q_l_after_gtm' => $row[self::COLUMNS['q_l_after_gtm']],
            'q_o_after_gtm' => $row[self::COLUMNS['q_o_after_gtm']],
            'wct_after_gtm' => $row[self::COLUMNS['wct_after_gtm']],

            'q_l_deviation' => $row[self::COLUMNS['q_l_deviation']],
            'q_o_deviation' => $row[self::COLUMNS['q_o_deviation']],

            'failure_factor' => $row[self::COLUMNS['failure_factor']],
            'failure_reason' => $row[self::COLUMNS['failure_reason']],

            'status' => $row[self::COLUMNS['status']]

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
        return 3;
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
