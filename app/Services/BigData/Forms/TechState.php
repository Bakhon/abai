<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TechState extends PlainForm
{
    protected $configurationFileName = 'tech_state';

    public function calcFields(int $wellId, array $values): array
    {
        if (empty($values['dbeg'])) {
            return [];
        }

        $result = DB::connection('tbd')
            ->table('prod.well_tech_state as wts')
            ->select('wct.name_ru as category', 'wtst.name_ru as state')
            ->where('wts.dbeg', '<=', Carbon::parse($values['dbeg'])->timezone('Asia/Almaty')->endOfDay())
            ->where('wts.dend', '>', Carbon::now())
            ->where('wts.well', $wellId)
            ->leftJoin('prod.well_category as wc', 'wc.well', 'wts.well')
            ->leftJoin('dict.well_category_type as wct', 'wct.id', 'wc.category')
            ->leftJoin('dict.well_tech_state_type as wtst', 'wtst.id', 'wts.state')
            ->orderBy('wts.dbeg', 'desc')
            ->limit(1)
            ->first();

        if (empty($result)) {
            return [];
        }

        return [
            'old_state' => $result->state,
            'current_category' => $result->category
        ];
    }

    public function submit(): array
    {
        DB::beginTransaction();
        try {
            $row = DB::connection('tbd')
                ->table('prod.well_tech_state')
                ->select('id')
                ->where(
                    'dbeg',
                    '<=',
                    Carbon::parse($this->request->get('dbeg'))->timezone('Asia/Almaty')->endOfDay()
                )
                ->where('dend', '>', Carbon::now()->timezone('Asia/Almaty'))
                ->where('well', $this->request->get('well'))
                ->orderBy('dbeg', 'desc')
                ->limit(1)
                ->first();

            if (!empty($row)) {
                DB::connection('tbd')
                    ->table('prod.well_tech_state')
                    ->where('id', $row->id)
                    ->update(['dend' => Carbon::parse($this->request->get('dbeg'))->timezone('Asia/Almaty')]);
            }

            parent::submit();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Ошибка отправки формы');
        }
    }
}