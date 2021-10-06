<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Tech;
use App\Services\BigData\StructureService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ZuGzuProduction extends TableForm
{
    const KTM_ORG_ID = 173;
    protected $configurationFileName = 'zu_gzu_production';
    protected $formType = 'default';

    public function getResults(): array
    {
        $filter = json_decode($this->request->get('filter'));

        $structureTree = $this->getStructureTree();

        $dzo = $this->getDzo($structureTree);
        if ($dzo['id'] === self::KTM_ORG_ID) {
            $this->formType = 'ktm';
        }

        $techs = $this->getTechs($structureTree, $filter);

        $measurements = DB::connection('tbd')
            ->table('prod.meas_gzu_prod')
            ->where('meas_date', $filter->date)
            ->whereIn('gzu', $techs->pluck('id')->toArray())
            ->get();

        $fields = $this->getFields();

        $result = collect([]);
        foreach ($techs as $zu) {
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

                $row['zu_gzu'] = ['value' => $zu->name_ru];
                $structureItem = $structureTree->where('type', 'tech')->where('id', $zu->id)->first();
                $pf = $this->findParent($structureTree, $structureItem, 'org', ['SUBC']);
                if ($this->formType === 'ktm') {
                    $upn = $this->findParent($structureTree, $structureItem, 'tech', ['OTU', 'OPPS']);
                    $row['upn'] = ['value' => $upn ? $upn['name'] : null];
                } else {
                    $gu = $this->findParent($structureTree, $structureItem, 'tech', ['GU']);
                    $ngdu = $this->findParent($structureTree, $structureItem, 'org', ['FOFS']);
                    $cdng = $this->findParent($structureTree, $structureItem, 'org', ['OGPU']);

                    $row['gu'] = ['value' => $gu ? $gu['name'] : null];
                    $row['ngdu'] = ['value' => $ngdu ? $ngdu['name'] : null];
                    $row['cdng'] = ['value' => $cdng ? $cdng['name'] : null];
                }


                $row['pf'] = ['value' => $pf ? $pf['name'] : null];
            }

            $result->push($row);
        }

        $this->addLimits($result);

        return [
            'rows' => $result->toArray(),
            'columns' => $this->getColumns()
        ];
    }

    private function getStructureTree()
    {
        $structureService = app()->make(StructureService::class);
        return $structureService->getFlattenTree();
    }

    private function getTechs(Collection $structureTree, \stdClass $filter)
    {
        $item = $structureTree->where('type', $this->request->get('type'))
            ->where('id', $this->request->get('id'))->first();

        $items = $this->getItemWithChildren($structureTree, $item);
        $techIds = array_map(
            function ($item) {
                return $item['id'];
            },
            array_filter($items, function ($item) {
                return $item['type'] === 'tech' && in_array($item['sub_type'], ['MS', 'GMS']);
            })
        );

        return Tech::whereIn('id', $techIds)
            ->where('dbeg', '<=', $filter->date)
            ->where('dend', '>=', $filter->date)
            ->whereHas('type', function ($query) {
                $query->whereIn('code', ['MS', 'GMS']);
            })
            ->get();
    }

    private function getTech(): Tech
    {
        if ($this->formType === 'ktm') {
        }

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

    private function getDzo(Collection $structureTree)
    {
        $item = $structureTree->where('type', $this->request->get('type'))
            ->where('id', $this->request->get('id'))->first();
        return $this->findParent($structureTree, $item, 'org', ['SUBC']);
    }

    private function findParent(Collection $structureTree, $item, string $type, array $subTypes): ?array
    {
        while (true) {
            if (!isset($item['parent_id']) || !isset($item['parent_type'])) {
                return null;
            }
            $parent = $structureTree->where('id', $item['parent_id'])
                ->where('type', $item['parent_type'])->first();
            if (empty($parent)) {
                break;
            }

            if ($parent['type'] === $type && in_array($parent['sub_type'], $subTypes)) {
                return $parent;
            }

            $item = $parent;
        }

        return null;
    }

    private function getItemWithChildren(Collection $structureTree, $item): ?array
    {
        $result = [$item];

        $children = $structureTree->where('parent_id', $item['id'])
            ->where('parent_type', $item['type']);

        foreach ($children as $child) {
            $result = array_merge($result, $this->getItemWithChildren($structureTree, $child));
        }

        return $result;
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

    private function getColumns()
    {
        return $this->getFields()
            ->filter(function ($field) {
                if (!isset($field['form_type'])) {
                    return true;
                }
                return $field['form_type'] === $this->formType;
            })->values();
    }

}