<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class BaseFilter
{

    protected $skipFields = [
        'order_by',
        'order_desc'
    ];

    protected $query;
    protected $filter;

    public function __construct(Builder $query, array $filter)
    {
        $this->query = $query;
        $this->filter = $filter;
    }

    public function filter():Builder
    {
        foreach($this->filter as $field => $value) {
            if(in_array($field, $this->skipFields)) continue;
            $method = $this->getMethodName($field);
            $this->$method($value);
        }

        if(!empty($this->filter['order_by'])) {
            $this->sort($this->filter['order_by'], (bool)$this->filter['order_desc']);
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

}
