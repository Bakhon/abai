<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrgTechLink extends PlainForm
{
    protected $configurationFileName = 'org_tech_link';

    protected function getRows(): Collection
    {
        if ($this->request->get('type') !== 'org') {
            throw new \Exception(trans('bd.select_tech'));
        }

        $orgId = $this->request->get('well_id');
        $query = DB::connection('tbd')
            ->table($this->params()['table'])
            ->where('org', $orgId)
            ->orderBy('id', 'desc');

        $rows = $query->get();

        if (!empty($this->params()['sort'])) {
            foreach ($this->params()['sort'] as $sort) {
                if ($sort['order'] === 'desc') {
                    $rows = $rows->sortByDesc($sort['field']);
                } else {
                    $rows = $rows->sortBy($sort['field']);
                }
            }
        }

        return $this->formatRows($rows);
    }

    protected function prepareDataToSubmit()
    {
        $data = $this->request->except('well');
        $data['org'] = $this->request->get('well');

        if (empty($data['dend'])) {
            $data['dend'] = Well::DEFAULT_END_DATE;
        }

        return $data;
    }
}