<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\ComplicationMonitoring\PipeType;

class RemoveUnusedPipeTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        PipeType::doesntHave('map_pipe')->where('id', '>', 8)->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
