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
                'base_uri' => env('MAP_POLYGON_SERVICE_HOST')
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