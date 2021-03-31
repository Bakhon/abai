<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetDateNullableCorrosionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corrosions', function (Blueprint $table) {
            $table->date('start_date_of_background_corrosion')->nullable()->change();
            $table->date('final_date_of_background_corrosion')->nullable()->change();
            $table->date('start_date_of_corrosion_velocity_with_inhibitor_measure')->nullable()->change();
            $table->date('final_date_of_corrosion_velocity_with_inhibitor_measure')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technical_data_forecasts', function (Blueprint $table) {
            $table->date('start_date_of_background_corrosion')->change();
            $table->date('final_date_of_background_corrosion')->change();
            $table->date('start_date_of_corrosion_velocity_with_inhibitor_measure')->change();
            $table->date('final_date_of_corrosion_velocity_with_inhibitor_measure')->change();
        });
    }
}
