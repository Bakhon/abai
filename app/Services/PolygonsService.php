<?php


namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\RequestOptions;
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
        $params = [
            'type' => $type
        ];
        if ($type === 'shp' || $type === 'txt') {
            $uri = self::CONTOUR_MAP_URI;
        } else {
            $params += [
                'number_of_levels' => $numberOfLevels
            ];
        }
        return $this->client->request('POST', $uri, [
            'multipart' => [[
                'name' => 'file',
                'contents' => Utils::tryFopen($file->path(), 'r'),
                'filename' => $file->getClientOriginalName()
            ]],
            'query' => http_build_query($params),
        ])->getBody()->getContents();
    }

    public function convertCoords(array $coords, string $dzoCode, string $conversionType): array {
        return json_decode($this->client->request('POST', '/coordinates/conversion', [
            RequestOptions::BODY => json_encode($coords),
            'query' => http_build_query([
                'dzo' => $dzoCode,
                'conversion_type' => $conversionType,
            ]),
        ])->getBody()->getContents());
    }

    public function getDataFromExcel(UploadedFile $file): array {
        return json_decode($this->client->request('POST', '/bubblemaps/data_from_excel', [
            'multipart' => [[
                'name' => 'file',
                'contents' => Utils::tryFopen($file->path(), 'r'),
                'filename' => $file->getClientOriginalName()
            ]],
        ])->getBody()->getContents());
    }

    public function getGridByBase64($base64Data, $selectedFilterType, $selectedFilterValue): array {
        $type = 'number_of_levels';
        if ((int)$selectedFilterType === 1) {
            $type = 'step';
        }
        return (array)json_decode($this->client->request('POST', '/polygons/base64gridmap', [
            RequestOptions::BODY => json_encode($base64Data),
            'query' => http_build_query([
                $type => (int)$selectedFilterValue,
            ]),
        ])->getBody()->getContents());
    }
}