<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

abstract class BaseFilter
{

    protected $query;
    protected $params;
    protected $defaultSortField;
    protected $defaultSortDesc;
    protected $operators = ['>=', '<=', '!=', '>', '<', 'not_null', 'null'];

    public function __construct(Builder $query, array $params)
    {
        $this->query = $query;
        $this->params = $params;
    }

    public function __call($name, $params)
    {
        if(strpos($name, 'filter_') === 0) {
            $field = substr($name, 7);
            $value = $params[0];
            $operator = $params[1] ? $params[1] : null;

            switch ($operator) {
                case null:
                    $this->query->where($field, 'LIKE', '%'.$value.'%');
                    break;
                case 'null':
                    $this->query->whereNull($field);
                    break;
                case 'not_null':
                    $this->query->whereNotNull($field);
                    break;
                default:
                    $this->query->where($field, $operator, $value);
            }
        }
    }

    public function filter():Builder
    {
        if(!empty($this->params['filter'])) {
            foreach ($this->params['filter'] as $field => $value) {
                $method = $this->getMethodName($field);
                $operator = null;

                for ($i = 0; $i < count($this->operators); $i++) {
                    $pattern = $this->operators[$i];
                    if (preg_match("/$pattern/", $value)) {
                        $operator = $this->operators[$i];
                        $value = str_replace(" ", '', $value);
                        $value = str_replace($operator, '', $value);
                        break;
                    }
                }

                $this->$method($value, $operator);
            }
        }

        if(!empty($this->params['order_by'])) {
            $this->sort($this->params['order_by'], (bool)$this->params['order_desc']);
        }
        else {
            $this->sort($this->defaultSortField ?? 'created_at', $this->defaultSortDesc ?? true);
        }

        return $this->query;
    }

    protected function getMethodName(string $field):string {
        return 'filter_'.$field;
    }

    abstract protected function sort(string $field, bool $isDescending);

    protected function filter_field($guId, string $operator = '=')
    {
        $this->query->where('field_id', $operator, $guId);
    }

    protected function filter_gu($guId)
    {
        $this->query->where('gu_id', $guId);
    }

    protected function filter_zu($guId)
    {
        $this->query->where('zu_id', $guId);
    }

    protected function filter_cdng($guId)
    {
        $this->query->where('cdng_id', $guId);
    }

    protected function filter_ngdu($guId)
    {
        $this->query->where('ngdu_id', $guId);
    }

    protected function filter_well($guId)
    {
        $this->query->where('well_id', $guId);
    }

    protected function filter_material($guId)
    {
        $this->query->where('material_id', $guId);
    }

    protected function filter_other_objects($guId)
    {
        $this->query->where('other_objects_id', $guId);
    }

    protected function filter_water_type_by_sulin($guId)
    {
        $this->query->where('water_type_by_sulin_id', $guId);
    }

    protected function filter_sulphate_reducing_bacteria($guId)
    {
        $this->query->where('sulphate_reducing_bacteria_id', $guId);
    }

    protected function filter_hydrocarbon_oxidizing_bacteria($guId)
    {
        $this->query->where('hydrocarbon_oxidizing_bacteria_id', $guId);
    }

    protected function filter_thionic_bacteria($guId)
    {
        $this->query->where('thionic_bacteria_id', $guId);
    }

    protected function filter_inhibitor($guId)
    {
        $this->query->where('inhibitor_id', $guId);
    }

    protected function filter_date($dates)
    {
        $this->filterByDate($dates, 'date');
    }

    protected function filterByDate($dates, $field) {

        $dates = json_decode($dates);
        try{
            $dateFrom = $dates->from ? Carbon::parse($dates->from) : null;
            $dateTo = $dates->to ? Carbon::parse($dates->to) : null;
        }
        catch(\Exception $e) {
            return;
        }

        if(!empty($dateFrom)) {
            $this->query->where($field, '>=', $dateFrom);
        }
        if(!empty($dateTo)) {
            $this->query->where($field, '<=', $dateTo);
        }

    }

}
