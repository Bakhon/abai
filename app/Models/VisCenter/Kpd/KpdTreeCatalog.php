<?php

namespace App\Models\VisCenter\Kpd;

use Illuminate\Database\Eloquent\Model;

class KpdTreeCatalog extends Model
{
    protected $table = 'kpd_tree_catalog';
    protected $guarded = [];

    public function kpdElements()
    {
        return $this->hasOne(KpdElements::class);
    }
}
