<?php

namespace App\Console\Commands\Import;

use App\Imports\ZuOtvodyImport;
use Illuminate\Console\Command;

class ZuOtvody extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:zu_otvody';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import otvody for zu';

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
    public function handle(): void
    {
        $this->importExcel(new ZuOtvodyImport($this), public_path('imports/zu_otvody.xlsx'));
    }
}
