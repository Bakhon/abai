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
        $hours = 0;
        $dailyStatuses = $wellStatuses
            ->where('dbeg', '<=', $endOfDay)
            ->where('dend', '>=', $startOfDay)
            ->where('well', $wellId);

        foreach ($dailyStatuses as $status) {
            if ($status->dbeg <= $startOfDay && $status->dend >= $endOfDay) {
                $hours += 24;
            } elseif ($status->dbeg > $startOfDay) {
                $hours += round(
                    $status->dbeg->diffInMinutes($status->dend < $endOfDay ? $status->dend : $endOfDay) / 60
                );
            } elseif ($status->dend < $endOfDay) {
                $hours += round($startOfDay->diffInMinutes($status->dend) / 60);
            }
        }
        return min($hours, 24);
    }
}