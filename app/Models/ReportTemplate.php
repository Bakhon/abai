<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportTemplate extends Model
{
    protected $guarded = ['id'];
    protected $table = 'report_template';

    protected $casts = [
        'name' => 'string',
        'template' => 'string',
        'user_id' => 'number'
    ];

}
