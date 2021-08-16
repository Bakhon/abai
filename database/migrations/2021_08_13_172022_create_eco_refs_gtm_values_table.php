<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsGtmValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_gtm_values', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('gtm_id');
            $table->foreign('gtm_id')
                ->references('id')
                ->on('eco_refs_gtms');

            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')
                ->references('id')
                ->on('users');

            $table->date('date');
            $table->unsignedInteger('priority');
            $table->float('growth', 12, 2);
            $table->unsignedInteger('amount');
            $table->string('comment')->nullable();

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
        Schema::dropIfExists('eco_refs_gtm_values');
    }
}
