<?php

namespace App\Models\BigData\Dictionaries;

use App\Models\TBDModel;

class Geo extends TBDModel
{
    protected $table = 'tbdi.geo';

    public function parent()
    {
        return $this->belongsTo(Geo::class, 'parent_id', 'id');
    }

    public function getParentIds()
    {
        $result = [];

        $item = $this;

        while (true) {
            $parent = $item->parent;
            if (empty($parent)) {
                break;
            }

            $result[] = $parent->id;
            $item = $parent;
        }

        return $result;
    }
}
