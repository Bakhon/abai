<?php

namespace App\Helpers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class WorktimeHelper
{
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