<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBknsWellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bkns_wells', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('lat', 12, 10);
            $table->float('lon', 12, 10);
            $table->string('name');
            $table->float('x_point', 11, 3);
            $table->float('y_point', 11, 3);
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
        Schema::dropIfExists('bkns_wells');
    }
}
