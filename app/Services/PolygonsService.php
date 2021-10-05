<?php


namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Http\UploadedFile;

class PolygonsService
{
    protected $client;

    const GRID_MAP_URI = 'polygons/gridmap';
    const CONTOUR_MAP_URI = 'polygons/contourmap';

    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => config('map_constructor.map_polygon_service_host')
            ]
        );
    }

    public function getPolygons(UploadedFile $file, int $numberOfLevels, string $type)
    {
        $uri = self::GRID_MAP_URI;
        if ($type === 'shp') {
            $uri = self::CONTOUR_MAP_URI;
        }
        return $this->client->request('POST', $uri, [
            'multipart' => [[
                'name' => 'file',
                'contents' => Utils::tryFopen($file->path(), 'r'),
                'filename' => $file->getClientOriginalName()
            ]],
            'query' => 'number_of_levels=' . $numberOfLevels . '&type=' . $type,
        ])->getBody()->getContents();
    }

}