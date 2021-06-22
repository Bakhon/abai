<?php

namespace App\Console\Commands\Import;

use App\Imports\BufferTankImport;
use Illuminate\Console\Command;

class ImportBufferTank extends Command
{
    use ExcelImport;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:buffertank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import buffer tank data';

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
        $this->importExcel(new BufferTankImport($this), public_path('buffertank.xlsx'));
    }
}
