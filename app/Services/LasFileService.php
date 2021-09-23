<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class LasFileService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => config('las.service_url')
            ]
        );
    }

    public function get(int $experimentId)
    {
        $experiment = DB::connection('tbd')
            ->table('prod.lass_files')
            ->where('exp_id', $experimentId)
            ->get()
            ->first();

        $params = [
            'experiments_id' => $experiment->exp_id,
            'filename' => $experiment->name_ru
        ];

        return $this->request('static/experiment_input_file/', $params, 'POST', [
            'stream' => true,
            'sink' => 'STDOUT'
        ]);
    }

    private function request(
        string $route,
        array $data,
        string $method = 'GET',
        array $userOptions = []
    ) {
        $options = $userOptions;
        if (!empty($data)) {
            if ($method === 'GET') {
                $options['query'] = $data;
            } else {
                $options['json'] = $data;
            }
        }

        return $this->client->request($method, $route, $options);
    }
}