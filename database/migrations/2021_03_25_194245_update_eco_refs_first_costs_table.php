<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEcoRefsFirstCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_costs', function (Blueprint $table) {
            $table->unsignedBigInteger('author_id')->nullable();
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->string('comment')->nullable();
            $table->unsignedBigInteger('log_id')->nullable();
            $table->unique(['sc_fa', 'company_id', 'date'], 'sc_company_date');

            $table->foreign('log_id')
                ->references('id')
                ->on('economic_data_logs')
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
        Schema::table('eco_refs_costs', function (Blueprint $table) {
            $table->dropUnique('sc_company_date');
            $table->dropColumn(['author_id']);
            $table->dropColumn(['editor_id']);
            $table->dropColumn(['comment']);
            $table->dropColumn(['log_id']);
        });
    }
}
