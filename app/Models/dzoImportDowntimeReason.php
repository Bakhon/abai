<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class dzoFact extends Model
{
  protected $guarded = ['id'];

  protected $fillable = [
    "prs_downtime_production_wells_count",
    "prs_downtime_production_wells_oil_loss",
    "prs_downtime_injection_wells_count",
    "prs_wait_downtime_production_wells_count",
    "prs_wait_downtime_production_wells_oil_loss",
    "prs_wait_downtime_injection_wells_count",
    "krs_downtime_production_wells_count",
    "krs_downtime_production_wells_oil_loss",
    "krs_downtime_injection_wells_count",
    "krs_wait_downtime_production_wells_count",
    "krs_wait_downtime_production_wells_oil_loss",
    "krs_wait_downtime_injection_wells_count",
    "well_survey_downtime_production_wells_count",
    "well_survey_downtime_production_wells_oil_loss",
    "well_survey_downtime_injection_wells_count",
    "other_downtime_production_wells_count",
    "other_downtime_production_wells_oil_loss",
    "other_downtime_injection_wells_count",
    "glut_downtime_production_wells_count",
    "glut_downtime_production_wells_oil_loss",
    "glut_downtime_injection_wells_count",
    "impulse_replacement_downtime_production_wells_count",
    "impulse_replacement_downtime_production_wells_oil_loss",
    "impulse_replacement_downtime_injection_wells_count",
    "electrical_part_downtime_production_wells_count",
    "electrical_part_downtime_production_wells_oil_loss",
    "electrical_part_downtime_injection_wells_count",
    "ground_repair_downtime_production_wells_count",
    "ground_repair_downtime_production_wells_oil_loss",
    "ground_repair_downtime_injection_wells_count",
    "periodic_downtime_production_wells_count",
    "periodic_downtime_production_wells_oil_loss",
    "periodic_downtime_injection_wells_count",
    "production_restriction_downtime_production_wells_count",
    "production_restriction_downtime_production_wells_oil_loss",
    "production_restriction_downtime_injection_wells_count",
    "well_treatment_downtime_production_wells_count",
    "well_treatment_downtime_production_wells_oil_loss",
    "well_treatment_downtime_injection_wells_count",
    "highly_watered_downtime_production_wells_count",
    "highly_watered_downtime_production_wells_oil_loss",
    "highly_watered_downtime_injection_wells_count",
    "limited_download_downtime_production_wells_count",
    "limited_download_downtime_production_wells_oil_loss",
    "limited_download_downtime_injection_wells_count",
    "profile_alignment_downtime_production_wells_count",
    "profile_alignment_downtime_production_wells_oil_loss",
    "profile_alignment_downtime_injection_wells_count",
    "coiltubing_downtime_production_wells_count",
    "coiltubing_downtime_production_wells_oil_loss",
    "coiltubing_downtime_injection_wells_count"
  ];
}