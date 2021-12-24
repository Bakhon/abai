<?php

namespace App\Models\VisCenter\Kpd;

use Illuminate\Database\Eloquent\Model;

class KpdElements extends Model
{
    protected $table = 'kpd_elements';
    protected $fillable = [
        'name',
        'transcript',
        'unit',
        'source',
        'responsible'
    ];

     public function kpdCatalog()
    {
        return $this->belongsTo(KpdTreeCatalog::class,'kpd_id','id');
    }
}
