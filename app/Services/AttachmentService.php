<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;

class AttachmentService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => config('filemanager.url')
            ]
        );
    }

    public function get(int $fileId)
    {
        return $this->request('get', ['file_id' => $fileId], 'GET', [], [
            'stream' => true,
            'sink' => 'STDOUT'
        ]);
    }

    private function request(
        string $route,
        array $data,
        string $method = 'GET',
        array $query = [],
        array $userOptions = []
    ) {
        $options = $userOptions;
        if (!empty($data)) {
            if ($method === 'GET') {
                $options['query'] = $data;
            } else {
                $options['multipart'] = $data;
            }
        }
        if (!empty($query)) {
            $options['query'] = $query;
        }

        return $this->client->request($method, $route, $options);
    }

    public function upload(array $files, array $query)
    {
        /** @var \Illuminate\Http\UploadedFile[] $files */
        foreach ($files as $file) {
            $result[] = [
                'name' => 'files',
                'contents' => Utils::tryFopen($file->path(), 'r'),
                'filename' => $file->getClientOriginalName()
            ];
        }
        return $this->request('upload/', $result, 'POST', $query)->getBody()->getContents();
    }
}