<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemp2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp2', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float("fond_nagnetat_neftedob_fls",32,8)->nullable();
            $table->float("fond_nagnetat_neftedob_konserv",32,8)->nullable();
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
        Schema::dropIfExists('temp2');
    }
}
