<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntiEcoOnesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anti_eco_ones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sc_fa');
            $table->integer('company_id');
            $table->date('dbeg');
            $table->date('dend');
            $table->float('bar_coef_exp_one',8,4);
            $table->float('bar_coef_exp_two',8,4);
            $table->float('bar_coef_exp_three',8,4);
            $table->float('bar_coef_ins_one',8,4);
            $table->float('bar_coef_ins_two',8,4);
            $table->float('sales_share_exp_one',8,4);
            $table->float('sales_share_exp_two',8,4);
            $table->float('sales_share_exp_three',8,4);
            $table->float('sales_share_ins_one',8,4);
            $table->float('sales_share_ins_two',8,4);
            $table->float('disc_exp_one',8,4);
            $table->float('disc_exp_two',8,4);
            $table->float('disc_exp_three',8,4);
            $table->float('disc_ins_one',8,4);
            $table->float('disc_ins_two',8,4);
            $table->float('trans_exp_cost_one',8,4);
            $table->float('trans_exp_cost_two',8,4);
            $table->float('trans_exp_cost_three',8,4);
            $table->float('trans_ins_cost_one',8,4);
            $table->float('trans_ins_cost_two',8,4);
            $table->float('var_cost_one',8,4);
            $table->float('var_cost_two',8,4);
            $table->float('fix_cost_one',8,4);
            $table->float('fix_cost_two',8,4);
            $table->float('fix_cost_three',8,4);
            $table->float('fix_cost_four',8,4);
            $table->float('adm_exp',8,4);
            $table->float('avg_prs_cost',8,4);
            $table->float('fot_prs',8,4);
            $table->float('avg_prs_cost_fot',8,4);
            $table->float('avg_krs_cost',8,4);
            $table->float('amort',8,4);
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
        Schema::dropIfExists('anti_eco_ones');
    }
}
