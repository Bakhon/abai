<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionSection extends Model
{
    protected $fillable = ['code', 'module', 'title_trans'];
}
