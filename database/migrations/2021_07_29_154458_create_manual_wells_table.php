<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualWellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_wells', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ngdu_id');
            $table->string('name')->nullable();
            $table->unsignedBigInteger('zu_id');
            $table->unsignedBigInteger('gu_id');
            $table->float('elevation', 6, 2)->nullable();
            $table->float('lat', 12, 10)->nullable();
            $table->float('lon', 12, 10)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('manual_wells');
    }
}
