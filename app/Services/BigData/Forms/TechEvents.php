<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\BigData\SubmitFormException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TechEvents extends PlainForm
{
    protected $configurationFileName = 'tech_events';

    public function submit(): array
    {
        DB::connection('tbd')->beginTransaction();
        try {
            $this->removeOldEvents();
            $this->addEvents();
            $this->updateEvents();

            DB::connection('tbd')->commit();
            return [];
        } catch (\Exception $e) {
            DB::connection('tbd')->rollBack();
            throw new SubmitFormException($e->getMessage());
        }
    }

    private function removeOldEvents(): void
    {
        $existedEventIds = DB::connection('tbd')
            ->table('prod.tech_mode_event')
            ->select('id')
            ->where('well', $this->request->well)
            ->get()
            ->pluck('id')
            ->toArray();

        if (empty($existedEventIds)) {
            return;
        }

        $eventsFromRequestIds = $this->getEventsToUpdate()
            ->pluck('id')
            ->toArray();

        foreach ($existedEventIds as $id) {
            if (in_array($id, $eventsFromRequestIds)) {
                continue;
            }

            DB::connection('tbd')
                ->table('prod.tech_mode_event')
                ->delete($id);
        }
    }

    private function getEventsToUpdate(): Collection
    {
        return collect($this->request->events)->filter(function ($event) {
            return !empty($event['id']);
        });
    }

    private function addEvents()
    {
        $events = $this->getEventsToAdd();
        foreach ($events as $event) {
            DB::connection('tbd')
                ->table('prod.tech_mode_event')
                ->insert(
                    [
                        'event_type' => $event['event_type'],
                        'plan_month' => $event['plan_month'],
                        'well' => $this->request->well
                    ]
                );
        }
    }

    private function getEventsToAdd(): Collection
    {
        return collect($this->request->events)->filter(function ($event) {
            return empty($event['id']);
        });
    }

    private function updateEvents(): void
    {
        $events = $this->getEventsToUpdate();
        foreach ($events as $event) {
            DB::connection('tbd')
                ->table('prod.tech_mode_event')
                ->where('id', $event['id'])
                ->update(
                    [
                        'event_type' => $event['event_type'],
                        'plan_month' => $event['plan_month']
                    ]
                );
        }
    }
}