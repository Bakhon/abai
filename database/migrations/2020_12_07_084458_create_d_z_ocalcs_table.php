<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDZOcalcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_z_ocalcs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('dzo')->nullable();
            $table->dateTime('date',0);
            $table->text('__time');
            $table->float('main_prc_val_plan',30,4)->nullable();
            $table->float('spending_val_plan',30,4)->nullable();
            $table->float('cost_val_plan',30,4)->nullable();
            $table->float('rlz_spending_val_plan',30,4)->nullable();
            $table->float('adm_spending_val_plan',30,4)->nullable();
            $table->float('net_profit_val_plan',30,4)->nullable();
            $table->float('editba_val_plan',30,4)->nullable();
            $table->float('editba_margin_val_plan',30,4)->nullable();
            $table->float('capital_inv_val_plan',30,4)->nullable();
            $table->float('cash_flow_val_plan',30,4)->nullable();
            $table->float('ud_income_val_plan',30,4)->nullable();
            $table->float('ud_income_bbl_val_plan',30,4)->nullable();
            $table->float('ud_spending_val_plan',30,4)->nullable();
            $table->float('ud_spending_bbl_val_plan',30,4)->nullable();
            $table->float('kvl_val_plan',30,4)->nullable();
            $table->float('oil_val_plan',30,4)->nullable();
            $table->float('main_prc_val_fact',30,4)->nullable();
            $table->float('spending_val_fact',30,4)->nullable();
            $table->float('cost_val_fact',30,4)->nullable();
            $table->float('rlz_spending_val_fact',30,4)->nullable();
            $table->float('adm_spending_val_fact',30,4)->nullable();
            $table->float('net_profit_val_fact',30,4)->nullable();
            $table->float('editba_val_fact',30,4)->nullable();
            $table->float('editba_margin_val_fact',30,4)->nullable();
            $table->float('capital_inv_val_fact',30,4)->nullable();
            $table->float('cash_flow_val_fact',30,4)->nullable();
            $table->float('ud_income_val_fact',30,4)->nullable();
            $table->float('ud_income_bbl_val_fact',30,4)->nullable();
            $table->float('ud_spending_val_fact',30,4)->nullable();
            $table->float('ud_spending_bbl_val_fact',30,4)->nullable();
            $table->float('kvl_val_fact',30,4)->nullable();
            $table->float('oil_val_fact',30,4)->nullable();
            $table->float('main_prc_plan_2020',30,4)->nullable();
            $table->float('spending_plan_2020',30,4)->nullable();
            $table->float('cost_plan_2020',30,4)->nullable();
            $table->float('rlz_spending_plan_2020',30,4)->nullable();
            $table->float('adm_spending_plan_2020',30,4)->nullable();
            $table->float('net_profit_plan_2020',30,4)->nullable();
            $table->float('editba_plan_2020',30,4)->nullable();
            $table->float('editba_margin_plan_2020',30,4)->nullable();
            $table->float('capital_inv_plan_2020',30,4)->nullable();
            $table->float('cash_flow_plan_2020',30,4)->nullable();
            $table->float('ud_income_plan_2020',30,4)->nullable();
            $table->float('ud_income_bbl_plan_2020',30,4)->nullable();
            $table->float('ud_spending_plan_2020',30,4)->nullable();
            $table->float('ud_spending_bbl_plan_2020',30,4)->nullable();
            $table->float('kvl_plan_2020',30,4)->nullable();
            $table->float('oil_plan_2020',30,4)->nullable();
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
        Schema::dropIfExists('d_z_ocalcs');
    }
}
