<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Tech;
use App\Services\BigData\StructureService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ZuGzuProduction extends TableForm
{

    protected $configurationFileName = 'zu_gzu_production';

    public function getResults(): array
    {
        $filter = json_decode($this->request->get('filter'));

        $guName = '';

        $tech = $this->getTech();
        if ($tech->type->code === 'GU') {
            $zus = $tech->children()
                ->where('dbeg', '<=', $filter->date)
                ->where('dend', '>=', $filter->date)
                ->whereHas('type', function ($query) {
                    $query->whereIn('code', ['MS', 'GMS']);
                })
                ->get();
            $guName = $tech->name_ru;
        } else {
            $parent = $tech->parentItem;
            if ($parent && $parent->type->code === 'GU') {
                $guName = $parent->name_ru;
            }

            $zus = collect([$tech]);
        }

        $measurements = DB::connection('tbd')
            ->table('prod.meas_gzu_prod')
            ->where('meas_date', $filter->date)
            ->whereIn('gzu', $zus->pluck('id')->toArray())
            ->get();

        $fields = $this->getFields();

        $result = collect([]);
        foreach ($zus as $zu) {
            $row = [
                'id' => $zu->id
            ];

            $measure = $measurements->where('gzu', $zu->id)->first();

            foreach ($fields as $field) {
                if (isset($field['table']) && $field['table'] === 'prod.meas_gzu_prod') {
                    $value = $measure ? $measure->{$field['code']} : null;
                    if ($field['type'] === 'copy') {
                        $value = (bool)$value;
                    }
                    $row[$field['code']] = [
                        'value' => $value
                    ];
                    continue;
                }

                $row['gu'] = ['value' => $guName];
                $row['zu_gzu'] = ['value' => $zu->name_ru];

                $structureService = app()->make(StructureService::class);
                $path = $structureService->getPath($tech->id, 'tech');
                $pf = $path->where('sub_type', 'SUBC')->first();
                $ngdu = $path->where('sub_type', 'FOFS')->first();
                $cdng = $path->where('sub_type', 'OGPU')->first();

                $row['pf'] = ['value' => $pf ? $pf['name'] : null];
                $row['ngdu'] = ['value' => $ngdu ? $ngdu['name'] : null];
                $row['cdng'] = ['value' => $cdng ? $cdng['name'] : null];
            }

            $result->push($row);
        }

        $this->addLimits($result);

        return [
            'rows' => $result->toArray()
        ];
    }

    private function getTech(): Tech
    {
        if ($this->request->get('type') !== 'tech') {
            throw new \Exception(trans('bd.select_gu'));
        }

        /** @var Tech $gu */
        $gu = Tech::query()
            ->where('id', $this->request->get('id'))
            ->whereHas('type', function ($query) {
                $query->whereIn('code', ['GU', 'GMS', 'MS']);
            })
            ->first();

        if (!$gu) {
            throw new \Exception(trans('bd.select_gu'));
        }

        return $gu;
    }

    protected function saveSingleFieldInDB(array $params): void
    {
        $measurement = DB::connection('tbd')
            ->table('prod.meas_gzu_prod')
            ->where('meas_date', $this->request->get('date'))
            ->where('gzu', $params['wellId'])
            ->first();

        if (empty($measurement)) {
            DB::connection('tbd')
                ->table('prod.meas_gzu_prod')
                ->insert([
                             'gzu' => $params['wellId'],
                             'meas_date' => $this->request->get('date'),
                             $params['field'] => $params['value']
                         ]);
            return;
        }

        DB::connection('tbd')
            ->table('prod.meas_gzu_prod')
            ->where('id', $measurement->id)
            ->update([
                         $params['field'] => $params['value']
                     ]);
    }

    public function copyFieldValue(int $zuId, Carbon $date)
    {
        $column = $this->getFieldByCode($this->request->get('column'));
        $columnFrom = $this->getFieldByCode($column['copy']['from']);
        $columnTo = $this->getFieldByCode($column['copy']['to']);

        $measurement = DB::connection('tbd')
            ->table('prod.meas_gzu_prod')
            ->where('meas_date', $date)
            ->where('gzu', $zuId)
            ->first();

        $value = $measurement->{$columnFrom['column']};

        DB::connection('tbd')
            ->table('prod.meas_gzu_prod')
            ->where('id', $measurement->id)
            ->update(
                [
                    $columnTo['column'] => $value,
                    $column['column'] => true
                ]
            );

        return [];
    }
}