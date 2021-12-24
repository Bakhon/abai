<?php

namespace App\Models\VisCenter\Kpd;

use Illuminate\Database\Eloquent\Model;

class KpdFact extends Model
{
    protected $table = 'kpd_fact';
    protected $guarded = [];

     public function kpdCatalog()
    {
        return $this->belongsTo(KpdTreeCatalog::class,'kpd_id','id');
    }
}
