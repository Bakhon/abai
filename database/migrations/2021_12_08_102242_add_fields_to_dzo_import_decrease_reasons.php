<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToDzoImportDecreaseReasons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_import_decrease_reasons', function (Blueprint $table) {
            $table->renameColumn('gas_restriction_explanation_reasons', 'daily_reason_1_explanation');
            $table->renameColumn('gas_restriction_measures_taken', 'daily_reason_1_measures_taken');
            $table->renameColumn('gas_restriction_wells_number', 'daily_reason_1_wells');
            $table->renameColumn('gas_restriction_downtime', 'daily_reason_1_downtime');
            $table->renameColumn('gas_restriction_oil_losses', 'daily_reason_1_losses');
            $table->renameColumn('impulse_explanation_reasons', 'daily_reason_2_explanation');
            $table->renameColumn('impulse_measures_taken', 'daily_reason_2_measures_taken');
            $table->renameColumn('impulse_wells_number', 'daily_reason_2_wells');
            $table->renameColumn('impulse_downtime', 'daily_reason_2_downtime');
            $table->renameColumn('impulse_oil_losses', 'daily_reason_2_losses');
            $table->renameColumn('shutdown_explanation_reasons', 'daily_reason_3_explanation');
            $table->renameColumn('shutdown_measures_taken', 'daily_reason_3_measures_taken');
            $table->renameColumn('shutdown_wells_number', 'daily_reason_3_wells');
            $table->renameColumn('shutdown_downtime', 'daily_reason_3_downtime');
            $table->renameColumn('shutdown_oil_losses', 'daily_reason_3_losses');
            $table->renameColumn('other_explanation_reasons', 'daily_reason_4_explanation');
            $table->renameColumn('other_measures_taken', 'daily_reason_4_measures_taken');
            $table->renameColumn('other_wells_number', 'daily_reason_4_wells');
            $table->renameColumn('other_downtime', 'daily_reason_4_downtime');
            $table->renameColumn('other_oil_losses', 'daily_reason_4_losses');
            $table->renameColumn('restriction_kto_explanation_reasons', 'daily_reason_5_explanation');
            $table->renameColumn('restriction_kto_measures_taken', 'daily_reason_5_measures_taken');
            $table->renameColumn('restriction_kto_wells_number', 'daily_reason_5_wells');
            $table->renameColumn('restriction_kto_downtime', 'daily_reason_5_downtime');
            $table->renameColumn('restriction_kto_oil_losses', 'daily_reason_5_losses');
            $table->renameColumn('opec_explanation_reasons', 'monthly_reason_1_explanation');
            $table->renameColumn('opec_measures_taken', 'monthly_reason_1_measures_taken');
            $table->renameColumn('opec_wells_number', 'monthly_reason_1_wells');
            $table->renameColumn('opec_downtime', 'monthly_reason_1_downtime');
            $table->renameColumn('opec_oil_losses', 'monthly_reason_1_losses');
            $table->renameColumn('accident_explanation_reasons', 'monthly_reason_2_explanation');
            $table->renameColumn('accident_measures_taken', 'monthly_reason_2_measures_taken');
            $table->renameColumn('accident_wells_number', 'monthly_reason_2_wells');
            $table->renameColumn('accident_downtime', 'monthly_reason_2_downtime');
            $table->renameColumn('accident_oil_losses', 'monthly_reason_2_losses');
            $table->text("monthly_reason_3_explanation")->nullable();
            $table->text("monthly_reason_3_measures_taken")->nullable();
            $table->float("monthly_reason_3_wells",32,8)->nullable();
            $table->float("monthly_reason_3_downtime",32,8)->nullable();
            $table->float("monthly_reason_3_losses",32,8)->nullable();
            $table->text("monthly_reason_4_explanation")->nullable();
            $table->text("monthly_reason_4_measures_taken")->nullable();
            $table->float("monthly_reason_4_wells",32,8)->nullable();
            $table->float("monthly_reason_4_downtime",32,8)->nullable();
            $table->float("monthly_reason_4_losses",32,8)->nullable();
            $table->text("monthly_reason_5_explanation")->nullable();
            $table->text("monthly_reason_5_measures_taken")->nullable();
            $table->float("monthly_reason_5_wells",32,8)->nullable();
            $table->float("monthly_reason_5_downtime",32,8)->nullable();
            $table->float("monthly_reason_5_losses",32,8)->nullable();
            $table->text("yearly_reason_1_explanation")->nullable();
            $table->text("yearly_reason_1_measures_taken")->nullable();
            $table->float("yearly_reason_1_wells",32,8)->nullable();
            $table->float("yearly_reason_1_downtime",32,8)->nullable();
            $table->float("yearly_reason_1_losses",32,8)->nullable();
            $table->text("yearly_reason_2_explanation")->nullable();
            $table->text("yearly_reason_2_measures_taken")->nullable();
            $table->float("yearly_reason_2_wells",32,8)->nullable();
            $table->float("yearly_reason_2_downtime",32,8)->nullable();
            $table->float("yearly_reason_2_losses",32,8)->nullable();
            $table->text("yearly_reason_3_explanation")->nullable();
            $table->text("yearly_reason_3_measures_taken")->nullable();
            $table->float("yearly_reason_3_wells",32,8)->nullable();
            $table->float("yearly_reason_3_downtime",32,8)->nullable();
            $table->float("yearly_reason_3_losses",32,8)->nullable();
            $table->text("yearly_reason_4_explanation")->nullable();
            $table->text("yearly_reason_4_measures_taken")->nullable();
            $table->float("yearly_reason_4_wells",32,8)->nullable();
            $table->float("yearly_reason_4_downtime",32,8)->nullable();
            $table->float("yearly_reason_4_losses",32,8)->nullable();
            $table->text("yearly_reason_5_explanation")->nullable();
            $table->text("yearly_reason_5_measures_taken")->nullable();
            $table->float("yearly_reason_5_wells",32,8)->nullable();
            $table->float("yearly_reason_5_downtime",32,8)->nullable();
            $table->float("yearly_reason_5_losses",32,8)->nullable();
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
            $table->renameColumn('daily_reason_1_explanation', 'gas_restriction_explanation_reasons');
            $table->renameColumn('daily_reason_1_measures_taken', 'gas_restriction_measures_taken');
            $table->renameColumn('daily_reason_1_wells', 'gas_restriction_wells_number');
            $table->renameColumn('daily_reason_1_downtime', 'gas_restriction_downtime');
            $table->renameColumn('daily_reason_1_losses', 'gas_restriction_oil_losses');
            $table->renameColumn('daily_reason_2_explanation', 'impulse_explanation_reasons');
            $table->renameColumn('daily_reason_2_measures_taken', 'impulse_measures_taken');
            $table->renameColumn('daily_reason_2_wells', 'impulse_wells_number');
            $table->renameColumn('daily_reason_2_downtime', 'impulse_downtime');
            $table->renameColumn('daily_reason_2_losses', 'impulse_oil_losses');
            $table->renameColumn('daily_reason_3_explanation', 'shutdown_explanation_reasons');
            $table->renameColumn('daily_reason_3_measures_taken', 'shutdown_measures_taken');
            $table->renameColumn('daily_reason_3_wells', 'shutdown_wells_number');
            $table->renameColumn('daily_reason_3_downtime', 'shutdown_downtime');
            $table->renameColumn('daily_reason_3_losses', 'shutdown_oil_losses');
            $table->renameColumn('daily_reason_4_explanation', 'other_explanation_reasons');
            $table->renameColumn('daily_reason_4_measures_taken', 'other_measures_taken');
            $table->renameColumn('daily_reason_4_wells', 'other_wells_number');
            $table->renameColumn('daily_reason_4_downtime', 'other_downtime');
            $table->renameColumn('daily_reason_4_losses', 'other_oil_losses');
            $table->renameColumn('daily_reason_5_explanation', 'restriction_kto_explanation_reasons');
            $table->renameColumn('daily_reason_5_measures_taken', 'restriction_kto_measures_taken');
            $table->renameColumn('daily_reason_5_wells', 'restriction_kto_wells_number');
            $table->renameColumn('daily_reason_5_downtime', 'restriction_kto_downtime');
            $table->renameColumn('daily_reason_5_losses', 'restriction_kto_oil_losses');
            $table->renameColumn('monthly_reason_1_explanation', 'opec_explanation_reasons');
            $table->renameColumn('monthly_reason_1_measures_taken', 'opec_measures_taken');
            $table->renameColumn('monthly_reason_1_wells', 'opec_wells_number');
            $table->renameColumn('monthly_reason_1_downtime', 'opec_downtime');
            $table->renameColumn('monthly_reason_1_losses', 'opec_oil_losses');
            $table->renameColumn('monthly_reason_2_explanation', 'accident_explanation_reasons');
            $table->renameColumn('monthly_reason_2_measures_taken', 'accident_measures_taken');
            $table->renameColumn('monthly_reason_2_wells', 'accident_wells_number');
            $table->renameColumn('monthly_reason_2_downtime', 'accident_downtime');
            $table->renameColumn('monthly_reason_2_losses', 'accident_oil_losses');
            $table->dropColumn('monthly_reason_3_explanation');
            $table->dropColumn('monthly_reason_3_measures_taken');
            $table->dropColumn('monthly_reason_3_wells');
            $table->dropColumn('monthly_reason_3_downtime');
            $table->dropColumn('monthly_reason_3_losses');
            $table->dropColumn('monthly_reason_4_explanation');
            $table->dropColumn('monthly_reason_4_measures_taken');
            $table->dropColumn('monthly_reason_4_wells');
            $table->dropColumn('monthly_reason_4_downtime');
            $table->dropColumn('monthly_reason_4_losses');
            $table->dropColumn('monthly_reason_5_explanation');
            $table->dropColumn('monthly_reason_5_measures_taken');
            $table->dropColumn('monthly_reason_5_wells');
            $table->dropColumn('monthly_reason_5_downtime');
            $table->dropColumn('monthly_reason_5_losses');
            $table->dropColumn('yearly_reason_1_explanation');
            $table->dropColumn('yearly_reason_1_measures_taken');
            $table->dropColumn('yearly_reason_1_wells');
            $table->dropColumn('yearly_reason_1_downtime');
            $table->dropColumn('yearly_reason_1_losses');
            $table->dropColumn('yearly_reason_2_explanation');
            $table->dropColumn('yearly_reason_2_measures_taken');
            $table->dropColumn('yearly_reason_2_wells');
            $table->dropColumn('yearly_reason_2_downtime');
            $table->dropColumn('yearly_reason_2_losses');
            $table->dropColumn('yearly_reason_3_explanation');
            $table->dropColumn('yearly_reason_3_measures_taken');
            $table->dropColumn('yearly_reason_3_wells');
            $table->dropColumn('yearly_reason_3_downtime');
            $table->dropColumn('yearly_reason_3_losses');
            $table->dropColumn('yearly_reason_4_explanation');
            $table->dropColumn('yearly_reason_4_measures_taken');
            $table->dropColumn('yearly_reason_4_wells');
            $table->dropColumn('yearly_reason_4_downtime');
            $table->dropColumn('yearly_reason_4_losses');
            $table->dropColumn('yearly_reason_5_explanation');
            $table->dropColumn('yearly_reason_5_measures_taken');
            $table->dropColumn('yearly_reason_5_wells');
            $table->dropColumn('yearly_reason_5_downtime');
            $table->dropColumn('yearly_reason_5_losses');
        });
    }
}
