<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class MeasLogByMonth extends TableForm
{
    public function getResults(array $params = []): array
    {
        $filter = json_decode($this->request->get('filter'));
        $date = Carbon::parse($filter->date)->timezone('Asia/Almaty')->toImmutable();

        $wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

        $rows = $this->getRows($date, $wells);
        $columns = $this->getColumns($date);

        return [
            'columns' => $columns,
            'rows' => $rows
        ];
    }

    protected function getWorkTime(array $wellIds, CarbonImmutable $date): array
    {
        $result = [];

        $wellStatuses = DB::connection('tbd')
            ->table('prod.well_status as s')
            ->select('s.status', 's.dbeg', 's.dend', 's.well')
            ->join('dict.well_status_type', 'dict.well_status_type.id', 's.status')
            ->where('dbeg', '<=', $date->startOfMonth())
            ->where('dend', '>=', $date)
            ->whereIn('well', $wellIds)
            ->whereIn('dict.well_status_type.code', MeasurementLogForm::WELL_ACTIVE_STATUSES)
            ->get()
            ->map(
                function ($item) {
                    $item->dbeg = Carbon::parse($item->dbeg);
                    $item->dend = Carbon::parse($item->dend);
                    return $item;
                }
            );

        $monthDay = $date->startOfMonth();
        while ($monthDay < $date) {
            $startOfDay = $monthDay->startOfDay();
            $endOfDay = $monthDay->endOfDay();
            foreach ($wellIds as $wellId) {
                $result[$wellId][$monthDay->format('j')] = [
                    'value' => $this->getHoursForOneDay($wellStatuses, $endOfDay, $startOfDay, $wellId)
                ];
            }

            $monthDay = $monthDay->addDay();
        }

        return $result;
    }

    private function getHoursForOneDay(
        Collection $wellStatuses,
        CarbonImmutable $endOfDay,
        CarbonImmutable $startOfDay,
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
                $hours += $status->dbeg->diffInHours($status->dend < $endOfDay ? $status->dend : $endOfDay);
            } elseif ($status->dend < $endOfDay) {
                $hours += $startOfDay->diffInHours($status->dend);
            }
        }
        return $hours;
    }

    private function getTechMode(array $wellIds, CarbonImmutable $date): Collection
    {
        return DB::connection('tbd')
            ->table('prod.tech_mode_inj')
            ->whereIn('well', $wellIds)
            ->where('dbeg', '>=', $date->startOfMonth())
            ->where('dend', '<=', $date->endOfMonth())
            ->get()
            ->groupBy('well')
            ->map(function ($items) {
                return $items->first();
            });
    }

}