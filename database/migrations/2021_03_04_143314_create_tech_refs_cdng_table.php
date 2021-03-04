<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechRefsCdngTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tech_refs_cdngs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->unsignedBigInteger('ngdu_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('ngdu_id')
                ->references('id')
                ->on('tech_refs_ngdus')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tech_refs_cdng');
    }
}
