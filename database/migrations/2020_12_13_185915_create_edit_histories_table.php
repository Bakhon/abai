<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edit_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('entity_id');
            $table->string('entity_type');
            $table->text('payload');
            $table->timestamp('date_prev_change');
            $table->string('user');
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
        Schema::dropIfExists('edit_histories');
    }
}
