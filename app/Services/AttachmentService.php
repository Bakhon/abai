<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\RequestOptions;

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

    public function getInfo(array $fileIds)
    {
        $files = $this->request('get-files-info', [], 'POST', [], [
            RequestOptions::JSON => $fileIds
        ])->getBody()->getContents();

        return collect(json_decode($files))->map(function ($file) {
            $file->size = $this->formatFilesize($file->size);
            return $file;
        });
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

    private function formatFilesize(int $bytes)
    {
        $size = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return round($bytes / pow(1024, $factor)) . @$size[$factor];
    }
}