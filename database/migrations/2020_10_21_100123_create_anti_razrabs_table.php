<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntiRazrabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anti_razrabs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('file_name');
            $table->integer('company_id');
            $table->date('date');
            $table->float('oil_debit',8,4);
            $table->float('liquid_debit',8,4);
            $table->float('work_day',8,4);
            $table->float('prs_quant',8,4);
            $table->float('nrs_one',8,4);
            $table->float('nrs_two',8,4);
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
        Schema::dropIfExists('anti_razrabs');
    }
}
