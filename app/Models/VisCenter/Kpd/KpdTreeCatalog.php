<?php

namespace App\Models\VisCenter\Kpd;

use Illuminate\Database\Eloquent\Model;

class KpdTreeCatalog extends Model
{
    protected $table = 'kpd_tree_catalog';
    protected $fillable = [
        'name',
        'description',
        'unit',
        'polarity',
        'formula',
        'variables',
        'source',
        'responsible',
        'functions',
        'type'
    ];
}
