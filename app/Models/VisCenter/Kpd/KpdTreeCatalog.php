<?php

namespace App\Models\VisCenter\Kpd;

use Illuminate\Database\Eloquent\Model;

class KpdTreeCatalog extends Model
{
    protected $table = 'kpd_tree_catalog';
    protected $guarded = [];

    public function kpdElements()
    {
        return $this->hasMany('App\Models\VisCenter\Kpd\KpdElements', 'kpd_id', 'id');
    }
    public function kpdFact()
    {
        return $this->hasMany('App\Models\VisCenter\Kpd\KpdFact', 'kpd_id', 'id');
    }
}
