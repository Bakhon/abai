<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRashodColumnOmguheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('omg_u_h_e_s', function (Blueprint $table) {
            $table->float('consumption',8,4)->nullable();
            $table->float('out_of_service_оf_dosing', 8, 4)->nullable()->default(0)->change();
            $table->float('yearly_inhibitor_flowrate', 12, 4)->nullable()->default(0);
        });

        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('omg_u_h_e_s', function (Blueprint $table) {
            $table->dropColumn('consumption', 'monthly_inhibitor_flowrate');
        });
    }

    protected function seed () {
        DB::table('crud_field_settings')->insert(
            [
                'section' => 'omguhe',
                'field_code' => 'consumption',
                'field_name' => 'Расход',
                'min_value' => 0,
                'max_value' => 800
            ]
        );
    }
}
