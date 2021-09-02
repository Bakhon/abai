<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Support\Facades\DB;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use App\Exceptions\BigData\SubmitFormException;
use App\Models\BigData\Well;
use Carbon\Carbon;
class Kpc extends PlainForm
{
    protected $configurationFileName = 'kpc';
    use DepthValidationTrait;
    use DateMoreThanValidationTrait;
    protected function prepareDataToSubmit()
    {
        $data = $this->request->except($this->tableFieldCodes);

        $kpc = DB::connection('tbd')
            ->table('dict.well_repair_type')
            ->where('code', 'CWO')
            ->first();

        $data['repair_type'] = $kpc->id;
        return $data;
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('td'))) {
            $errors['td'] = trans('bd.validation.depth');
        }
        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('hud'))) {
            $errors['hud'] = trans('bd.validation.depth');
        }

        return $errors;
    }

    public function submit(): array
    {
        DB::beginTransaction();

        try {
            $formFields = $this->request->except('well_status');

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
            $result['well_status'] = $newState->state;
        }

        return $result;
    }
}