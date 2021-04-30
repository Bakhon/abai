<?php

namespace App\Console\Commands\Import;

use App\Imports\Ngdu4WellsImport;
use App\Imports\TrunklineImport;
use App\Models\ComplicationMonitoring\PipeType;
use App\Models\Pipes\OilPipe;
use App\Models\Pipes\PipeCoord;
use App\Models\Refs\Well;
use App\Models\Refs\Zu;
use Illuminate\Console\Command;
use App\Imports\GuWellsImport;
use Illuminate\Support\Facades\DB;

class Wells extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:wells';

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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        PipeCoord::truncate();
        OilPipe::truncate();
        Zu::truncate();
        Well::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $files = [
            'ngdu-1.xlsx',
            'ngdu-2.xlsx',
            'ngdu-3.xlsx'
        ];

        foreach ($files as $file) {
            $this->importExcel(new GuWellsImport($this), public_path('imports/'.$file));
        }

        $this->importExcel(new Ngdu4WellsImport($this), public_path('imports/ngdu-4.xlsx'));

        $this->importExcel(new TrunklineImport($this), public_path('imports/trunkline.xlsx'));

        PipeType::doesntHave('oilPipes')->delete();
    }
}
