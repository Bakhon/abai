<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePipeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pipe_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->float('outside_diameter', 8, 4)->nullable();
            $table->float('inner_diameter', 8, 4)->nullable();
            $table->float('thickness', 8, 4)->nullable();
            $table->float('roughness', 8, 4)->nullable();
            $table->integer('material_id');
            $table->char('plot',10);
            $table->timestamps();
        });

        DB::statement(
            "INSERT INTO pipe_types (outside_diameter, inner_diameter, thickness, roughness, material_id, plot)
                    SELECT outside_diameter, inner_diameter, thickness, roughness, material_id, plot
                    FROM pipes"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pipe_types');
    }
}
