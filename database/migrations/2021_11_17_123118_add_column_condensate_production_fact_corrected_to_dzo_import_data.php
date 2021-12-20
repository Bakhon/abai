<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCondensateProductionFactCorrectedToDzoImportData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_import_data', function (Blueprint $table) {
            $table->float("condensate_production_fact_corrected",32,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dzo_import_data', function (Blueprint $table) {
            $table->dropColumn(
                'condensate_production_fact_corrected'
            );
        });
    }
}
