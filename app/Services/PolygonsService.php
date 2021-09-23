<?php


namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Http\UploadedFile;

class PolygonsService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => 'http://172.20.103.203:8650/'
            ]
        );
    }

    public function getPolygons(UploadedFile $file, int $numberOfLevels)
    {
        return $this->client->request('POST', 'polygons/', [
            'multipart' => [[
                'name' => 'file',
                'contents' => Utils::tryFopen($file->path(), 'r'),
                'filename' => $file->getClientOriginalName()
            ]],
            'query' => 'number_of_levels=' . $numberOfLevels,
        ])->getBody()->getContents();
    }

}