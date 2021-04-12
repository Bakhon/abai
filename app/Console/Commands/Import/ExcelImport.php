<?php

namespace App\Console\Commands\Import;

use Maatwebsite\Excel\Facades\Excel;

trait  ExcelImport
{
    public function importExcel($importObject): void
    {
        $this->output->title('Starting import');
        try {
            Excel::import($importObject, base_path($this->argument('path')));
        } catch (\Exception $er) {
            if ($er->getMessage() == 'Stop import') {
                $this->output->success('Import successful');
            } else {
                $this->output->error($er->getMessage());
            }
        }
    }
}
