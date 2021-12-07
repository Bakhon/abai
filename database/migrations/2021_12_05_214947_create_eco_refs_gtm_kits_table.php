<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsGtmKitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_gtm_kits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->unsignedBigInteger('gtm_log_id');
            $table->foreign('gtm_log_id')
                ->references('id')
                ->on('economic_data_logs');

            $table->unsignedBigInteger('gtm_value_log_id');
            $table->foreign('gtm_value_log_id')
                ->references('id')
                ->on('economic_data_logs');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eco_refs_gtm_kits');
    }
}
