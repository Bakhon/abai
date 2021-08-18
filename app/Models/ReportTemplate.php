<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportTemplate extends Model
{
    protected $guarded = ['id'];
    protected $table = 'bigdata_report_user';

    protected $casts = [
        'name' => 'string',
        'template' => 'string',
        'user_id' => 'number'
    ];

}
