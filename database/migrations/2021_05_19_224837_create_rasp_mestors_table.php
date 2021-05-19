<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaspMestorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rasp_mestors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('eco_refs_companies_ids')->onDelete('cascade');
            $table->unsignedBigInteger('route_id');
            $table->foreign('route_id')->references('id')->on('eco_refs_routes_ids')->onDelete('cascade');
            $table->string('percent');
            $table->string('value');
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
        Schema::dropIfExists('rasp_mestors');
    }
}
