<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class dzoFact extends Model
{
  protected $guarded = ['id'];

  protected $fillable = [
    'opec_explanation_reasons',
    'opec_measures_taken',
    'opec_wells_number',
    'opec_downtime',
    'opec_oil_losses',
    'impulse_explanation_reasons',
    'impulse_measures_taken',
    'impulse_wells_number',
    'impulse_downtime',
    'impulse_oil_losses',
    'shutdown_explanation_reasons',
    'shutdown_measures_taken',
    'shutdown_wells_number',
    'shutdown_downtime',
    'shutdown_oil_losses',
    'accident_explanation_reasons',
    'accident_measures_taken',
    'accident_wells_number',
    'accident_downtime',
    'accident_oil_losses',
    'restriction_kto_explanation_reasons',
    'restriction_kto_measures_taken',
    'restriction_kto_wells_number',
    'restriction_kto_downtime',
    'restriction_kto_oil_losses',
    'gas_restriction_explanation_reasons',
    'gas_restriction_measures_taken',
    'gas_restriction_wells_number',
    'gas_restriction_downtime',
    'gas_restriction_oil_losses',
    'other_explanation_reasons',
    'other_measures_taken',
    'other_wells_number',
    'other_downtime',
    'other_oil_losses'
  ];
}