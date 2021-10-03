<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\PerfType;
use App\Models\BigData\Well;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WellPerf extends PlainForm
{
    protected $configurationFileName = 'well_perf';

    public function getFormByRow(array $row): array
    {
        $form = 'well_perf_other';
        switch ($row['perf_type']) {
            case 1:
            case 3:
            case 4:
            case 5:
            case 6:
                $form = 'well_perf_shot';
                break;
            case 13:
                $form = 'well_perf_drill_packer';
                break;
            case 12:
                $form = 'well_perf_stab';
                break;
            case 7:
                $form = 'well_perf_bridge_plug';
                break;
            case 8:
                $form = 'well_document_short';
                break;    
        }
        return ['form' => $form];
    }

    protected function formatRows(Collection $wellPerforations): Collection
    {
        $wellPerforations = parent::formatRows($wellPerforations);

        $wellPerfIds = $wellPerforations->pluck('id')->toArray();

        $intervals = DB::connection('tbd')
            ->table('prod.well_perf_interval')
            ->whereIn('well_perf', $wellPerfIds)
            ->orderBy('top')
            ->get()
            ->map(function ($interval) {
                $interval->dbeg = Carbon::parse($interval->dbeg, 'Asia/Almaty');
                return $interval;
            });

        return $wellPerforations->map(function ($perf) use ($wellPerforations, $intervals) {
            $perf->intervals = $this->formatIntervals($intervals->where('well_perf', $perf->id));

            $actualIntervals = $this->getActiveIntervals($perf, $wellPerforations, $intervals);
            $perf->actual_intervals = $this->formatIntervals($actualIntervals);

            $perf->well = $actualIntervals->map(function ($interval) {
                return $interval->base - $interval->top;
            })->sum();

            return $perf;
        });
    }

    private function formatIntervals(Collection $intervals)
    {
        return $intervals
            ->map(function ($interval) {
                return (float)$interval->top . ' - ' . (float)$interval->base . ';';
            })
            ->unique()
            ->join('<br>');
    }

    private function getActiveIntervals(\stdClass $perf, Collection $wellPerforations, Collection $intervals)
    {
        $perfDate = Carbon::parse($perf->perf_date, 'Asia/Almaty')->endOfDay();
        $currentIntervals = $intervals->where('dbeg', '<=', $perfDate)
            ->sortBy('dbeg');

        $maxDepth = $wellPerforations
            ->where('perf_type', PerfType::EXPLOSIVE_PACKER_ID)
            ->where('perf_date', '<=', $perfDate)
            ->max('depth');
        if ($maxDepth) {
            $currentIntervals = $currentIntervals->where('top', '>', $maxDepth);
        }
        $isolatedIntervals = $this->getIsolatedIntervals($wellPerforations, $currentIntervals);
        return $currentIntervals
            ->filter(function ($interval) use ($isolatedIntervals) {
                foreach ($isolatedIntervals as $isolatedInterval) {
                    if ($isolatedInterval->top <= $interval->top && $isolatedInterval->base >= $interval->base) {
                        return false;
                    }
                }
                return true;
            })
            ->sortBy('top');
    }

    private function getIsolatedIntervals(Collection $wellPerforations, Collection $intervals)
    {
        $isolatedPerforationIds = $wellPerforations->where('perf_type', PerfType::ISOLATION_ID)->pluck('id')->toArray();
        return $intervals->whereIn('well_perf', $isolatedPerforationIds);
    }

    protected function insertInnerTable(int $id)
    {
        if (!empty($this->tableFields)) {
            foreach ($this->tableFields as $field) {
                if (!empty($this->request->get($field['code']))) {
                    $this->submittedData['table_fields'][$field['code']] = [];
                    foreach ($this->request->get($field['code']) as $data) {
                        $data[$field['parent_column']] = $id;
                        $data['dbeg'] = $this->request->get('perf_date');
                        $data['dend'] = Well::DEFAULT_END_DATE;
                        $this->submittedData['table_fields'][$field['code']][] = $data;
                        DB::connection('tbd')->table($field['table'])->insert($data);
                    }
                }
            }
        }
    }
}