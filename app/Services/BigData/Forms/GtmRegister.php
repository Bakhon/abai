<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GtmRegister extends PlainForm
{
    protected $configurationFileName = 'gtm_register';

    protected function submitForm(): array
    {
        $formFields = $this->request->except('well_status_type', 'own_forces');

        $dbQuery = DB::connection('tbd')->table($this->params()['table']);

        if (!empty($formFields['id'])) {
            $id = $dbQuery->where('id', $formFields['id'])->update($formFields);
        } else {
            $id = $dbQuery->insertGetId($formFields);
        }

        $this->updateWellStatus();

        DB::commit();

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
    }

    private function updateWellStatus()
    {
        if (!$this->request->get('dend') || !$this->request->get('well_status_type')) {
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
                    'status' => $this->request->get('well_status_type'),
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
            $result['well_current_status_type'] = $newState->state;
        }

        return $result;
    }

    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('dbeg'),
            'dict.well',
            'drill_start_date'
        )) {
            $errors['dbeg'] = trans('bd.validation.drill_date');
        }

        return $errors;
    }

}