<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechRefsNgduTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tech_refs_ngdus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->unsignedBigInteger('field_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('field_id')
                ->references('id')
                ->on('tech_refs_fields')
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
        Schema::dropIfExists('tech_refs_ngdu');
    }
}
