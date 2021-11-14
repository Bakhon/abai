<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\PerfType;
use App\Models\BigData\Well;
use App\Traits\BigData\Forms\WithDocumentsUpload;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WellPerf extends PlainForm
{
    protected $configurationFileName = 'well_perf';

    use WithDocumentsUpload;

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
            case 2:
                $form = 'well_perf_lagging';
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
            case 20:
            case 21:
            case 22:
            case 23:
                $form = 'well_perf_other';
                break;
        }
        return ['form' => $form];
    }

    protected function getRows(): Collection
    {
        $rows = parent::getRows();

        if (!empty($rows)) {
            $rows = $this->attachDocuments($rows);
        }

        return $rows;
    }

    protected function formatRows(Collection $wellPerforations): Collection
    {
        $wellPerforations = parent::formatRows($wellPerforations);

        $wellPerfIds = $wellPerforations->pluck('id')->toArray();

        $intervals = DB::connection('tbd')
            ->table('prod.well_perf_interval')
            ->selectRaw('id, well_perf, geo, top::REAL, base::REAL')
            ->whereIn('well_perf', $wellPerfIds)
            ->orderBy('top')
            ->get()
            ->map(function ($interval) {
                return $interval;
            });

        return $wellPerforations->map(function ($perf) use ($wellPerforations, $intervals) {
            $perf->intervals = [
                'value' => $intervals->where('well_perf', $perf->id),
                'formated_value' => $this->formatIntervals($intervals->where('well_perf', $perf->id))
            ];

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
            $currentIntervals = $currentIntervals->where('top', '<', $maxDepth);
        }
        $isolatedIntervals = $this->getIsolatedIntervals($wellPerforations, $currentIntervals);

        return $currentIntervals
            ->filter(function ($interval) use ($wellPerforations, $isolatedIntervals, $currentIntervals) {
                $perfDate = $wellPerforations->where('id', $interval->well_perf)->first()->perf_date;
                $intervalsToCompare = $currentIntervals->merge($isolatedIntervals)
                    ->where('id', '!=', $interval->id)
                    ->where('perf_date', '<=', $perfDate);

                foreach ($intervalsToCompare as $intervalToCompare) {
                    if ($intervalToCompare->base <= $interval->base && $intervalToCompare->top >= $interval->top) {
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

    protected function submitInnerTable(int $parentId)
    {
        if (empty($this->tableFields)) {
            return;
        }

        foreach ($this->tableFields as $field) {
            if (empty($this->request->get($field['code']))) {
                continue;
            }
            if ($field['code'] === 'documents') {
                $this->submitFiles($parentId, $field);
                continue;
            }

            $this->submittedData['table_fields'][$field['code']] = [];
            if (!is_array($this->request->get($field['code']))) {
                continue;
            }

            $ids = [];
            foreach ($this->request->get($field['code']) as $data) {
                $data[$field['parent_column']] = $parentId;
                $data['dbeg'] = $this->request->get('perf_date');
                $data['dend'] = Well::DEFAULT_END_DATE;
                $this->submittedData['table_fields'][$field['code']][] = $data;
                if ($data['id']) {
                    DB::connection('tbd')
                        ->table($field['table'])
                        ->where('id', $data['id'])
                        ->update($data);
                    $ids[] = $data['id'];
                } else {
                    DB::connection('tbd')->table($field['table'])->insert($data);
                }
            }

            DB::connection('tbd')
                ->table($field['table'])
                ->where($field['parent_column'], $parentId)
                ->whereNotIn('id', $ids)
                ->delete();
        }
    }

    protected function prepareDataToSubmit()
    {
        $data = parent::prepareDataToSubmit();
        $data = array_filter(
            $data,
            function ($key) {
                return !in_array($key, ['documents']);
            },
            ARRAY_FILTER_USE_KEY
        );
        if (array_key_exists('actual_intervals', $data)) {
            unset($data['actual_intervals']);
        }
        return $data;
    }
}