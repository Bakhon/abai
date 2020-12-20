<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearOldExportFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:export_files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old export files';

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
        collect(Storage::disk('public')->listContents('export', true))
            ->each(
                function ($file) {
                    if ($file['type'] == 'file' && $file['timestamp'] < now()->subDay()->getTimestamp()) {
                        Storage::disk('public')->delete($file['path']);
                    }
                }
            );
    }
}
