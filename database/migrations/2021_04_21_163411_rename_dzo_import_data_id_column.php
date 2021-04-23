<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameDzoImportDataIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dzo_import_fields', function(Blueprint $table) {
            $table->renameColumn('import_data_id', 'dzo_import_data_id');
        });
        Schema::table('dzo_import_downtime_reasons', function(Blueprint $table) {
            $table->renameColumn('import_data_id', 'dzo_import_data_id');
        });
        Schema::table('dzo_import_decrease_reasons', function(Blueprint $table) {
            $table->renameColumn('import_data_id', 'dzo_import_data_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dzo_import_fields', function(Blueprint $table) {
            $table->renameColumn('dzo_import_data_id', 'import_data_id');
        });
        Schema::table('dzo_import_downtime_reasons', function(Blueprint $table) {
            $table->renameColumn('dzo_import_data_id', 'import_data_id');
        });
        Schema::table('dzo_import_decrease_reasons', function(Blueprint $table) {
            $table->renameColumn('dzo_import_data_id', 'import_data_id');
        });
    }
}
