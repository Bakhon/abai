<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\SpatialObject;
use App\Models\BigData\Well;
use Carbon\Carbon;
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

    public function getResults(): array
    {
        return [
            'rows' => [],
            'columns' => [],
            'form' => $this->params()
        ];
    }

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidCoordinates('whc.coord_point.x', 'whc.coord_point.y')) {
            $errors['whc.coord_point.x'][] = trans('bd.validation.coords_mouth');
            $errors['whc.coord_point.y'][] = trans('bd.validation.coords_mouth');
        }

        if (!$this->isValidCoordinates('bottom_coord.coord_point.x', 'bottom_coord.coord_point.y')) {
            $errors['bottom_coord.coord_point.x'][] = trans('bd.validation.coords_bottom');
            $errors['bottom_coord.coord_point.y'][] = trans('bd.validation.coords_bottom');
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

        $this->updateCoords($wellId);
    }

    protected function updateCoords($wellId)
    {
        $spatialObjectType = DB::connection('tbd')
            ->table('dict.spatial_object_type')
            ->where('code', 'PNT')
            ->first();

        $well = Well::find($wellId);

        $topCoordId = $this->updateCoord(
            $spatialObjectType,
            $well->spatialObject,
            $this->request->get('coord_system'),
            $this->request->get('whc.coord_point.x'),
            $this->request->get('whc.coord_point.y')
        );
        $bottomCoordId = $this->updateCoord(
            $spatialObjectType,
            $well->spatialObjectBottom,
            $this->request->get('coord_system'),
            $this->request->get('bottom_coord.coord_point.x'),
            $this->request->get('bottom_coord.coord_point.y')
        );

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

    private function updateCoord($spatialObjectType, $spatialObject, $coordSystem, $xCoord, $yCoord): ?int
    {
        if (!$coordSystem || !$xCoord || !$yCoord) {
            return null;
        }

        $data = [
            'coord_system' => $coordSystem,
            'coord_point' => '(' . implode(
                    ',',
                    [
                        $xCoord,
                        $yCoord
                    ]
                ) . ')',
            'spatial_object_type' => $spatialObjectType->id,
        ];

        if ($spatialObject) {
            $spatialObject->update($data);
        } else {
            $spatialObject = SpatialObject::create($data);
        }
        return $spatialObject->id;
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

}