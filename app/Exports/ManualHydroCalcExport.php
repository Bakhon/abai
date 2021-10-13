<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ManualHydroCalcExport implements WithMultipleSheets
{
    protected $data;

    function __construct(array $params, \Illuminate\Database\Eloquent\Collection $pipes) {
        $this->pipes = $pipes;
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [new ManualHydroCalcExportResultSheet($this->pipes)];

        if ($this->params['date']) {
            $sheets[] = new ManualHydroCalcExportLongSheet($this->params, $this->pipes);
        }

        return $sheets;
    }
}
