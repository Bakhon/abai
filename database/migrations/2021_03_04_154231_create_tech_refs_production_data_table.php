<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechRefsProductionDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tech_refs_production_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('well_id', 15)->index();
            $table->date('date')->index();
            $table->float('oil', 6, 2)->nullable();
            $table->float('liquid', 6, 2)->nullable();
            $table->float('days_worked', 5, 2)->nullable();
            $table->smallInteger('prs')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->unsignedBigInteger('gu_id')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->timestamps();

            $table->foreign('source_id')
                ->references('id')
                ->on('tech_refs_sources')
                ->onDelete('set null');

            $table->foreign('gu_id')
                ->references('id')
                ->on('tech_refs_gus')
                ->onDelete('set null');

            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('editor_id')
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
        Schema::dropIfExists('tech_refs_oil_liquid_days_prs');
    }
}
