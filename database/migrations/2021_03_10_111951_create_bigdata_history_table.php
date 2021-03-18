<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBigdataHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'bigdata_history',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('form_name');
                $table->text('payload');
                $table->timestamp('date')->nullable();
                $table->string('row_id')->nullable();
                $table->unsignedBigInteger('user_id');

                $table->foreign('user_id')->references('id')->on('users');

                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bigdata_history');
    }
}
