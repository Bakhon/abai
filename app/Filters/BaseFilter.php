<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class BaseFilter
{

    protected $query;
    protected $params;

    public function __construct(Builder $query, array $params)
    {
        $this->query = $query;
        $this->params = $params;
    }

    public function __call($name, $params)
    {
        if(strpos($name, 'filter') === 0) {
            $field = Str::snake(substr($name, 6));
            $value = $params[0];
            $this->query->where($field, 'LIKE', '%'.$value.'%');
        }
    }

    public function filter():Builder
    {
        if(!empty($this->params['filter'])) {
            foreach ($this->params['filter'] as $field => $value) {
                $method = $this->getMethodName($field);
                $this->$method($value);
            }
        }

        if(!empty($this->params['order_by'])) {
            $this->sort($this->params['order_by'], (bool)$this->params['order_desc']);
        }
        else {
            $this->sort('created_at', true);
        }

        return $this->query;
    }

    protected function getMethodName(string $field):string {
        return 'filter'.Str::ucfirst(Str::camel($field));
    }

    abstract protected function sort(string $field, bool $desc);

    protected function filterGu($guId)
    {
        $this->query->where('gu_id', $guId);
    }

    protected function filterZu($guId)
    {
        $this->query->where('zu_id', $guId);
    }

    protected function filterCdng($guId)
    {
        $this->query->where('cdng_id', $guId);
    }

    protected function filterNgdu($guId)
    {
        $this->query->where('ngdu_id', $guId);
    }

    protected function filterWell($guId)
    {
        $this->query->where('well_id', $guId);
    }

    protected function filterDate($dates)
    {
        $dates = json_decode($dates);
        try{
            $dateFrom = $dates->from ? \Carbon\Carbon::parse($dates->from) : null;
            $dateTo = $dates->to ? \Carbon\Carbon::parse($dates->to) : null;
        }
        catch(\Exception $e) {
            return;
        }

        if(!empty($dateFrom)) {
            $this->query->where('date', '>=', $dateFrom);
        }
        if(!empty($dateTo)) {
            $this->query->where('date', '<=', $dateTo);
        }
    }

}
