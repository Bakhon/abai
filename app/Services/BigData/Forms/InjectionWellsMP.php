<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InjectionWellsMP extends TableForm
{
    protected $configurationFileName = 'injection_wells_m_p';

    public function getResults(): array
    {
        $filter = json_decode($this->request->filter);

        $wellId = $this->request->get('id');
        $results = DB::connection('tbd')
            ->table('dmart.monthly_inj as mi')
            ->select('mi.*', 'sd.name_ru as source')
            ->join('dict.source_data as sd', 'mi.source', 'sd.id')
            ->where('mi.well', $wellId)
            ->where('mi.date', '>=', $filter->date)
            ->where('mi.date', '<=', $filter->date_to)
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($item) {
                $result = [];
                foreach ($item as $key => $val) {
                    if ($key === 'date') {
                        $val = Carbon::parse($val, 'Asia/Almaty')->format('d.m.Y');
                    } elseif (is_numeric($val)) {
                        $val = str_replace(
                            '.0',
                            '',
                            number_format((float)$val, 1, '.', ' ')
                        );
                    }

                    $result[$key] = [
                        'value' => $val
                    ];
                }
                return $result;
            });

        return [
            'rows' => $results
        ];
    }
}