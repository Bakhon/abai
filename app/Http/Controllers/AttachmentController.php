<?php

namespace App\Http\Controllers;

use App\Services\AttachmentService;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    protected $service;

    public function __construct(AttachmentService $service)
    {
        $this->service = $service;
    }

    public function upload(Request $request)
    {
        $query = [
            'origin' => $request->origin ?? 'document',
            'user_id' => auth()->id(),
        ];

        $files = $this->service->upload($request->uploads, $query);
        return response()->json(['files' => $files]);
    }

    public function download(int $attachment)
    {
        $file = $this->service->get($attachment);
        $filename = $this->service->getInfo([$attachment])[0]->filename;
        $fileUrl = $file->getBody()->getMetadata('uri');

        return response()->streamDownload(function () use ($fileUrl) {
            echo file_get_contents($fileUrl);
        }, $filename);
    }

    public function getFileInfo(int $attachment)
    {
        $fileInfo = $this->service->getInfo([$attachment])[0];

        return response()->json(['file_info' => $fileInfo]);
    }
}