<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class dzoFact extends Model
{
  protected $guarded = ['id'];

  protected $fillable = [
    'dzo_name',
    'field_id',
    'downtime_reasons_id',
    'decrease_reasons_id',
    'oil_production_fact',
    'oil_delivery_fact',
    'oil_delivery_by_stations_fact',
    'condensate_production_fact',
    'condensate_delivery_fact',
    'condensate_delivery_by_stations_fact',
    'stock_of_goods_delivery_fact',
    'natural_gas_production_fact',
    'natural_gas_delivery_fact',
    'natural_gas_expenses_for_own_fact',
    'natural_gas_processing_fact',
    'natural_gas_flaring_fact',
    'associated_gas_production_fact',
    'associated_gas_delivery_fact',
    'associated_gas_expenses_for_own_fact',
    'associated_gas_processing_fact',
    'associated_gas_flaring_fact',
    'agent_upload_total_water_injection_fact',
    'agent_upload_seawater_injection_fact',
    'agent_upload_waste_water_injection_fact',
    'agent_upload_albsenomanian_water_injection_fact',
    'agent_upload_stream_injection_fact',
    'otm_wells_commissioning_from_drilling_fact',
    'otm_drilling_fact',
    'otm_well_workover_fact',
    'otm_underground_workover',
    'operating_production_fond',
    'operating_injection_fond',
    'active_production_fond',
    'active_injection_fond',
    'in_work_production_fond',
    'in_work_injection_fond',
    'in_idle_production_fond',
    'in_idle_injection_fond',
    'inactive_production_fond',
    'inactive_injection_fond',
    'developing_production_fond',
    'developing_injection_fond',
    'pending_liquidation_production_fond',
    'pending_liquidation_injection_fond',
    'in_conservation_production_fond',
    'in_conservation_injection_fond'
  ];
}