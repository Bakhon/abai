<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncreaseFloatRangeCrudFieldSettingsTable extends Migration
{
    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crud_field_settings', function (Blueprint $table) {
            $table->decimal('min_value',12,5)->change();
        });
        Schema::table('crud_field_settings', function (Blueprint $table) {
            $table->decimal('max_value',12,5)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crud_field_settings', function (Blueprint $table) {
            $table->decimal('min_value',8,5)->change();
        });
        Schema::table('crud_field_settings', function (Blueprint $table) {
            $table->decimal('max_value',8,5)->change();
        });
    }
}
