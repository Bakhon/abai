<?php

namespace App\Helpers;

use App\Services\BigData\Forms\MeasurementLogForm;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WorktimeHelper
{
    public static function getWorkTime(array $wellIds, CarbonImmutable $dateFrom, CarbonImmutable $dateTo): array
    {
        $result = [];

        $wellStatuses = DB::connection('tbd')
            ->table('prod.well_status as s')
            ->select('s.status', 's.dbeg', 's.dend', 's.well')
            ->join('dict.well_status_type', 'dict.well_status_type.id', 's.status')
            ->where('dend', '>=', $dateFrom)
            ->where('dbeg', '<=', $dateTo)
            ->whereIn('well', $wellIds)
            ->whereIn('dict.well_status_type.code', MeasurementLogForm::WELL_ACTIVE_STATUSES)
            ->get()
            ->map(
                function ($item) {
                    $item->dbeg = Carbon::parse($item->dbeg, 'Asia/Almaty');
                    $item->dend = Carbon::parse($item->dend, 'Asia/Almaty');
                    return $item;
                }
            );

        $currentDate = $dateFrom;
        while ($currentDate <= $dateTo) {
            $startOfDay = $currentDate->startOfDay();
            $endOfDay = $currentDate->endOfDay();
            foreach ($wellIds as $wellId) {
                $result[$wellId][$currentDate->format('d.m.Y')] = self::getHoursForOneDay(
                        $wellStatuses,
                        $startOfDay,
                        $endOfDay,
                        $wellId
                    ) / 24;
            }

            $currentDate = $currentDate->addDay();
        }

        return $result;
    }

    public static function getHoursForOneDay(
        Collection $wellStatuses,
        CarbonImmutable $startOfDay,
        CarbonImmutable $endOfDay,
        $wellId
    ): int {
        $minutes = 0;
        $dailyStatuses = $wellStatuses
            ->where('dbeg', '<=', $endOfDay)
            ->where('dend', '>=', $startOfDay)
            ->where('well', $wellId);

        foreach ($dailyStatuses as $status) {
            if ($status->dbeg <= $startOfDay && $status->dend >= $endOfDay) {
                $minutes += 24 * 60;
            } elseif ($status->dbeg > $startOfDay) {
                $minutes +=
                    $status->dbeg->diffInMinutes(
                        $status->dend < $endOfDay ? $status->dend : $endOfDay
                    );
            } elseif ($status->dend < $endOfDay) {
                $minutes += $startOfDay->diffInMinutes($status->dend);
            }
        }
        $hours = round($minutes / 60);
        return min($hours, 24);
    }
}