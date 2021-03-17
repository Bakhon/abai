<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubholdingCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subholding_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('num');
            $table->string('name');
            $table->integer('level')->default(0);
            $table->integer('parent_id')->default(0);          
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
        Schema::dropIfExists('subholding_companies');
    }
}
