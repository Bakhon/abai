<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('module_state');
        Schema::create('module_state', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->text("name");
            $table->smallInteger("current_execution_percent")->nullable();
            $table->smallInteger("current_ready_percent")->nullable();
            $table->smallInteger("planning_execution_percent")->nullable();
            $table->smallInteger("planning_ready_percent")->nullable();
            $table->text("result")->nullable();
            $table->string("date",50)->nullable();
            $table->boolean("is_sub_section")->nullable();
            $table->boolean("is_header");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_state');
    }
}
