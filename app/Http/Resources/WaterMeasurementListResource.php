<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WaterMeasurementListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fields' => [
                'date' => $this->date,
                'other_objects' => $this->other_objects->name,
                'ngdu' => $this->ngdu->name,
                'cdng' => $this->cdng->name,
                'gu' => $this->gu->name,
                'zu' => $this->zu->name,
                'well' => $this->well->name,
                'hydrocarbonate_ion' => $this->hydrocarbonate_ion,
                'carbonate_ion' => $this->carbonate_ion,
                'sulphate_ion' => $this->sulphate_ion,
                'chlorum_ion' => $this->chlorum_ion,
                'calcium_ion' => $this->calcium_ion,
                'magnesium_ion' => $this->magnesium_ion,
                'potassium_ion_sodium_ion' => $this->potassium_ion_sodium_ion,
                'density' => $this->density,
                'ph' => $this->ph,
                'mineralization' => $this->mineralization,
                'total_hardness' => $this->total_hardness,
                'water_type_by_sulin' => $this->waterTypeBySulin->name,
                'content_of_petrolium_products' => $this->content_of_petrolium_products,
                'mechanical_impurities' => $this->mechanical_impurities,
                'strontium_content' => $this->strontium_content,
                'barium_content' => $this->barium_content,
                'total_iron_content' => $this->total_iron_content,
                'ferric_iron_content' => $this->ferric_iron_content,
                'ferrous_iron_content' => $this->ferrous_iron_content,
                'hydrogen_sulfide' => $this->hydrogen_sulfide,
                'oxygen' => $this->oxygen,
                'carbon_dioxide' => $this->carbon_dioxide,
                'sulphate_reducing_bacteria' => $this->sulphateReducingBacteria->name,
                'hydrocarbon_oxidizing_bacteria' => $this->hydrocarbonOxidizingBacteria->name,
                'thionic_bacteria' => $this->thionicBacteria->name,
            ],
            'links' => [
                'show' => route('watermeasurement.show',$this->id),
                'edit' => route('watermeasurement.edit',$this->id),
                'history' => route('watermeasurement.history',$this->id),
                'delete' => route('watermeasurement.destroy',$this->id),
            ]
        ];

    }
}
