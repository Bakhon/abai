<?php

namespace App\Console\Commands\Import;

use App\Imports\ImportPsPipesObjects;
use App\Imports\TrunklinePipesImport;
use Illuminate\Console\Command;

class ImportTrunklinePipes extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:trunkline_pipes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import TrunkLine pipes';

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
        activity()->disableLogging();

        $this->importExcel(new TrunklinePipesImport($this), public_path('imports/trunkline_pipes.xlsx'));
    }
}
