<?php

namespace App\Console\Commands\Import;

use App\Imports\CdngGuRelationsImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportCdngGuRelations extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:cdngGuRelations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import and update relations between GU and CDNG';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Excel::import(new CdngGuRelationsImport($this), public_path('cdng-gu.xlsx'));
    }
}
