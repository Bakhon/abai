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

    public function get(int $attachment)
    {
        $result = $this->service->get($attachment);
        dd($result);
    }
}