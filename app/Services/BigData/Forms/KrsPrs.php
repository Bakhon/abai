<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class KrsPrs extends PlainForm
{
    protected $repairType = '';

    use DepthValidationTrait;
    use DateMoreThanValidationTrait;
    protected function getRows(): Collection
    {
        $rows = parent::getRows();
        return $rows->map(function ($item) {
            $item->by_ourselves = empty($item->contractor);
            return $item;
        });
    }
    public function getCalculatedFields(int $wellId, array $values): array
    {
        if (empty($values['dend'])) {
            return [];
        }

        $result = [];

        $oldState = DB::connection('tbd')
            ->table('prod.well_status as ws')
            ->select('wct.name_ru as category', 'wst.name_ru as state')
            ->where('ws.dbeg', '<', Carbon::parse($values['dend'])->timezone('Asia/Almaty')->startOfDay())
            ->where('ws.well', $wellId)
            ->leftJoin('prod.well_category as wc', 'wc.well', 'ws.well')
            ->leftJoin('dict.well_category_type as wct', 'wct.id', 'wc.category')
            ->leftJoin('dict.well_status_type as wst', 'wst.id', 'ws.status')
            ->orderBy('ws.dbeg', 'desc')
            ->limit(1)
            ->first();

        if (!empty($oldState)) {
            $result['well_previous_status_type'] = $oldState->state;
            $result['well_previous_category'] = $oldState->category;
        }

        if ($this->request->get('gtm_dublicate') && $this->request->get('gtm_type')) {
            DB::connection('tbd')
                ->table('prod.gtm')
                ->insert(
                    [
                        'well' => $this->request->get('well'),
                        'dbeg' => $this->request->get('dbeg'),
                        'dend' => $this->request->get('dend'),
                        'gtm_type' => $this->request->get('gtm_type'),
                        'company' => $this->request->get('contractor')
                    ]
                );
        }

        return $result;
    }

    protected function submitForm(): array
    {
        $formFields = $this->prepareDataToSubmit();

        $dbQuery = DB::connection('tbd')->table($this->params()['table']);

        if (!empty($formFields['id'])) {
            $id = $dbQuery->where('id', $formFields['id'])->update($formFields);
        } else {
            $id = $dbQuery->insertGetId($formFields);
        }

        $this->updateWellStatus();

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
    }

    protected function prepareDataToSubmit()
    {
        $data = $this->request->except('well_status');

        $kpc = DB::connection('tbd')
            ->table('dict.well_repair_type')
            ->select('id')
            ->where('code', $this->repairType)
            ->first();
        $data['repair_type'] = $kpc->id;

        return $data;
    }

    private function updateWellStatus()
    {
        if (!$this->request->get('dend') || !$this->request->get('well_status')) {
            return;
        }

        DB::connection('tbd')
            ->table('prod.well_status')
            ->where('well', $this->request->get('well'))
            ->where('dbeg', '<', $this->request->get('dend'))
            ->orderBy('dbeg', 'desc')
            ->limit(1)
            ->update(['dend' => $this->request->get('dend')]);

        DB::connection('tbd')
            ->table('prod.well_status')
            ->insert(
                [
                    'well' => $this->request->get('well'),
                    'status' => $this->request->get('well_status'),
                    'dbeg' => $this->request->get('dend'),
                    'dend' => Well::DEFAULT_END_DATE,
                ]
            );
    }
}