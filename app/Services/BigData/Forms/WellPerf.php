<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\PerfType;
use App\Models\BigData\Well;
use App\Models\BigData\WellPerf as WellPerfModel;
use App\Traits\BigData\Forms\WithDocumentsUpload;
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
            ->get();

        $actualIntervals = DB::connection('tbd')
            ->table('prod.well_perf_actual')
            ->selectRaw('id, well_perf, geo, top::REAL, base::REAL')
            ->whereIn('well_perf', $wellPerfIds)
            ->orderBy('top')
            ->get();

        return $wellPerforations->map(function ($perf) use ($intervals, $actualIntervals) {
            $perf->intervals = [
                'value' => $intervals->where('well_perf', $perf->id)->values(),
                'formated_value' => $this->formatIntervals($intervals->where('well_perf', $perf->id))
            ];

            $perf->actual_intervals = [
                'value' => $actualIntervals->where('well_perf', $perf->id),
                'formated_value' => $this->formatIntervals($actualIntervals->where('well_perf', $perf->id))
            ];

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
                if (isset($data['id'])) {
                    DB::connection('tbd')
                        ->table($field['table'])
                        ->where('id', $data['id'])
                        ->update($data);
                    $ids[] = $data['id'];
                } else {
                    $ids[] = DB::connection('tbd')->table($field['table'])->insertGetId($data);
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

    protected function afterSubmit(int $wellPerfId)
    {
        $actualIntervals = $this->getActualIntervals($wellPerfId);

        DB::connection('tbd')
            ->table('prod.well_perf_actual')
            ->selectRaw('id, well_perf, geo, top::REAL, base::REAL')
            ->where('well_perf', $wellPerfId)
            ->delete();

        foreach ($actualIntervals as $interval) {
            DB::connection('tbd')
                ->table('prod.well_perf_actual')
                ->insert(
                    [
                        'well_perf' => $wellPerfId,
                        'top' => $interval->top,
                        'base' => $interval->base,
                        'geo' => $interval->geo
                    ]
                );
        }
    }

    private function getActualIntervals(int $wellPerfId)
    {
        $wellPerf = WellPerfModel::find($wellPerfId);

        $currentIntervals = DB::connection('tbd')
            ->table('prod.well_perf_interval as wpi')
            ->selectRaw(
                'wpi.id, wp.well, wpi.well_perf, wpi.geo, wpi.top::REAL, wpi.base::REAL, wp.perf_type, wp.perf_date, wp.depth'
            )
            ->join('prod.well_perf as wp', 'wpi.well_perf', 'wp.id')
            ->where('wp.well', $this->request->get('well'))
            ->where('wp.perf_date', '<=', $wellPerf->perf_date)
            ->orderBy('wpi.top')
            ->get();

        $maxDepth = $currentIntervals
            ->where('perf_type', PerfType::EXPLOSIVE_PACKER_ID)
            ->max('depth');

        if ($maxDepth) {
            $currentIntervals = $currentIntervals->where('top', '<', $maxDepth);
        }
        $isolatedIntervals = $this->getIsolatedIntervals($currentIntervals);

        return $currentIntervals
            ->filter(function ($interval) use ($isolatedIntervals, $currentIntervals) {
                $intervalsToCompare = $currentIntervals->merge($isolatedIntervals)
                    ->where('id', '!=', $interval->id)
                    ->where('perf_date', '<=', $interval->perf_date);

                foreach ($intervalsToCompare as $intervalToCompare) {
                    if ($intervalToCompare->base <= $interval->base && $intervalToCompare->top >= $interval->top) {
                        return false;
                    }
                }
                return true;
            })
            ->sortBy('top');
    }

    private function getIsolatedIntervals(Collection $intervals)
    {
        return $intervals->where('perf_type', PerfType::ISOLATION_ID);
    }
}