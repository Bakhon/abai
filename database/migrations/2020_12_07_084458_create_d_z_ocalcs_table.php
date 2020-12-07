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
            $table->text("dzo")->nullable();
            $table->text("type")->nullable();
            $table->float('jan_plan_2020',30,4)->nullable();
            $table->float('jan_fact_2020',30,4)->nullable();
            $table->float('jan_fact_2019',30,4)->nullable();
            $table->float('feb_plan_2020',30,4)->nullable();
            $table->float('feb_fact_2020',30,4)->nullable();
            $table->float('feb_fact_2019',30,4)->nullable();
            $table->float('mar_plan_2020',30,4)->nullable();
            $table->float('mar_fact_2020',30,4)->nullable();
            $table->float('mar_fact_2019',30,4)->nullable();
            $table->float('apr_plan_2020',30,4)->nullable();
            $table->float('apr_fact_2020',30,4)->nullable();
            $table->float('apr_fact_2019',30,4)->nullable();
            $table->float('may_plan_2020',30,4)->nullable();
            $table->float('may_fact_2020',30,4)->nullable();
            $table->float('may_fact_2019',30,4)->nullable();
            $table->float('jun_plan_2020',30,4)->nullable();
            $table->float('jun_fact_2020',30,4)->nullable();
            $table->float('jun_fact_2019',30,4)->nullable();
            $table->float('jul_plan_2020',30,4)->nullable();
            $table->float('jul_fact_2020',30,4)->nullable();
            $table->float('jul_fact_2019',30,4)->nullable();
            $table->float('aug_plan_2020',30,4)->nullable();
            $table->float('aug_fact_2020',30,4)->nullable();
            $table->float('aug_fact_2019',30,4)->nullable();
            $table->float('sept_plan_2020',30,4)->nullable();
            $table->float('sept_fact_2020',30,4)->nullable();
            $table->float('sept_fact_2019',30,4)->nullable();
            $table->float('oct_plan_2020',30,4)->nullable();
            $table->float('oct_fact_2020',30,4)->nullable();
            $table->float('oct_fact_2019',30,4)->nullable();
            $table->float('plan_2020',30,4)->nullable();
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
