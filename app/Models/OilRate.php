<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class OilRate extends Model
{
  protected $table = 'oil_rates';

  protected $guarded = ['id'];

  protected $casts = [
      'value' => 'string',
      'date' => 'date'
  ];
}
