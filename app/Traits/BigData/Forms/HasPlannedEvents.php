<?php

namespace App\Traits\BigData\Forms;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait HasPlannedEvents
{
    protected function submitInnerTable(int $parentId)
    {
        $this->innerTableService->submitTables($this->request->get('well'), $this->tableFields);
    }

    protected function getRows(): Collection
    {
        $rows = parent::getRows();
        $wellIds = $rows->pluck('well')->toArray();
        if (empty($wellIds)) {
            return $rows;
        }

        $events = DB::connection('tbd')
            ->table('prod.tech_mode_event as tme')
            ->select('tme.*', 'wa.name_ru as event_type_name')
            ->join('dict.well_activity as wa', 'tme.event_type', 'wa.id')
            ->whereIn('well', $wellIds)
            ->get()
            ->map(function ($item) {
                $item->event_type = [
                    'value' => $item->event_type,
                    'text' => $item->event_type_name
                ];
                return $item;
            })
            ->groupBy('well');

        return $rows->map(function ($row) use ($events) {
            $row->events = $events->get($row->well);
            return $row;
        });
    }
}