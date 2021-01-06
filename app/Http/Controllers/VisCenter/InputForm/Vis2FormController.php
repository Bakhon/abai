<?php

namespace App\Http\Controllers\VisCenter\InputForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter2\Vis2Form;
use Carbon\Carbon;

class Vis2FormController extends Controller
{
    public function create()
    {
        return 'created';
    }
    public function store(Request $request)
    {
        $alldata = new Vis2Form;

        $alldata->date = Carbon::yesterday();
        $alldata->__time =  (Carbon::now())->getTimestamp() * 1000 - 86400000;
        $alldata->oil_fact = $request->input('dobycha_nefti_fact');
        $alldata->gk_fact = $request->input('dobycha_nefti_condensat_fact');
        $alldata->oil_dlv_fact = $request->input('sdacha_nefti_fact');
        $alldata->sdacha_nefti_condensat_fact = $request->input('sdacha_nefti_condensat_fact');
        $alldata->gas_fact = $request->input('dobycha_gaza_total_tch_fact');
        $alldata->dobycha_gaza_total_prirodnyi_fact = $request->input('dobycha_gaza_total_prirodnyi_fact');
        $alldata->dobycha_gaza_gazovyie_mest_dzo_fact = $request->input('dobycha_gaza_gazovyie_mest_dzo_fact');
        $alldata->dobycha_gaza_gsp_dzo_fact = $request->input('dobycha_gaza_gsp_dzo_fact');
        $alldata->dobycha_gaza_poputnyi_fact = $request->input('dobycha_gaza_poputnyi_fact');
        $alldata->inj_fact = $request->input('zakachka_vody_total_fact');
        $alldata->zakachka_vody_tch_morskaya_fact = $request->input('zakachka_vody_tch_morskaya_fact');
        $alldata->zakachka_vody_stochnaya_fact = $request->input('zakachka_vody_stochnaya_fact');
        $alldata->burenie_skvajin_prohodka_fact = $request->input('burenie_skvajin_prohodka_fact');
        $alldata->tovarnyi_ostatok = $request->input('tovarnyi_ostatok');

        $alldata->dzo = $request->input('dzo');

        $alldata->ngdu = $request->input('ngdu');
        $alldata->gu = $request->input('gu');
        $alldata->well_number = $request->input('well_number');
        $alldata->shutdown_time = $request->input('shutdown_time');
        $alldata->turnon_time = $request->input('turnon_time');
        $alldata->qzh_loss = $request->input('qzh_loss');
        $alldata->qn_loss = $request->input('qn_loss');
        $alldata->prostoy_time = $request->input('prostoy_time');
        $alldata->emerg_shutdown_reason = $request->input('emerg_shutdown_reason');

        $alldata->oprs = $request->input('oprs');
        $alldata->prs = $request->input('prs');
        $alldata->okrs = $request->input('okrs');
        $alldata->krs = $request->input('krs');
        $alldata->wells_study = $request->input('wells_study');
        $alldata->unprofitable = $request->input('unprofitable');
        $alldata->mining_wells_restriction = $request->input('mining_wells_restriction');
        $alldata->others = $request->input('others');

        $alldata->expl = $request->input('expl');
        $alldata->prod_wells_work = $request->input('deistv');
        $alldata->prod_wells_idle = $request->input('prostoy');
        $alldata->b_d = $request->input('b_d');
        $alldata->osvoenie = $request->input('osvoenie');
        $alldata->ozhidanie_likvidacii = $request->input('ozhidanie_likvidacii');
        $alldata->v_konservacii = $request->input('v_konservacii');


        $alldata->expl2 = $request->input('expl2');
        $alldata->inj_wells_work = $request->input('deistv2');
        $alldata->inj_wells_idle = $request->input('prostoy2');
        $alldata->b_d2 = $request->input('b_d2');
        $alldata->obustroystvo = $request->input('obustroystvo');
        $alldata->ozhidanie_likvidacii2 = $request->input('ozhidanie_likvidacii2');
        $alldata->v_konservacii2 = $request->input('v_konservacii2');


        $alldata->oil_plan = '38640';
        $alldata->oil_dlv_plan = '5873';
        $alldata->gk_plan = '15';
        $alldata->gas_plan = '1462';
        $alldata->inj_plan = '168258';



        //$alldata->liq_plan = '20';

        $alldata->save();

        return redirect('ru/visualcenter2')->with('success', __('app.created'));
    }
}
