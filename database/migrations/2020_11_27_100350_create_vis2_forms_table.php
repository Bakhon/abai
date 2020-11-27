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

            $table->float('dobycha_nefti_fact',8,4);
            $table->float('dobycha_nefti_condensat_fact',8,4);
            $table->float('sdacha_nefti_fact',8,4);
            $table->float('sdacha_nefti_condensat_fact',8,4);
            $table->float('dobycha_gaza_total_tch_fact',8,4);
            $table->float('dobycha_gaza_total_prirodnyi_fact',8,4);
            $table->float('dobycha_gaza_gazovyie_mest_dzo_fact',8,4);
            $table->float('dobycha_gaza_gsp_dzo_fact',8,4);
            $table->float('dobycha_gaza_poputnyi_fact',8,4);
            $table->float('zakachka_vody_total_fact',8,4);
            $table->float('zakachka_vody_tch_morskaya_fact',8,4);
            $table->float('zakachka_vody_stochnaya_fact',8,4);
            $table->float('burenie_skvajin_prohodka_fact',8,4);
            $table->float('tovarnyi_ostatok',8,4);

            $table->integer('expl');
            $table->integer('deistv');
            $table->integer('prostoy');
            $table->integer('b_d');
            $table->integer('obustroystvo');
            $table->integer('ozhidanie_likvidacii');
            $table->integer('v_konservacii');

            $table->integer('expl2');
            $table->integer('deistv2');
            $table->integer('prostoy2');
            $table->integer('b_d2');
            $table->integer('osvoenie');
            $table->integer('ozhidanie_likvidacii2');
            $table->integer('v_konservacii2');

            $table->float('ngdu',8,4);
            $table->float('gu',8,4);
            $table->integer('well_number');
            $table->time('shutdown_time');
            $table->time('turnon_time');
            $table->float('qzh_loss',8,4);
            $table->float('qn_loss',8,4);
            $table->time('prostoy_time');
            $table->text('emerg_shutdown_reason');

            $table->float('oprs',8,4);
            $table->float('prs',8,4);
            $table->float('okrs',8,4);
            $table->float('krs',8,4);
            $table->float('wells_study',8,4);
            $table->float('unprofitable',8,4);
            $table->float('mining_wells_restriction',8,4);
            $table->float('others',8,4);

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
