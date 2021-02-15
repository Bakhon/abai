<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVis2FormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vis2_forms', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('date');
            $table->text('__time');
            $table->float('oil_fact',8,4)->nullable();
            $table->float('gk_fact',8,4)->nullable();
            $table->float('oil_dlv_fact',8,4)->nullable();
            $table->float('sdacha_nefti_condensat_fact',8,4)->nullable();
            $table->float('gas_fact',16,4)->nullable();
            $table->float('dobycha_gaza_total_prirodnyi_fact',8,4)->nullable();
            $table->float('dobycha_gaza_gazovyie_mest_dzo_fact',8,4)->nullable();
            $table->float('dobycha_gaza_gsp_dzo_fact',8,4)->nullable();
            $table->float('dobycha_gaza_poputnyi_fact',8,4)->nullable();
            $table->float('zakachka_vody_total_fact',8,4)->nullable();
            $table->float('zakachka_vody_tch_morskaya_fact',8,4)->nullable();
            $table->float('zakachka_vody_stochnaya_fact',8,4)->nullable();
            $table->float('burenie_skvajin_prohodka_fact',8,4)->nullable();
            $table->float('tovarnyi_ostatok',8,4)->nullable();

            $table->integer('dzo');

            $table->integer('expl')->nullable();
            $table->integer('prod_wells_work')->nullable();
            $table->integer('prod_wells_idle')->nullable();
            $table->integer('b_d')->nullable();
            $table->integer('obustroystvo')->nullable();
            $table->integer('ozhidanie_likvidacii')->nullable();
            $table->integer('v_konservacii')->nullable();

            $table->integer('expl2')->nullable();
            $table->integer('inj_wells_work')->nullable();
            $table->integer('inj_wells_idle')->nullable();
            $table->integer('b_d2')->nullable();
            $table->integer('osvoenie')->nullable();
            $table->integer('ozhidanie_likvidacii2')->nullable();
            $table->integer('v_konservacii2')->nullable();

            $table->float('ngdu',8,4)->nullable();
            $table->float('gu',8,4)->nullable();
            $table->integer('well_number')->nullable();
            $table->time('shutdown_time')->nullable();
            $table->time('turnon_time')->nullable();
            $table->float('qzh_loss',8,4)->nullable();
            $table->float('qn_loss',8,4)->nullable();
            $table->time('prostoy_time')->nullable();
            $table->text('emerg_shutdown_reason')->nullable();

            $table->float('oprs',8,4)->nullable();
            $table->float('prs',8,4)->nullable();
            $table->float('okrs',8,4)->nullable();
            $table->float('krs',8,4)->nullable();
            $table->float('wells_study',8,4)->nullable();
            $table->float('unprofitable',8,4)->nullable();
            $table->float('mining_wells_restriction',8,4)->nullable();
            $table->float('others',8,4)->nullable();

            $table->float("oil_plan",32,8)->nullable();
            $table->float("gk_plan",32,8)->nullable();	
            $table->float("liq_plan",32,8)->nullable();
            $table->float("gas_plan",32,8)->nullable();
            $table->float("inj_plan",32,8)->nullable();
            $table->float("oil_dlv_plan",32,8)->nullable();
            $table->float("liq_fact",32,8)->nullable();
            $table->float("inj_fact",32,8)->nullable();

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
        Schema::dropIfExists('vis2_forms');
    }
}
