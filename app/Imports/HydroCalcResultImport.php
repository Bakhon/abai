<?php

namespace App\Imports;

use App\Models\ComplicationMonitoring\HydroCalcResult;
use App\Models\ComplicationMonitoring\TrunklinePoint;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class HydroCalcResultImport implements ToCollection, WithStartRow
{
    protected $date;

    const ID = 0;
    const LENGTH = 3;
    const QLIQ = 4;
    const BSW = 5;
    const GAZF = 6;
    const PRESS_START = 7;
    const PRESS_END = 8;
    const TEMPERATURE_START = 9;
    const TEMPERATURE_END = 10;
    const START_POINT = 11;
    const END_POINT = 12;
    const MIX_SPEED_AVERAGE = 14;
    const FLUID_SPEED = 15;
    const GAS_SPEED = 16;
    const FLOW_TYPE = 17;
    const PRESS_CHANGE = 18;
    const BREAK_QTY = 19;
    const HEIGHT_DROP = 20;

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) {
            $trunkline_point = TrunklinePoint::find($row[self::ID]);

            $hydroCalcResult = HydroCalcResult::firstOrCreate(
                [
                    'date' => Carbon::parse($this->date)->format('Y-m-d'),
                    'trunkline_point_id' => $trunkline_point->id,
                ]
            );

            $hydroCalcResult->length = $row[self::LENGTH];
            $hydroCalcResult->qliq = $row[self::QLIQ];
            $hydroCalcResult->bsw = $row[self::BSW];
            $hydroCalcResult->gazf = $row[self::GAZF];
            $hydroCalcResult->press_start = $row[self::PRESS_START];
            $hydroCalcResult->press_end = $row[self::PRESS_END];
            $hydroCalcResult->temperature_start = $row[self::TEMPERATURE_START];
            $hydroCalcResult->temperature_end = $row[self::TEMPERATURE_END];
            $hydroCalcResult->start_point = $row[self::START_POINT];
            $hydroCalcResult->end_point = $row[self::END_POINT];
            $hydroCalcResult->map_pipe_id = $trunkline_point->map_pipe_id;
            $hydroCalcResult->mix_speed_avg = $row[self::MIX_SPEED_AVERAGE];
            $hydroCalcResult->fluid_speed = $row[self::FLUID_SPEED];
            $hydroCalcResult->gaz_speed = $row[self::GAS_SPEED];
            $hydroCalcResult->flow_type = $row[self::FLOW_TYPE];
            $hydroCalcResult->press_change = $row[self::PRESS_CHANGE];
            $hydroCalcResult->break_qty = $row[self::BREAK_QTY];
            $hydroCalcResult->height_drop = $row[self::HEIGHT_DROP];
            $hydroCalcResult->save();

        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
