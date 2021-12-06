<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WellConstr extends PlainForm
{
    protected $configurationFileName = 'well_constr';
    protected $projectDrill = false;

    use DepthValidationTrait;
    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('landing_date'),
            'dict.well',
            'drill_start_date'
        )) {
            $errors['landing_date'][] = trans('bd.validation.landing_date');
        }

        return $errors;
    }

    protected function getRows(): Collection
    {
        if ($this->request->get('type') && $this->request->get('type') !== 'well') {
            throw new \Exception(trans('bd.select_well'));
        }

        $wellId = $this->request->get('well_id');
        $query = DB::connection('tbd')
            ->table($this->params()['table'])
            ->where('well', $wellId)
            ->where('project_drill', $this->projectDrill)
            ->orderBy('id', 'desc');

        $rows = $query->get();

        if (!empty($this->params()['sort'])) {
            foreach ($this->params()['sort'] as $sort) {
                if ($sort['order'] === 'desc') {
                    $rows = $rows->sortByDesc($sort['field']);
                } else {
                    $rows = $rows->sortBy($sort['field']);
                }
            }
        }

        return $this->formatRows($rows);
    }
}