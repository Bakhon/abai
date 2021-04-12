<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNullableOptionsForDzoDecreaseReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_import_decrease_reasons', function (Blueprint $table) {
            $table->text('opec_explanation_reasons')->nullable()->change();
            $table->text('opec_measures_taken')->nullable()->change();
            $table->text('impulse_explanation_reasons')->nullable()->change();
            $table->text('impulse_measures_taken')->nullable()->change();
            $table->text('shutdown_explanation_reasons')->nullable()->change();
            $table->text('shutdown_measures_taken')->nullable()->change();
            $table->text('accident_explanation_reasons')->nullable()->change();
            $table->text('accident_measures_taken')->nullable()->change();
            $table->text('restriction_kto_explanation_reasons')->nullable()->change();
            $table->text('restriction_kto_measures_taken')->nullable()->change();
            $table->text('gas_restriction_explanation_reasons')->nullable()->change();
            $table->text('gas_restriction_measures_taken')->nullable()->change();
            $table->text('other_explanation_reasons')->nullable()->change();
            $table->text('other_measures_taken')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dzo_import_decrease_reasons', function (Blueprint $table) {
            $table->text('opec_explanation_reasons')->nullable()->change();
            $table->text('opec_measures_taken')->change();
            $table->text('impulse_explanation_reasons')->change();
            $table->text('impulse_measures_taken')->change();
            $table->text('shutdown_explanation_reasons')->change();
            $table->text('shutdown_measures_taken')->change();
            $table->text('accident_explanation_reasons')->change();
            $table->text('accident_measures_taken')->change();
            $table->text('restriction_kto_explanation_reasons')->change();
            $table->text('restriction_kto_measures_taken')->change();
            $table->text('gas_restriction_explanation_reasons')->change();
            $table->text('gas_restriction_measures_taken')->change();
            $table->text('other_explanation_reasons')->change();
            $table->text('other_measures_taken')->change();
        });
    }
}
