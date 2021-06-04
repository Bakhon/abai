<?php

use App\Models\ComplicationMonitoring\Well;
use Illuminate\Database\Migrations\Migration;

class ClearOldUnusedWells extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Well::whereNull('ngdu_id')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
