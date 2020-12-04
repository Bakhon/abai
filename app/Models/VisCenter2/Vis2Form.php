<?php

namespace App\Models\VisCenter2;

use Illuminate\Database\Eloquent\Model;

class Vis2Form extends Model
{
    protected $fillable = [
        "date",
        "dobycha_nefti_fact",
        'dobycha_nefti_condensat_fact',
        'sdacha_nefti_fact',
        'sdacha_nefti_condensat_fact',
        "dobycha_gaza_total_tch_fact",
        "dobycha_gaza_total_prirodnyi_fact",
        'dobycha_gaza_gazovyie_mest_dzo_fact',
        'dobycha_gaza_gsp_dzo_fact',
        'dobycha_gaza_poputnyi_fact',
        'zakachka_vody_total_fact',
        'zakachka_vody_tch_morskaya_fact',
        'zakachka_vody_stochnaya_fact',
        'burenie_skvajin_prohodka_fact',
        'tovarnyi_ostatok',

        'dzo',

        'expl',
        'deistv',
        'prostoy',
        'b_d',
        'obustroystvo',
        'ozhidanie_likvidacii',
        'v_konservacii',

        'expl2',
        'deistv2',
        'prostoy2',
        'b_d2',
        'osvoenie',
        'ozhidanie_likvidacii2',
        'v_konservacii2',

        'ngdu',
        'gu',
        'well_number',
        'shutdown_time',
        'turnon_time',
        'qzh_loss',
        'qn_loss',
        'prostoy_time',
        'emerg_shutdown_reason',

        'oprs',
        'prs',
        'okrs',
        'krs',
        'wells_study',
        'unprofitable',
        'mining_wells_restriction',
        'others'
    ];
}
