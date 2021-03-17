<?php

namespace App\Console\Commands\Import;

use App\Imports\Ngdu4WellsImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class Ngdu4Wells extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:Ngdu4Wells {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import coordinates of wells in GUs from NGDU-4';

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
        $this->output->title('Starting import');
        try {
            Excel::import(new Ngdu4WellsImport($this), base_path($this->argument('path')));
        } catch (\Exception $er) {
            if ($er->getMessage() == 'Stop import') {
                $this->output->success('Import successful');
            } else {
                $this->output->error($er->getMessage());
            }
        }
    }
}
