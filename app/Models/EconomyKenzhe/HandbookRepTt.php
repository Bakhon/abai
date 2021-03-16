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

    public function reptValues()
    {
        return $this->hasMany(HandbookRepTtValue::class, 'rep_id', 'id');
    }
    
    public function toArray()
    {
        $array = parent::toArray();
        $renameArrayKeys = array();
        foreach ($array as $name => $value) {
            if ($name == 'child_handbook_items' or $name == 'child_handbook_items_by_date' or $name == 'handbook_items_by_date') {
                $renameArrayKeys['handbook_items'] = $value;
            } else {
                $renameArrayKeys[$name] = $value;
            }
        }
        return $renameArrayKeys;
    }
}
