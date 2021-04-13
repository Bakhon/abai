<?php

use App\Models\CrudFieldSettings;
use Illuminate\Database\Migrations\Migration;

class AddPipeTypesValidationParams extends Migration
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
                    'pipe_types')
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
        CrudFieldSettings::where('section', 'pipe_types')->delete();

        DB::statement("ALTER TABLE crud_field_settings MODIFY COLUMN section ENUM('omgca',
                    'omgngdu',
                    'omguhe',
                    'watermeasurement',
                    'oilgas',
                    'corrosioncrud',
                    'pipes',
                    'inhibitors')
                    ");
    }

    private function seed ()
    {
        $fields = [
            'outside_diameter' => 'Внешний диаметр',
            'inner_diameter' => 'Внутренний диаметр',
            'thickness' => 'Толщина стенок',
            'roughness' => 'Жесткость',
        ];

        foreach ($fields as $code => $name) {
            DB::table('crud_field_settings')->insert(
                [
                    'section' => 'pipe_types',
                    'field_code' => $code,
                    'field_name' => $name,
                    'min_value' => 0,
                    'max_value' => 500
                ]
            );
        }
    }
}
