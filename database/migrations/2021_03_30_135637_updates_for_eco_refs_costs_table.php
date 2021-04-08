<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatesForEcoRefsCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_refs_costs', function (Blueprint $table) {
            $table->float('variable',12,5)->change();
            $table->float('fix_noWRpayroll',12,5)->change();
            $table->float('fix_payroll',12,5)->change();
            $table->float('fix_nopayroll',12,5)->change();
            $table->float('fix',12,5)->change();
            $table->float('gaoverheads',12,5)->change();
            $table->float('wr_nopayroll',8,5)->change();
            $table->float('wr_payroll',8,5)->change();
            $table->float('wo',8,5)->change();
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
            $table->float('variable',8,2)->change();
            $table->float('fix_noWRpayroll',8,2)->change();
            $table->float('fix_payroll',12,2)->change();
            $table->float('fix_nopayroll',12,2)->change();
            $table->float('fix',12,2)->change();
            $table->float('gaoverheads',12,2)->change();
            $table->float('wr_nopayroll',8,2)->change();
            $table->float('wr_payroll',8,2)->change();
            $table->float('wo',8,2)->change();
        });
    }
}
