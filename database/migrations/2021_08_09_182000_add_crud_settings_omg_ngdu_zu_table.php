<?php

use App\Models\CrudFieldSettings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddCrudSettingsOmgNgduZuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE crud_field_settings MODIFY COLUMN section ENUM('omgca',
                    'omgngdu',
                    'omguhe',
                    'watermeasurement',
                    'oilgas',
                    'corrosioncrud',
                    'pipes',
                    'inhibitors',
                    'pipe_types',
                    'omgngdu_well',
                    'omgngdu_zu')
                    ");

        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        CrudFieldSettings::where('section', 'omgngdu_zu')->delete();

        DB::statement("ALTER TABLE crud_field_settings MODIFY COLUMN section ENUM('omgca',
                    'omgngdu',
                    'omguhe',
                    'watermeasurement',
                    'oilgas',
                    'corrosioncrud',
                    'pipes',
                    'inhibitors',
                    'pipe_types'
                    'omgngdu_well')
                    ");
    }

    private function seed ()
    {
        $fields = [
            'pressure' => 'Давление, бар',
            'bsw' => 'Обводненность, %',
            'daily_water_production' => 'Суточная добыча воды, м3/сут',
            'daily_oil_production' => 'Суточная добыча нефти, т/сут',
            'daily_fluid_production' => 'Суточная добыча жидкости, м3/сут',
            'gas_factor' => 'Газовый фактор, м3/м3',
            'temperature' => 'Температура, °C'
        ];

        foreach ($fields as $code => $name) {
            DB::table('crud_field_settings')->insert(
                [
                    'section' => 'omgngdu_zu',
                    'field_code' => $code,
                    'field_name' => $name,
                    'min_value' => 0,
                    'max_value' => 500
                ]
            );
        }
    }
}
