<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcoRefsCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_refs_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sc_fa')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->date('date')->index();
            $table->float('variable',8,2)->nullable();
            $table->float('fix_noWRpayroll',8,2)->nullable();
            $table->float('fix_payroll',12,2)->nullable();
            $table->float('fix_nopayroll',12,2)->nullable();
            $table->float('fix',12,2)->nullable();
            $table->float('gaoverheads',12,2)->nullable();
            $table->float('wr_nopayroll',8,2)->nullable();
            $table->float('wr_payroll',8,2)->nullable();
            $table->float('wo',8,2)->nullable();
            $table->timestamps();
        });

        Schema::table('eco_refs_costs', function($table) {
            $table->foreign('sc_fa')->references('id')->on('eco_refs_sc_fas')
                ->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('eco_refs_companies_ids')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eco_refs_costs');
    }
}
