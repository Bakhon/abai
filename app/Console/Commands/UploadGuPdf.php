<?php

namespace App\Console\Commands;

use App\Models\ComplicationMonitoring\Agzu;
use App\Models\ComplicationMonitoring\BufferTank;
use App\Models\ComplicationMonitoring\Gu;
use App\Models\ComplicationMonitoring\Pump;
use App\Models\ComplicationMonitoring\Sib;
use App\Services\AttachmentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

class UploadGuPdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UploadGuPdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Upload passports pdf's to files storage";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AttachmentService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function pathToUploadedFile( $path, $test = false )
    {
        $filesystem = new Filesystem;

        $name = $filesystem->name( $path );
        $extension = $filesystem->extension( $path );
        $originalName = $name . '.' . $extension;
        $mimeType = $filesystem->mimeType( $path );
        $error = null;

        return new UploadedFile( $path, $originalName, $mimeType, $error, $test );
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = '/gu_devices/sib/';
        $files = Storage::disk('public')->files($path);

        $query = [
            'origin' => 'document',
            'user_id' => 1,
        ];

        foreach ($files as $file) {
            $filePath = Storage::disk('public')->path($file);
            $fileUpload = [$this->pathToUploadedFile($filePath)];
            $gu_name = pathinfo($file, PATHINFO_FILENAME);

            $gu = Gu::whereHas('sib')
                ->where('name', $gu_name)
                ->first();

            if (!$gu) {
                $this->error('Gu '.$gu_name.' not founded');
                continue;
            }

            $sibs = Sib::where('gu_id', $gu->id)->get();

            if ($sibs->first()->pdf) {
                continue;
            }

            $filesIds = json_decode($this->service->upload($fileUpload, $query));

            if (!count($filesIds)) {
                $this->error('Gu '.$gu_name.' Not uploaded '.PHP_EOL.json_encode($filesIds));
                continue;
            }


            foreach($sibs as $sib) {
                $sib->pdf = $filesIds[0];
                $sib->save();
            }
        }
    }
}
