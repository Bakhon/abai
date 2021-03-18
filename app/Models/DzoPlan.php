<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class dzoPlan extends Model
{
  protected $guarded = ['id'];

  protected $casts = [
      'dzo' => 'string',
      'date' => 'date',
      'plan_oil' => 'number',
      'plan_kondensat' => 'number'
  ];
}
