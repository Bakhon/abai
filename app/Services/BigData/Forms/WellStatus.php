<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class WellStatus extends PlainForm
{
    protected $configurationFileName = 'well_status';

    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDateDbeg(
            $this->request->get('well'),
            $this->request->get('dbeg'),
            'prod.well_status',
            'dbeg',
            $this->request->get('id')
        )) {
            $errors['dbeg'] = trans('bd.validation.dbeg_well_block');
        }
        return $errors;
    }

    public function getCalculatedFields(int $wellId, array $values): array
    {
        if (empty($values['dbeg'])) {
            return [];
        }

        $oldStateQuery = DB::connection('tbd')
            ->table('prod.well_status as ws')
            ->select('wct.name_ru as category', 'wst.name_ru as state', 'ws.*')
            ->where('ws.dbeg', '<', Carbon::parse($values['dbeg'])->timezone('Asia/Almaty'))
            ->where('ws.well', $wellId)
            ->leftJoin('prod.well_category as wc', 'wc.well', 'ws.well')
            ->leftJoin('dict.well_category_type as wct', 'wct.id', 'wc.category')
            ->leftJoin('dict.well_status_type as wst', 'wst.id', 'ws.status')
            ->orderBy('ws.dbeg', 'desc')
            ->limit(1);

        if (!empty($values['id'])) {
            $oldStateQuery->where('ws.id', '!=', $values['id']);
        }

        $oldState = $oldStateQuery->first();

        if (empty($oldState)) {
            return [];
        }

        return [
            'old_category' => $oldState->category,
            'old_state' => $oldState->state,
        ];
    }

    protected function submitForm(): array
    {
        $date = Carbon::parse($this->request->get('dbeg'), 'Asia/Almaty')->toImmutable();

        $this->updatePreviousState($date);

        return parent::submitForm();
    }

    private function updatePreviousState(CarbonImmutable $date)
    {
        $previousState = DB::connection('tbd')
            ->table('prod.well_status')
            ->where('dbeg', '<', $date)
            ->where('well', $this->request->get('well'))
            ->orderBy('dbeg', 'desc')
            ->limit(1)
            ->first();

        if ($previousState) {
            DB::connection('tbd')
                ->table('prod.well_status')
                ->where('id', $previousState->id)
                ->update(
                    [
                        'dend' => $date->subSecond()
                    ]
                );
        }
    }
}