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

    protected $date = '';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (request()->has('date')) {
            if (preg_match("/^(0[1-9]|1[0-2])-[0-9]{4}$/", request('date'))) {
                $this->date = date('Y-m-d', strtotime('01-' . request('date')));
            }
        }
    }

    public function handbookItems()
    {
        return $this->hasMany(HandbookRepTt::class, 'parent_id')->with(['childHandbookItems', 'reptValues']);
    }

    public function childHandbookItems()
    {
        return $this->hasMany(HandbookRepTt::class, 'parent_id')->with(['handbookItems', 'reptValues']);
    }

    public function handbookItemsByDate()
    {
        return $this->hasMany(HandbookRepTt::class, 'parent_id')->with(['childHandbookItemsByDate', 'reptValues' => function ($query) {
            $query->where('date', '<=', $this->date)->where('company_id', request('company'));
        }]);
    }

    public function childHandbookItemsByDate()
    {
        return $this->hasMany(HandbookRepTt::class, 'parent_id')->with(['handbookItemsByDate', 'reptValues' => function ($query) {
            $query->where('date', '<=', $this->date)->where('company_id', request('company'));
        }]);
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
