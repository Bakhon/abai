<?php

namespace App\Console\Commands\Import;

use App\Imports\PipesPointsImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        DB::table('hydro_calc_results')->delete();
        DB::statement("ALTER TABLE hydro_calc_results AUTO_INCREMENT = 1;");

        DB::table('trunkline_points')->delete();
        DB::statement("ALTER TABLE trunkline_points AUTO_INCREMENT = 1;");
        $this->importExcel(new PipesPointsImport($this), public_path('imports/thunkline_points.xlsx'));
    }
}
