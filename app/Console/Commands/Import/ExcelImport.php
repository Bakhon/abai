<?php

namespace App\Console\Commands\Import;

use Maatwebsite\Excel\Facades\Excel;

trait  ExcelImport
{
    public function importExcel(object $importObject, string $filePath): void
    {
        $this->output->title('Starting import');
        try {
            Excel::import($importObject, $filePath);
        } catch (\Exception $er) {
            if ($er->getMessage() == 'Success import') {
                $this->output->success('Import successful');
            } else {
                $this->output->error($er->getMessage());
            }
        }
    }
}
