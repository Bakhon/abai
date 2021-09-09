<?php

namespace App\Http\Controllers\Api\DB;

use App\Http\Controllers\Controller;
use App\Models\BigData\Well;
use App\Services\LasFileService;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class LasController extends Controller
{

    public function getWellForLas(Well $well): JsonResponse
    {
        $field = $this->getField($well->geo->first());

        return response()->json(
            [
                'well' => $well,
                'field' => $field
            ]
        );
    }

    private function getField($geo)
    {
        if ($geo->type->code === 'FLD') {
            return $geo;
        }

        return $this->getField($geo->parent());
    }

    public function attachFileToGis(Request $request): JsonResponse
    {
        DB::connection('tbd')
            ->table('prod.lass_files')
            ->insert(
                [
                    'exp_id' => $request->get('experiment_id'),
                    'name_ru' => $request->get('filename'),
                    'well' => $request->get('well_id')
                ]
            );

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function downloadFile(LasFileService $service, int $experiment)
    {
        $response = $service->get($experiment);
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
