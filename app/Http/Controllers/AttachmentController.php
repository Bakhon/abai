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

    public function get(int $attachment)
    {
        $response = $this->service->get($attachment);
        $body = $response->getBody();
        foreach ($response->getHeaders() as $key => $header) {
            header("$key:{$header[0]}");
        }

        while (!$body->eof()) {
            echo Utils::readline($body);
            ob_flush();
            flush();
        }
    }
}