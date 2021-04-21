<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToDzoImportFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_import_fields', function (Blueprint $table) {
            $table->float("associated_gas_receive_kaspiy_aral_fact",32,8)->nullable();
            $table->float("associated_gas_raw_fact",32,8)->nullable();
            $table->float("associated_gas_delivery_commercial_gas_fact",32,8)->nullable();
            $table->float("associated_gas_expenses_for_own_losses_fact",32,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dzo_import_fields', function (Blueprint $table) {
            $table->dropColumn(
                'associated_gas_receive_kaspiy_aral_fact',
                'associated_gas_raw_fact',
                'associated_gas_delivery_commercial_gas_fact',
                "associated_gas_expenses_for_own_losses_fact"
            );
        });
    }
}
