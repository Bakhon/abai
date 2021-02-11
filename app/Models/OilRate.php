<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class OilRate extends Model
{
  protected $guarded = ['id'];

  protected $casts = [
      'value' => 'string',
      'date' => 'date'
  ];
}
