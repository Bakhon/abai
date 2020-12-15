<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('omg_n_g_d_u_s', function (Blueprint $table) {

            $table->bigInteger('field_id')->unsigned()->change();
            $table->bigInteger('gu_id')->unsigned()->change();
            $table->bigInteger('ngdu_id')->unsigned()->change();
            $table->bigInteger('cdng_id')->unsigned()->change();
            $table->bigInteger('zu_id')->unsigned()->change();
            $table->bigInteger('well_id')->unsigned()->change();

            $table->foreign('field_id')->references('id')->on('fields')->onDelete('set null');
            $table->foreign('gu_id')->references('id')->on('gus')->onDelete('set null');
            $table->foreign('ngdu_id')->references('id')->on('ngdus')->onDelete('set null');
            $table->foreign('cdng_id')->references('id')->on('cdngs')->onDelete('set null');
            $table->foreign('zu_id')->references('id')->on('zus')->onDelete('set null');
            $table->foreign('well_id')->references('id')->on('wells')->onDelete('set null');
        });

        Schema::table('omg_u_h_e_s', function (Blueprint $table) {

            $table->bigInteger('gu_id')->unsigned()->change();
            $table->bigInteger('ngdu_id')->unsigned()->change();
            $table->bigInteger('cdng_id')->unsigned()->change();
            $table->bigInteger('zu_id')->unsigned()->change();
            $table->bigInteger('well_id')->unsigned()->change();

            $table->foreign('gu_id')->references('id')->on('gus')->onDelete('set null');
            $table->foreign('ngdu_id')->references('id')->on('ngdus')->onDelete('set null');
            $table->foreign('cdng_id')->references('id')->on('cdngs')->onDelete('set null');
            $table->foreign('zu_id')->references('id')->on('zus')->onDelete('set null');
            $table->foreign('well_id')->references('id')->on('wells')->onDelete('set null');
        });

        Schema::table('omg_c_a_s', function (Blueprint $table) {

            $table->bigInteger('gu_id')->unsigned()->change();
            $table->bigInteger('ngdu_id')->unsigned()->change();
            $table->bigInteger('cdng_id')->unsigned()->change();
            $table->bigInteger('zu_id')->unsigned()->change();
            $table->bigInteger('well_id')->unsigned()->change();

            $table->foreign('gu_id')->references('id')->on('gus')->onDelete('set null');
            $table->foreign('ngdu_id')->references('id')->on('ngdus')->onDelete('set null');
            $table->foreign('cdng_id')->references('id')->on('cdngs')->onDelete('set null');
            $table->foreign('zu_id')->references('id')->on('zus')->onDelete('set null');
            $table->foreign('well_id')->references('id')->on('wells')->onDelete('set null');
        });

        Schema::table('water_measurements', function (Blueprint $table) {

            $table->bigInteger('water_type_by_sulin_id')->unsigned()->change();
            $table->bigInteger('thionic_bacteria_id')->unsigned()->change();
            $table->bigInteger('hydrocarbon_oxidizing_bacteria_id')->unsigned()->change();
            $table->bigInteger('sulphate_reducing_bacteria_id')->unsigned()->change();
            $table->bigInteger('other_objects_id')->unsigned()->change();
            $table->bigInteger('gu_id')->unsigned()->change();
            $table->bigInteger('ngdu_id')->unsigned()->change();
            $table->bigInteger('cdng_id')->unsigned()->change();
            $table->bigInteger('zu_id')->unsigned()->change();
            $table->bigInteger('well_id')->unsigned()->change();

            $table->foreign('water_type_by_sulin_id')->references('id')->on('water_type_by_sulins')->onDelete('set null');
            $table->foreign('thionic_bacteria_id')->references('id')->on('thionic_bacterias')->onDelete('set null');
            $table->foreign('hydrocarbon_oxidizing_bacteria_id')->references('id')->on('hydrocarbon_oxidizing_bacterias')->onDelete('set null');
            $table->foreign('sulphate_reducing_bacteria_id')->references('id')->on('sulphate_reducing_bacterias')->onDelete('set null');
            $table->foreign('other_objects_id')->references('id')->on('other_objects')->onDelete('set null');
            $table->foreign('gu_id')->references('id')->on('gus')->onDelete('set null');
            $table->foreign('ngdu_id')->references('id')->on('ngdus')->onDelete('set null');
            $table->foreign('cdng_id')->references('id')->on('cdngs')->onDelete('set null');
            $table->foreign('zu_id')->references('id')->on('zus')->onDelete('set null');
            $table->foreign('well_id')->references('id')->on('wells')->onDelete('set null');
        });

        Schema::table('oil_gases', function (Blueprint $table) {

            $table->bigInteger('other_objects_id')->unsigned()->change();
            $table->bigInteger('gu_id')->unsigned()->change();
            $table->bigInteger('ngdu_id')->unsigned()->change();
            $table->bigInteger('cdng_id')->unsigned()->change();
            $table->bigInteger('zu_id')->unsigned()->change();
            $table->bigInteger('well_id')->unsigned()->change();

            $table->foreign('other_objects_id')->references('id')->on('other_objects')->onDelete('set null');
            $table->foreign('gu_id')->references('id')->on('gus')->onDelete('set null');
            $table->foreign('ngdu_id')->references('id')->on('ngdus')->onDelete('set null');
            $table->foreign('cdng_id')->references('id')->on('cdngs')->onDelete('set null');
            $table->foreign('zu_id')->references('id')->on('zus')->onDelete('set null');
            $table->foreign('well_id')->references('id')->on('wells')->onDelete('set null');
        });

        Schema::table('corrosions', function (Blueprint $table) {
            $table->bigInteger('gu_id')->unsigned()->change();
            $table->bigInteger('ngdu_id')->unsigned()->change();
            $table->bigInteger('cdng_id')->unsigned()->change();

            $table->foreign('gu_id')->references('id')->on('gus')->onDelete('set null');
            $table->foreign('ngdu_id')->references('id')->on('ngdus')->onDelete('set null');
            $table->foreign('cdng_id')->references('id')->on('cdngs')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('omg_n_g_d_u_s', function (Blueprint $table) {
            $table->dropForeign('omg_n_g_d_u_s_field_id_foreign');
            $table->dropIndex('omg_n_g_d_u_s_field_id_foreign');
            $table->dropForeign('omg_n_g_d_u_s_gu_id_foreign');
            $table->dropIndex('omg_n_g_d_u_s_gu_id_foreign');
            $table->dropForeign('omg_n_g_d_u_s_ngdu_id_foreign');
            $table->dropIndex('omg_n_g_d_u_s_ngdu_id_foreign');
            $table->dropForeign('omg_n_g_d_u_s_cdng_id_foreign');
            $table->dropIndex('omg_n_g_d_u_s_cdng_id_foreign');
            $table->dropForeign('omg_n_g_d_u_s_zu_id_foreign');
            $table->dropIndex('omg_n_g_d_u_s_zu_id_foreign');
            $table->dropForeign('omg_n_g_d_u_s_well_id_foreign');
            $table->dropIndex('omg_n_g_d_u_s_well_id_foreign');
        });

        Schema::table('omg_u_h_e_s', function (Blueprint $table) {
            $table->dropForeign('omg_u_h_e_s_gu_id_foreign');
            $table->dropIndex('omg_u_h_e_s_gu_id_foreign');
            $table->dropForeign('omg_u_h_e_s_ngdu_id_foreign');
            $table->dropIndex('omg_u_h_e_s_ngdu_id_foreign');
            $table->dropForeign('omg_u_h_e_s_cdng_id_foreign');
            $table->dropIndex('omg_u_h_e_s_cdng_id_foreign');
            $table->dropForeign('omg_u_h_e_s_zu_id_foreign');
            $table->dropIndex('omg_u_h_e_s_zu_id_foreign');
            $table->dropForeign('omg_u_h_e_s_well_id_foreign');
            $table->dropIndex('omg_u_h_e_s_well_id_foreign');
        });

        Schema::table('omg_c_a_s', function (Blueprint $table) {
            $table->dropForeign('omg_c_a_s_gu_id_foreign');
            $table->dropIndex('omg_c_a_s_gu_id_foreign');
            $table->dropForeign('omg_c_a_s_ngdu_id_foreign');
            $table->dropIndex('omg_c_a_s_ngdu_id_foreign');
            $table->dropForeign('omg_c_a_s_cdng_id_foreign');
            $table->dropIndex('omg_c_a_s_cdng_id_foreign');
            $table->dropForeign('omg_c_a_s_zu_id_foreign');
            $table->dropIndex('omg_c_a_s_zu_id_foreign');
            $table->dropForeign('omg_c_a_s_well_id_foreign');
            $table->dropIndex('omg_c_a_s_well_id_foreign');
        });

        Schema::table('water_measurements', function (Blueprint $table) {
            $table->dropForeign('water_measurements_water_type_by_sulin_id_foreign');
            $table->dropIndex('water_measurements_water_type_by_sulin_id_foreign');
            $table->dropForeign('water_measurements_thionic_bacteria_id_foreign');
            $table->dropIndex('water_measurements_thionic_bacteria_id_foreign');
            $table->dropForeign('water_measurements_hydrocarbon_oxidizing_bacteria_id_foreign');
            $table->dropIndex('water_measurements_hydrocarbon_oxidizing_bacteria_id_foreign');
            $table->dropForeign('water_measurements_sulphate_reducing_bacteria_id_foreign');
            $table->dropIndex('water_measurements_sulphate_reducing_bacteria_id_foreign');
            $table->dropForeign('water_measurements_other_objects_id_foreign');
            $table->dropIndex('water_measurements_other_objects_id_foreign');
            $table->dropForeign('water_measurements_gu_id_foreign');
            $table->dropIndex('water_measurements_gu_id_foreign');
            $table->dropForeign('water_measurements_ngdu_id_foreign');
            $table->dropIndex('water_measurements_ngdu_id_foreign');
            $table->dropForeign('water_measurements_cdng_id_foreign');
            $table->dropIndex('water_measurements_cdng_id_foreign');
            $table->dropForeign('water_measurements_zu_id_foreign');
            $table->dropIndex('water_measurements_zu_id_foreign');
            $table->dropForeign('water_measurements_well_id_foreign');
            $table->dropIndex('water_measurements_well_id_foreign');
        });

        Schema::table('oil_gases', function (Blueprint $table) {
            $table->dropForeign('oil_gases_other_objects_id_foreign');
            $table->dropIndex('oil_gases_other_objects_id_foreign');
            $table->dropForeign('oil_gases_gu_id_foreign');
            $table->dropIndex('oil_gases_gu_id_foreign');
            $table->dropForeign('oil_gases_ngdu_id_foreign');
            $table->dropIndex('oil_gases_ngdu_id_foreign');
            $table->dropForeign('oil_gases_cdng_id_foreign');
            $table->dropIndex('oil_gases_cdng_id_foreign');
            $table->dropForeign('oil_gases_zu_id_foreign');
            $table->dropIndex('oil_gases_zu_id_foreign');
            $table->dropForeign('oil_gases_well_id_foreign');
            $table->dropIndex('oil_gases_well_id_foreign');
        });

        Schema::table('corrosions', function (Blueprint $table) {
            $table->dropForeign('corrosions_gu_id_foreign');
            $table->dropIndex('corrosions_gu_id_foreign');
            $table->dropForeign('corrosions_ngdu_id_foreign');
            $table->dropIndex('corrosions_ngdu_id_foreign');
            $table->dropForeign('corrosions_cdng_id_foreign');
            $table->dropIndex('corrosions_cdng_id_foreign');
        });
    }
}
