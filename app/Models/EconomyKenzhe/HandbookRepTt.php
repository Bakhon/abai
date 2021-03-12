<?php

namespace App\Models\EconomyKenzhe;

use Illuminate\Database\Eloquent\Model;

class HandbookRepTt extends Model
{
    protected $fillable = [
        'parent_id',
        'num',
        'name'
    ];

    protected $table = 'rep_tt';

    public function handbookItems()
    {
        return $this->hasMany(HandbookRepTt::class, 'parent_id')->with('childHandbookItems');
    }

    public function childHandbookItems()
    {
        return $this->hasMany(HandbookRepTt::class, 'parent_id')->with('handbookItems');
    }


    public function toArray()
    {
        $array = parent::toArray();
        $camelArray = array();
        foreach ($array as $name => $value) {
            if ($name == 'child_handbook_items') {
                $camelArray['handbook_items'] = $value;
            } else {
                $camelArray[$name] = $value;
            }

        }
        return $camelArray;
    }
}