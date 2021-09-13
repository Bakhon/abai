<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class WellRegister extends PlainForm
{
    protected $configurationFileName = 'well_register';

    protected function submitForm(): array
    {
        $data = $this->request->except(
            [
                'well',
                'org',
                'geo',
                'category',
                'coord_system',
                'whc.coord_point.x',
                'whc.coord_point.y',
                'bottom_coord.coord_point.x',
                'bottom_coord.coord_point.y',
            ]
        );
        if (!empty($this->params()['default_values'])) {
            $data = array_merge($this->params()['default_values'], $data);
        }

        $dbQuery = DB::connection('tbd')->table($this->params()['table']);
        $wellId = $dbQuery->insertGetId($data);

        $this->submittedData['fields'] = $data;
        $this->submittedData['id'] = $wellId;

        $this->insertWellRelation($wellId, 'org');
        $this->insertWellRelation($wellId, 'category');
        $this->insertGeoFields($wellId);

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $wellId)->first();
    }

    public function getResults(): JsonResponse
    {
        return response()->json(
            [
                'rows' => [],
                'columns' => [],
                'form' => $this->params()
            ]
        );
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidCoordinates('whc.coord_point.x', 'whc.coord_point.y')) {
            $errors['coord_mouth_x'][] = trans('bd.validation.coords_mouth');
            $errors['coord_mouth_y'][] = trans('bd.validation.coords_mouth');
        }

        if (!$this->isValidCoordinates('bottom_coord.coord_point.x', 'bottom_coord.coord_point.y')) {
            $errors['coord_bottom_x'][] = trans('bd.validation.coords_bottom');
            $errors['coord_bottom_y'][] = trans('bd.validation.coords_bottom');
        }

        return $errors;
    }

    private function isValidCoordinates($coordXField, $coordYField): bool
    {
        if (!($this->request->filled(['geo', $coordXField, $coordYField]))) {
            return true;
        }

        $coord = "({$this->request->get($coordXField)},{$this->request->get($coordYField)})";

        return $this->validator->isValidCoordinates($coord, $this->request->get('geo'));
    }

    private function insertGeoFields($wellId)
    {
        DB::connection('tbd')
            ->table('prod.well_geo')
            ->insert(
                [
                    'well' => $wellId,
                    'geo' => $this->request->get('geo'),
                    'dbeg' => $this->request->get('project_date') ?: Carbon::now(),
                    'dend' => Well::DEFAULT_END_DATE
                ]
            );

        $spatialObjectType = DB::connection('tbd')
            ->table('dict.spatial_object_type')
            ->where('code', 'PNT')
            ->first();

        $topCoordId = $this->insertTopWellCoord($spatialObjectType);
        $bottomCoordId = $this->insertBottomWellCoord($spatialObjectType);

        DB::connection('tbd')
            ->table('dict.well')
            ->where('id', $wellId)
            ->update(
                [
                    'whc' => $topCoordId,
                    'bottom_coord' => $bottomCoordId,
                ]
            );
    }

    private function insertWellRelation(int $wellId, string $type)
    {
        if (!$this->request->get($type)) {
            return;
        }

        DB::connection('tbd')
            ->table('prod.well_' . $type)
            ->insert(
                [
                    'well' => $wellId,
                    $type => $this->request->get($type),
                    'dbeg' => $this->request->get('project_date') ?: Carbon::now(),
                    'dend' => Well::DEFAULT_END_DATE
                ]
            );
    }

    private function insertTopWellCoord($spatialObjectType): ?int
    {
        if (!$this->request->get('whc.coord_point.x')) {
            return null;
        }
        if (!$this->request->get('whc.coord_point.y')) {
            return null;
        }

        $topCoordId = DB::connection('tbd')
            ->table('geo.spatial_object')
            ->insertGetId(
                [
                    'coord_system' => $this->request->get('coord_system'),
                    'coord_point' => '(' . implode(
                            ',',
                            [
                                $this->request->get('whc.coord_point.x'),
                                $this->request->get('whc.coord_point.y')
                            ]
                        ) . ')',
                    'spatial_object_type' => $spatialObjectType->id,
                ]
            );
        return $topCoordId;
    }

    private function insertBottomWellCoord($spatialObjectType): ?int
    {
        if (!$this->request->get('bottom_coord.coord_point.x')) {
            return null;
        }
        if (!$this->request->get('bottom_coord.coord_point.y')) {
            return null;
        }

        $bottomCoordId = DB::connection('tbd')
            ->table('geo.spatial_object')
            ->insertGetId(
                [
                    'coord_system' => $this->request->get('coord_system'),
                    'coord_point' => '(' . implode(
                            ',',
                            [
                                $this->request->get('bottom_coord.coord_point.x'),
                                $this->request->get('bottom_coord.coord_point.y')
                            ]
                        ) . ')',
                    'spatial_object_type' => $spatialObjectType->id,
                ]
            );
        return $bottomCoordId;
    }

}