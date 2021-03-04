<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechRefsCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tech_refs_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('short_name', 10)->nullable();
            $table->BigInteger('tbd_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('tech_refs_company');
    }
}
