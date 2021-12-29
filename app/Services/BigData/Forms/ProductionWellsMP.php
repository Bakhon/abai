<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductionWellsMP extends TableForm
{
    protected $configurationFileName = 'production_wells_m_p';

    public function getResults(): array
    {
        $filter = json_decode($this->request->filter);

        $wellId = $this->request->get('id');
        $results = DB::connection('tbd')
            ->table('dmart.monthly_prod_oil as mpo')
            ->select('mpo.*', 'sd.name_ru as source')
            ->join('dict.source_data as sd', 'mpo.source', 'sd.id')
            ->where('mpo.well', $wellId)
            ->where('mpo.date', '>=', $filter->date)
            ->where('mpo.date', '<=', $filter->date_to)
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