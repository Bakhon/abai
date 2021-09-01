<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Tech;
use Illuminate\Support\Facades\DB;

class ZuGzuProduction extends MeasurementLogForm
{

    protected $configurationFileName = 'zu_gzu_production';

    public function getRows(array $params = []): array
    {
        $gu = $this->getGU();
        $zus = $gu->children()
            ->whereHas('type', function ($query) {
                $query->whereIn('code', ['MS', 'GMS']);
            })
            ->get();

        $measurements = DB::connection('tbd')
            ->table('prod.meas_gzu_prod')
            ->whereIn('gzu', $zus->pluck('id')->toArray())
            ->get();

        $result = $zus->map(function ($zu) use ($measurements) {
            $measure = $measurements->where('gzu', $zu->id)->first();
            if (empty($measure)) {
                return $zu;
            }

            return $zu->merge($measure);
        });

        $this->addLimits($result);

        return [
            'rows' => $result->toArray()
        ];
    }

    private function getGU(): Tech
    {
        if ($this->request->get('type') !== 'tech') {
            throw new \Exception(trans('bd.select_gu'));
        }

        $gu = Tech::query()
            ->where('id', $this->request->get('id'))
            ->whereHas('type', function ($query) {
                $query->where('code', 'GU');
            })
            ->first();

        if (!$gu) {
            throw new \Exception(trans('bd.select_gu'));
        }

        return $gu;
    }

    protected function saveSingleFieldInDB(array $params): void
    {
    }

}