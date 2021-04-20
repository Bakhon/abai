<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLengthToFloatPipeCoordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::raw("UPDATE `pipe_coords` SET elevation = REPLACE(elevation, ',','.') ,
                         h_distance = REPLACE(h_distance, ',','.') ,
                         m_distance = REPLACE(m_distance, ',','.')");

        Schema::table('pipe_coords', function (Blueprint $table) {
            $table->float('elevation', 6, 2)->change();
            $table->float('h_distance', 7, 2)->change();
            $table->float('m_distance', 10, 7)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pipe_coords', function (Blueprint $table) {
            $table->string('elevation')->change();
            $table->string('h_distance')->change();
            $table->string('m_distance')->change();
        });
    }
}
