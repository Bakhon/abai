<?php

use App\Models\CrudFieldSettings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedOmgNgduWellsCrudFieldSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CrudFieldSettings::create([
            'section' => 'omgngdu_well',
            'field_code' => 'sg_oil',
            'field_name' => 'Относительная плотность нефти',
            'min_value' => 0,
            'max_value' => 10
        ]);

        CrudFieldSettings::create([
            'section' => 'omgngdu_well',
            'field_code' => 'sg_gas',
            'field_name' => 'Относительная плотность газа',
            'min_value' => 0,
            'max_value' => 10
        ]);

        CrudFieldSettings::create([
            'section' => 'omgngdu_well',
            'field_code' => 'sg_water',
            'field_name' => 'Относительная плотность воды',
            'min_value' => 0,
            'max_value' => 10
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
