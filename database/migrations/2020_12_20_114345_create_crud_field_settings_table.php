<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCrudFieldSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'crud_field_settings',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->enum(
                    'section',
                    [
                        'omgca',
                        'omgngdu',
                        'omguhe',
                        'watermeasurement',
                        'oilgas',
                        'corrosioncrud',
                        'pipes',
                        'inhibitors'
                    ]
                );
                $table->string('field_code');
                $table->string('field_name');
                $table->float('min_value')->nullable();
                $table->float('max_value')->nullable();
                $table->timestamps();
            }
        );

        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crud_field_settings');
    }

    private function seed()
    {
        $data = [
            'omgca' => [
                'plan_dosage' => 'Планируемая дозировка, г/м³',
                'q_v' => 'Техрежим Qв, тыс.м³/год'
            ],
            'omgngdu' => [
                'daily_fluid_production' => 'Суточная добыча жидкости, м3/сут',
                'daily_water_production' => 'Суточная добыча воды, м3/сут',
                'daily_oil_production' => 'Суточная добыча нефти, т/сут',
                'daily_gas_production_in_sib' => 'Количество газа в СИБ, ст.м3/сут',
                'bsw' => 'Обводненность, %',
                'surge_tank_pressure' => 'Давление в буферной емкости, бар',
                'pump_discharge_pressure' => 'Давление на выходе насоса, бар',
                'heater_inlet_pressure' => 'Температура на входе в печь, С',
                'heater_output_pressure' => 'Температура на выходе из печи, С',
            ],
            'omguhe' => [
                'level' => 'Заправка',
                'fill' => 'Уровень',
            ],
            'watermeasurement' => [
                'hydrocarbonate_ion' => 'НСО3-',
                'carbonate_ion' => 'СО32-',
                'sulphate_ion' => 'SO42-',
                'chlorum_ion' => 'Cl-',
                'calcium_ion' => 'Ca2+',
                'magnesium_ion' => 'Mg2+',
                'potassium_ion_sodium_ion' => 'Na+K+',
                'density' => 'Плотность при 20°С, г/см³',
                'ph' => 'рН',
                'mineralization' => 'Общая минерализация, мг/дм³',
                'total_hardness' => 'Общая жесткость, мг-экв/дм³',
                'content_of_petrolium_products' => 'Содержание нефтепродуктов, мг/дм³',
                'mechanical_impurities' => 'Механические примеси, мг/дм³',
                'strontium_content' => 'Содержание стронция, мг/дм³',
                'barium_content' => 'Содержание бария, мг/дм³',
                'total_iron_content' => 'Содержание общего железа мг/дм³',
                'ferric_iron_content' => 'Содержание трехвалентного железа мг/дм³',
                'ferrous_iron_content' => 'Содержание двухвалентного железа мг/дм³',
                'hydrogen_sulfide' => 'H₂S, мг/дм³ (после буферной емкости)',
                'oxygen' => 'О₂, мг/дм³',
                'carbon_dioxide' => 'CO₂, мг/дм³ (после буферной емкости)',
            ],
            'oilgas' => [
                'water_density_at_20' => 'Плотность нефти при 20°С, кг/м3',
                'oil_viscosity_at_20' => 'Вязкость нефти при 20°С, мм²/с',
                'oil_viscosity_at_40' => 'Вязкость нефти при 40°С, мм²/с',
                'oil_viscosity_at_50' => 'Вязкость нефти при 50°С, мм²/с',
                'oil_viscosity_at_60' => 'Вязкость нефти при 60°С, мм²/с',
                'hydrogen_sulfide_in_gas' => 'H₂S в газе, ppm',
                'oxygen_in_gas' => 'О₂ в газе, %',
                'carbon_dioxide_in_gas' => 'CO₂ в газе, %',
                'gas_density_at_20' => 'Плотность газа при 20°С, кг/м³',
                'gas_viscosity_at_20' => 'Вязкость газа при 20°С, сП',
            ],
            'corrosioncrud' => [
                'background_corrosion_velocity' => 'Фоновая скорость',
                'corrosion_velocity_with_inhibitor' => 'Скорость коррозии',
                'weight_before' => 'Масса до установки, гр',
                'days' => 'Количество дней экспозиции',
                'weight_after' => 'Масса после извлечения, гр',
                'avg_speed' => 'Средняя скорость коррозии, мм/г',
            ],
            'pipes' => [
                'length' => 'Длина',
                'outside_diameter' => 'Внешний диаметр',
                'inner_diameter' => 'Внутренний диаметр',
                'thickness' => 'Толщина стенок',
                'roughness' => 'Жесткость',
            ],
            'inhibitors' => [
                'price' => 'Цена',
            ],
        ];

        foreach ($data as $section => $fields) {
            foreach ($fields as $code => $name) {
                DB::table('crud_field_settings')->insert(
                    [
                        'section' => $section,
                        'field_code' => $code,
                        'field_name' => $name,
                    ]
                );
            }
        }
    }
}
