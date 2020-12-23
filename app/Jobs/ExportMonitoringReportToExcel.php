<?php

namespace App\Jobs;

use App\Models\ComplicationMonitoring\OilGas;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;
use Maatwebsite\Excel\Facades\Excel;

class ExportMonitoringReportToExcel implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Trackable;

    public $tries = 1;

    protected $dateFrom;
    protected $dateTo;
    protected $sections;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Carbon $dateFrom, Carbon $dateTo, array $sections)
    {
        $this->prepareStatus();
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->sections = $sections;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $gus = \App\Models\Refs\Gu::query()
            ->leftJoin('cdngs', 'cdngs.id', '=', 'gus.cdng_id')
            ->leftJoin('ngdus', 'ngdus.id', '=', 'cdngs.ngdu_id')
            ->select('gus.id', 'gus.name as gu_name', 'cdngs.name as cdng_name', 'ngdus.name as ngdu_name')
            ->get()
            ->keyBy('id');

        if(in_array('omgca', $this->sections)) {
            $omgCas = \App\Models\ComplicationMonitoring\OmgCA::query()
                ->where('date', '>=', (clone $this->dateFrom)->startOfYear())
                ->where('date', '<=', (clone $this->dateTo)->startOfYear())
                ->select('plan_dosage', 'q_v')
                ->selectRaw('YEAR(date) as year')
                ->get()
                ->keyBy('year');
        }

        if(in_array('omgngdu', $this->sections)) {
            $omgNgdus = \App\Models\ComplicationMonitoring\OmgNGDU::query()
                ->whereNotNull('gu_id')
                ->whereBetween('date', [$this->dateFrom, $this->dateTo])
                ->get()
                ->groupBy(
                    function ($item) {
                        return $item->gu_id . '_' . Carbon::parse($item->date)->format('Y-m-d');
                    }
                )
                ->map(
                    function ($item) {
                        return $item[0];
                    }
                );
        }

        if(in_array('omguhe', $this->sections)) {
            $omgUhes = \App\Models\ComplicationMonitoring\OmgUHE::query()
                ->whereNotNull('gu_id')
                ->whereBetween('date', [$this->dateFrom, $this->dateTo])
                ->get()
                ->groupBy(
                    function ($item) {
                        return $item->gu_id . '_' . Carbon::parse($item->date)->format('Y-m-d');
                    }
                )
                ->map(
                    function ($item) {
                        return $item[0];
                    }
                );
        }

        if(in_array('watermeasurement', $this->sections)) {
            $watermeasurements = \App\Models\ComplicationMonitoring\WaterMeasurement::query()
                ->whereNotNull('gu_id')
                ->whereBetween('date', [$this->dateFrom, $this->dateTo])
                ->get()
                ->groupBy(
                    function ($item) {
                        return $item->gu_id . '_' . Carbon::parse($item->date)->format('Y-m-d');
                    }
                )
                ->map(
                    function ($item) {
                        return $item[0];
                    }
                );
        }

        if(in_array('oilgas', $this->sections)) {
            $oilgases = \App\Models\ComplicationMonitoring\OilGas::query()
                ->whereNotNull('gu_id')
                ->whereBetween('date', [$this->dateFrom, $this->dateTo])
                ->get()
                ->groupBy(
                    function ($item) {
                        return $item->gu_id . '_' . Carbon::parse($item->date)->format('Y-m-d');
                    }
                )
                ->map(
                    function ($item) {
                        return $item[0];
                    }
                );
        }

        if(in_array('corrosions', $this->sections)) {
            $corrosions = \App\Models\ComplicationMonitoring\Corrosion::query()
                ->whereNotNull('gu_id')
                ->where('start_date_of_corrosion_velocity_with_inhibitor_measure', '<=', $this->dateTo)
                ->where('final_date_of_corrosion_velocity_with_inhibitor_measure', '>=', $this->dateFrom)
                ->get()
                ->groupBy('gu_id');
        }

        $reportData = [];
        $date = clone $this->dateFrom;
        while ($date <= $this->dateTo) {
            foreach ($gus as $gu) {
                $key = $gu->id . '_' . $date->format('Y-m-d');

                $omgNgdu = $omgUhe = $wm = $oilgas = $omgCa = $corrosion = null;

                if(!empty($omgNgdus)) {
                    $omgNgdu = $omgNgdus->get($key);
                }
                if(!empty($omgUhes)) {
                    $omgUhe = $omgUhes->get($key);
                }
                if(!empty($watermeasurements)) {
                    $wm = $watermeasurements->get($key);
                }
                if(!empty($oilgases)) {
                    $oilgas = $oilgases->get($key);
                }

                if(!empty($omgCas)) {
                    $omgCa = $omgCas->get($date->format('Y'));
                }

                if(!empty($corrosions)) {
                    $corrosion = $corrosions->get($gu->id)
                        ? $corrosions->get($gu->id)
                            ->where('start_date_of_corrosion_velocity_with_inhibitor_measure', '<=', $date)
                            ->where('final_date_of_corrosion_velocity_with_inhibitor_measure', '>=', $date)
                            ->first()
                        : null;
                }

                if(
                    empty($omgNgdu)
                    && empty($omgUhe)
                    && empty($wm)
                    && empty($oilgas)
                    && empty($corrosion)
                ) {
                    continue;
                }

                $reportData[] = [
                    'other_objects' => $wm ? ($wm->other_objects ? $wm->other_objects->name : null) : null,
                    'ngdu' => $gu->ngdu_name,
                    'cdng' => $gu->cdng_name,
                    'gu' => $gu->gu_name,
                    'date' => $date->format('Y-m-d'),
                    'plan_dosage' => $omgCa ? $omgCa->plan_dosage : null,
                    'conditions' => $omgCa ? $omgCa->q_v : null,
                    'current_dosage' => $omgUhe ? $omgUhe->current_dosage : null,
                    'daily_inhibitor_flowrate' => $omgUhe ? $omgUhe->daily_inhibitor_flowrate : null,
                    'out_of_service_оf_dosing' => $omgUhe ? $omgUhe->out_of_service_оf_dosing : null,
                    'reason' => $omgUhe ? $omgUhe->reason : null,
                    'level' => $omgUhe ? $omgUhe->level : null,
                    'fill' => $omgUhe ? $omgUhe->fill : null,
                    'inhibitor_brand' => $omgUhe ? ($omgUhe->ingibitor ? $omgUhe->ingibitor->name : null) : null,
                    'start_date_of_background_corrosion' => $corrosion ? $corrosion->start_date_of_background_corrosion : null,
                    'final_date_of_background_corrosion' => $corrosion ? $corrosion->final_date_of_background_corrosion : null,
                    'background_corrosion_velocity' => $corrosion ? $corrosion->background_corrosion_velocity : null,
                    'sample_number' => $corrosion ? $corrosion->sample_number : null,
                    'weight_before' => $corrosion ? $corrosion->weight_before : null,
                    'corrosion_days' => $corrosion ? $corrosion->days : null,
                    'weight_after' => $corrosion ? $corrosion->weight_after : null,
                    'corrosion_velocity_with_inhibitor' => $corrosion ? $corrosion->corrosion_velocity_with_inhibitor : null,
                    'avg_corrosion_speed' => $corrosion ? $corrosion->avg_speed : null,
                    'daily_fluid_production' => $omgNgdu ? $omgNgdu->daily_fluid_production : null,
                    'daily_water_production' => $omgNgdu ? $omgNgdu->daily_water_production : null,
                    'daily_oil_production' => $omgNgdu ? $omgNgdu->daily_oil_production : null,
                    'bsw' => $omgNgdu ? $omgNgdu->bsw : null,
                    'daily_gas_production_in_sib' => $omgNgdu ? $omgNgdu->daily_gas_production_in_sib : null,
                    'surge_tank_pressure' => $omgNgdu ? $omgNgdu->surge_tank_pressure : null,
                    'pump_discharge_pressure' => $omgNgdu ? $omgNgdu->pump_discharge_pressure : null,
                    'heater_inlet_pressure' => $omgNgdu ? $omgNgdu->heater_inlet_pressure : null,
                    'heater_outlet_pressure' => $omgNgdu ? $omgNgdu->heater_outlet_pressure : null,
                    'hydrocarbonate_ion' => $wm ? $wm->hydrocarbonate_ion : null,
                    'carbonate_ion' => $wm ? $wm->carbonate_ion : null,
                    'sulphate_ion' => $wm ? $wm->sulphate_ion : null,
                    'chlorum_ion' => $wm ? $wm->chlorum_ion : null,
                    'calcium_ion' => $wm ? $wm->calcium_ion : null,
                    'magnesium_ion' => $wm ? $wm->magnesium_ion : null,
                    'potassium_ion_sodium_ion' => $wm ? $wm->potassium_ion_sodium_ion : null,
                    'density' => $wm ? $wm->density : null,
                    'ph' => $wm ? $wm->ph : null,
                    'mineralization' => $wm ? $wm->mineralization : null,
                    'total_hardness' => $wm ? $wm->total_hardness : null,
                    'water_type_by_sulin' => $wm ? ($wm->water_type_by_sulin ? $wm->water_type_by_sulin->name : null) : null,
                    'content_of_petrolium_products' => $wm ? $wm->content_of_petrolium_products : null,
                    'mechanical_impurities' => $wm ? $wm->mechanical_impurities : null,
                    'strontium_content' => $wm ? $wm->strontium_content : null,
                    'barium_content' => $wm ? $wm->barium_content : null,
                    'total_iron_content' => $wm ? $wm->total_iron_content : null,
                    'ferric_iron_content' => $wm ? $wm->ferric_iron_content : null,
                    'ferrous_iron_content' => $wm ? $wm->ferrous_iron_content : null,
                    'hydrogen_sulfide' => $wm ? $wm->hydrogen_sulfide : null,
                    'oxygen' => $wm ? $wm->oxygen : null,
                    'carbon_dioxide' => $wm ? $wm->carbon_dioxide : null,
                    'sulphate_reducing_bacteria' => $wm ? ($wm->sulphate_reducing_bacteria ? $wm->sulphate_reducing_bacteria->name : null) : null,
                    'hydrocarbon_oxidizing_bacteria' => $wm ? ($wm->hydrocarbon_oxidizing_bacteria ? $wm->hydrocarbon_oxidizing_bacteria->name : null) : null,
                    'thionic_bacteria' => $wm ? ($wm->thionic_bacteria ? $wm->thionic_bacteria->name : null) : null,
                    'oil_density_at_20' => $oilgas ? $oilgas->water_density_at_20 : null,
                    'oil_viscosity_at_20' => $oilgas ? $oilgas->oil_viscosity_at_20 : null,
                    'oil_viscosity_at_40' => $oilgas ? $oilgas->oil_viscosity_at_40 : null,
                    'oil_viscosity_at_50' => $oilgas ? $oilgas->oil_viscosity_at_50 : null,
                    'oil_viscosity_at_60' => $oilgas ? $oilgas->oil_viscosity_at_60 : null,
                    'hydrogen_sulfide_in_gas' => $oilgas ? $oilgas->hydrogen_sulfide_in_gas : null,
                    'oxygen_in_gas' => $oilgas ? $oilgas->oxygen_in_gas : null,
                    'carbon_dioxide_in_gas' => $oilgas ? $oilgas->carbon_dioxide_in_gas : null,
                    'gas_density_at_20' => $oilgas ? $oilgas->gas_density_at_20 : null,
                    'gas_viscosity_at_20' => $oilgas ? $oilgas->gas_viscosity_at_20 : null,
                ];

            }

            $date->addDay();
        }

        $fileName = '/export/monitoring_report_' . Carbon::now()->format('YmdHis') . '.xlsx';
        Excel::store(new \App\Exports\MonitoringReportExport($reportData, $this->sections), 'public'.$fileName);

        $this->setOutput(
            [
                'filename' => '/storage'.$fileName
            ]
        );
    }
}
