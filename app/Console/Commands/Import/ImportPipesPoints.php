<?php

namespace App\Console\Commands\Import;

use App\Imports\PipesPointsImport;
use Illuminate\Console\Command;

class ImportPipesPoints extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:pipe_points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import pipes start and end points';

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
        $this->importExcel(new PipesPointsImport($this), public_path('imports/thunkline_points.xlsx'));
    }
}
