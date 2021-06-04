<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\BigData\SubmitFormException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GtmRegister extends PlainForm
{
    protected $configurationFileName = 'gtm_register';

    public function submit(): array
    {
        DB::beginTransaction();

        try {
            $formFields = $this->request->except('well_status_type');

            $dbQuery = DB::connection('tbd')->table($this->params()['table']);

            if (!empty($formFields['id'])) {
                $id = $dbQuery->where('id', $formFields['id'])->update($formFields);
            } else {
                $id = $dbQuery->insertGetId($formFields);
            }

            $this->updateWellStatus();

            DB::commit();

            return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new SubmitFormException();
        }
    }

    private function updateWellStatus()
    {
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
                    'status' => $this->request->get('well_status_type'),
                    'dbeg' => $this->request->get('dend'),
                    'dend' => '3333-12-31 00:00:00+06',
                ]
            );
    }

    public function calcFields(int $wellId, array $values): array
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

        $newState = DB::connection('tbd')
            ->table('prod.well_status as ws')
            ->select('wst.name_ru as state')
            ->where('ws.dbeg', '>=', Carbon::parse($values['dend'])->timezone('Asia/Almaty')->startOfDay())
            ->where('ws.well', $wellId)
            ->leftJoin('dict.well_status_type as wst', 'wst.id', 'ws.status')
            ->orderBy('ws.dbeg', 'asc')
            ->limit(1)
            ->first();

        if (!empty($newState)) {
            $result['well_current_status_type'] = $newState->state;
        }

        return $result;
    }

}