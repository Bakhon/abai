<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Facades\DB;

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
        return DB::connection('tbd')
            ->table('prod.file_storage')
            ->whereIn('id', $fileIds)
            ->get()
            ->map(function ($file) {
                $file->file_size = $this->formatFilesize($file->file_size);
                return $file;
            });
    }

    public function upload(array $files, array $query): array
    {
        $requstFiles = [];

        /** @var \Illuminate\Http\UploadedFile[] $files */
        foreach ($files as $file) {
            $requstFiles[] = [
                'name' => 'files',
                'contents' => Utils::tryFopen($file->path(), 'r'),
                'filename' => $file->getClientOriginalName()
            ];
        }

        $result = $this->request('upload/', $requstFiles, 'POST', $query)->getBody()->getContents();
        $uploadedFileIds = json_decode($result);

        $result = [];
        foreach ($files as $index => $file) {
            $result[] = DB::connection('tbd')
                ->table('prod.file_storage')
                ->insertGetId(
                    [
                        'file_path' => $uploadedFileIds[$index],
                        'file_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize()
                    ]
                );
        }

        return $result;
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
        return round($bytes / pow(1024, $factor)) . $size[$factor];
    }
}