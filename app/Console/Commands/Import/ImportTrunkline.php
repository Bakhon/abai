<?php

namespace App\Console\Commands\Import;

use App\Imports\TrunklineImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportTrunkline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:Trunkline {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import coordinates of trunkline';

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
            Excel::import(new TrunklineImport($this), base_path($this->argument('path')));
        } catch (\Exception $er) {
            if ($er->getMessage() == 'Stop import') {
                $this->output->success('Import successful');
            } else {
                $this->output->error($er->getMessage());
            }
        }
    }
}
