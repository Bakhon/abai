<?php

namespace App\Http\Controllers;

use App\Services\AttachmentService;
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
        $fileInfo = $this->service->getInfo([$attachment])->first();
        $file = $this->service->get($fileInfo->file_path);
        $fileUrl = $file->getBody()->getMetadata('uri');

        return response()->streamDownload(function () use ($fileUrl) {
            echo file_get_contents($fileUrl);
        }, $fileInfo->file_name);
    }

    public function getFileInfo(int $attachment)
    {
        $fileInfo = $this->service->getInfo([$attachment])->first();

        return response()->json(['file_info' => $fileInfo]);
    }
}