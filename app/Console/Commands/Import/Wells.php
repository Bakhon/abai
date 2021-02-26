<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Command;
use Level23\Druid\Types\Granularity;
use Maatwebsite\Excel\Facades\Excel;

class Wells extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:wells {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import coordinates of wells in GUs';

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
        Excel::import(new \App\Imports\GuWellsImport(), base_path($this->argument('path')));
    }
}
