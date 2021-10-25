<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class ManualHydroCalcExportLongSheet implements FromView, ShouldAutoSize, WithTitle
{
    protected $data;

    function __construct(array $params, \Illuminate\Database\Eloquent\Collection $pipes)
    {
        $this->pipes = $pipes;
        $this->params = $params;
    }

    public function title(): string
    {
        return 'Длинные результаты';
    }

    public function view(): View
    {
        foreach ($this->pipes as $key => $pipe) {
            if (!isset($pipe->fluid_speed)) {
                unset($this->pipes[$key]);
                continue;
            }

            $pipe->oilPipe->load([
                'hydroCalcLong' => function ($query) use ($pipe) {
                    $query->where('date', $pipe->date)->orderBy('segment');
                }
            ]);
        }

        $columnNames = [
            'Segment',
            'Distance',
            'Pin (atm)',
            'Pout (atm)',
            'Tin (C)',
            'Tout (C)',
            'EV (m/s)',
            'Vliq (m/s)',
            'Vgas (m/s)',
            'Vm (m/s)',
            'Comment'
        ];

        $data = [
            'pipes' => $this->pipes,
            'columnNames' => $columnNames
        ];

        return view('exports.manual_calculate_export_long', [
            'data' => $data
        ]);
    }
}
