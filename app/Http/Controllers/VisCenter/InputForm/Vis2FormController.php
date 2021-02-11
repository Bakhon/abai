<?php

namespace App\Http\Controllers\VisCenter\InputForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ImportForms\DZOdaily;
use Carbon\Carbon;

class Vis2FormController extends Controller
{
    public function create()
    {
        return 'created';
    }
    public function store(Request $request)
    {
        $alldata = new DZOdaily;

        $alldata->date = Carbon::yesterday();
        $alldata->__time =  (Carbon::now())->getTimestamp() * 1000 - 86400000;
        $alldata->oil_fact = $request->input('dobycha_nefti_fact');
        $alldata->gk_fact = $request->input('dobycha_nefti_condensat_fact');
        $alldata->oil_dlv_fact = $request->input('sdacha_nefti_fact');
        // $alldata->gk_fact = $request->input('sdacha_nefti_condensat_fact');
        $alldata->gas_fact = $request->input('dobycha_gaza_total_tch_fact');
        $alldata->dobycha_gaza_prirod_fact = $request->input('dobycha_gaza_total_prirodnyi_fact');
        // $alldata->dobycha_gaza_gazovyie_mest_dzo_fact = $request->input('dobycha_gaza_gazovyie_mest_dzo_fact');
        // $alldata->dobycha_gaza_gsp_dzo_fact = $request->input('dobycha_gaza_gsp_dzo_fact');
        $alldata->dobycha_gaza_poput_fact = $request->input('dobycha_gaza_poputnyi_fact');
        $alldata->liq_fact = $request->input('zakachka_vody_total_fact');
        $alldata->ppd_zakachka_morskoi_vody_fact = $request->input('zakachka_vody_tch_morskaya_fact');
        $alldata->ppd_zakachka_stochnoi_vody_fact = $request->input('zakachka_vody_stochnaya_fact');
        $alldata->otm_burenie_prohodka_fact = $request->input('burenie_skvajin_prohodka_fact');
        $alldata->tovarnyi_ostatok_nefti_today = $request->input('tovarnyi_ostatok');

        $alldata->dzo = $request->input('dzo');

        $alldata->ngdu = $request->input('ngdu');
        // $alldata->gu = $request->input('gu');
        // $alldata->well_number = $request->input('well_number');
        // $alldata->shutdown_time = $request->input('shutdown_time');
        // $alldata->turnon_time = $request->input('turnon_time');
        // $alldata->qzh_loss = $request->input('qzh_loss');
        // $alldata->qn_loss = $request->input('qn_loss');
        // $alldata->prostoy_time = $request->input('prostoy_time');
        // $alldata->accident = $request->input('emerg_shutdown_reason');

        $alldata->fond_neftedob_oprs = $request->input('oprs');
        $alldata->fond_neftedob_prs = $request->input('prs');
        $alldata->fond_neftedob_okrs = $request->input('okrs');
        $alldata->fond_neftedob_krs = $request->input('krs');
        $alldata->fond_neftedob_well_survey = $request->input('wells_study');
        // $alldata->unprofitable = $request->input('unprofitable');
        // $alldata->mining_wells_restriction = $request->input('mining_wells_restriction');
        $alldata->fond_neftedob_others = $request->input('others');

        $alldata->fond_neftedob_ef = $request->input('expl');
        $alldata->prod_wells_work = $request->input('deistv');
        $alldata->prod_wells_idle = $request->input('prostoy');
        $alldata->fond_neftedob_bd = $request->input('b_d');
        $alldata->fond_neftedob_osvoenie = $request->input('osvoenie');
        $alldata->fond_neftedob_ofls = $request->input('ozhidanie_likvidacii');
        // $alldata->fond_neftedob_konv = $request->input('v_konservacii');


        $alldata->fond_nagnetat_ef = $request->input('expl2');
        $alldata->inj_wells_work = $request->input('deistv2');
        $alldata->inj_wells_idle = $request->input('prostoy2');
        $alldata->fond_nagnetat_bd = $request->input('b_d2');
        $alldata->fond_nagnetat_osvoenie = $request->input('obustroystvo');
        $alldata->fond_nagnetat_ofls = $request->input('ozhidanie_likvidacii2');
        $alldata->fond_nagnetat_konv = $request->input('v_konservacii2');


        $alldata->oil_plan = '38640';
        $alldata->oil_dlv_plan = '5873';
        $alldata->gk_plan = '15';
        $alldata->gas_plan = '1462';
        // $alldata->inj_plan = '168258';



        //$alldata->liq_plan = '20';

        $alldata->save();

        return redirect('ru/visualcenter2')->with('success', __('app.created'));
    }
}
