<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DZOyear extends Model
{
  protected $guarded = ['id'];

  protected $casts = [
      'dzo' => 'string',
      'oil_plan' => 'number',
      'oil_opek_plan' => 'number'
  ];
}