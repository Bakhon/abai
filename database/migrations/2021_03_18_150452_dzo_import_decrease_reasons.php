<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DzoImportDecreaseReasons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('dzo_import_decrease_reasons');
        Schema::create('dzo_import_decrease_reasons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('import_data_id');
            $table->text("opec_explanation_reasons");
            $table->text("opec_measures_taken");
            $table->float("opec_wells_number",32,8)->nullable();
            $table->float("opec_downtime",32,8)->nullable();
            $table->float("opec_oil_losses",32,8)->nullable();
            $table->text("impulse_explanation_reasons");
            $table->text("impulse_measures_taken");
            $table->float("impulse_wells_number",32,8)->nullable();
            $table->float("impulse_downtime",32,8)->nullable();
            $table->float("impulse_oil_losses",32,8)->nullable();
            $table->text("shutdown_explanation_reasons");
            $table->text("shutdown_measures_taken");
            $table->float("shutdown_wells_number",32,8)->nullable();
            $table->float("shutdown_downtime",32,8)->nullable();
            $table->float("shutdown_oil_losses",32,8)->nullable();
            $table->text("accident_explanation_reasons");
            $table->text("accident_measures_taken");
            $table->float("accident_wells_number",32,8)->nullable();
            $table->float("accident_downtime",32,8)->nullable();
            $table->float("accident_oil_losses",32,8)->nullable();
            $table->text("restriction_kto_explanation_reasons");
            $table->text("restriction_kto_measures_taken");
            $table->float("restriction_kto_wells_number",32,8)->nullable();
            $table->float("restriction_kto_downtime",32,8)->nullable();
            $table->float("restriction_kto_oil_losses",32,8)->nullable();
            $table->text("gas_restriction_explanation_reasons");
            $table->text("gas_restriction_measures_taken");
            $table->float("gas_restriction_wells_number",32,8)->nullable();
            $table->float("gas_restriction_downtime",32,8)->nullable();
            $table->float("gas_restriction_oil_losses",32,8)->nullable();
            $table->text("other_explanation_reasons");
            $table->text("other_measures_taken");
            $table->float("other_wells_number",32,8)->nullable();
            $table->float("other_downtime",32,8)->nullable();
            $table->float("other_oil_losses",32,8)->nullable();
        });

        Schema::table('dzo_import_decrease_reasons', function($table) {
           $table->foreign('import_data_id')->references('id')->on('dzo_import_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dzo_import_decrease_reasons');
    }
}
