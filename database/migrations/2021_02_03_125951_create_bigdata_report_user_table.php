<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBigdataReportUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bigdata_report_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bigdata_report_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('bigdata_report_id')->references('id')->on('bigdata_reports')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bigdata_report_user');
    }
}
