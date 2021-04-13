<?php

use App\Models\CrudFieldSettings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOmgNGDUWellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('omg_n_g_d_u_wells', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('zu_id')->unsigned()->nullable();
            $table->bigInteger('well_id')->unsigned()->nullable();
            $table->date('date');
            $table->float('daily_fluid_production')->nullable();
            $table->float('daily_water_production')->nullable();
            $table->float('daily_oil_production')->nullable();
            $table->float('gas_factor')->nullable();
            $table->float('bsw')->nullable();
            $table->float('pressure')->nullable();
            $table->float('temperature')->nullable();
            $table->bigInteger('cruser_id');
            $table->timestamps();
        });

        Schema::table('omg_n_g_d_u_wells', function (Blueprint $table) {
            $table->foreign('zu_id')->references('id')->on('zus')->onDelete('set null');
            $table->foreign('well_id')->references('id')->on('wells')->onDelete('set null');
        });

        DB::statement("ALTER TABLE crud_field_settings MODIFY COLUMN section ENUM('omgca',
                    'omgngdu',
                    'omguhe',
                    'watermeasurement',
                    'oilgas',
                    'corrosioncrud',
                    'pipes',
                    'inhibitors',
                    'pipe_types',
                    'omgngdu_well')
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
        Schema::dropIfExists('omg_n_g_d_u_wells');

        CrudFieldSettings::where('section', 'omgngdu_well')->delete();

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
                    'section' => 'omgngdu_well',
                    'field_code' => $code,
                    'field_name' => $name,
                    'min_value' => 0,
                    'max_value' => 500
                ]
            );
        }
    }
}
