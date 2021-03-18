<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class dzoFact extends Model
{
  protected $guarded = ['id'];

  protected $casts = [
    'field_name' => 'number',
    'oil_production_fact' => 'number',
    'oil_delivery_fact' => 'number',
    'oil_delivery_by_stations_fact' => 'number',
    'condensate_production_fact' => 'number',
    'condensate_delivery_fact' => 'number',
    'condensate_delivery_by_stations_fact' => 'number',
    'stock_of_goods_delivery_fact' => 'number',
    'natural_gas_production_fact' => 'number',
    'natural_gas_delivery_fact' => 'number',
    'natural_gas_expenses_for_own_fact' => 'number',
    'natural_gas_processing_fact' => 'number',
    'natural_gas_flaring_fact' => 'number',
    'associated_gas_production_fact' => 'number',
    'associated_gas_delivery_fact' => 'number',
    'associated_gas_expenses_for_own_fact' => 'number',
    'associated_gas_processing_fact' => 'number',
    'associated_gas_flaring_fact' => 'number',
    'agent_upload_total_water_injection_fact' => 'number',
    'agent_upload_seawater_injection_fact' => 'number',
    'agent_upload_waste_water_injection_fact' => 'number',
    'agent_upload_albsenomanian_water_injection_fact' => 'number',
    'agent_upload_stream_injection_fact' => 'number',
    'otm_wells_commissioning_from_drilling_fact' => 'number',
    'otm_drilling_fact' => 'number',
    'otm_well_workover_fact' => 'number',
    'otm_underground_workover' => 'number'
  ];
}