<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDZOdailiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_z_odailies', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('a')->nullable();
            $table->float('b',8,2)->nullable();
            $table->text('c')->nullable();
            
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
        Schema::dropIfExists('d_z_odailies');
    }
}
