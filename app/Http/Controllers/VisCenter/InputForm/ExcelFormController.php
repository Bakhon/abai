<?php

namespace App\Http\Controllers\VisCenter\InputForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ImportForms\DZOdaily;
use Carbon\Carbon;

class ExcelFormController extends Controller
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
        $alldata->dzo = 'КБМ';
        $alldata->oil_plan = floatval(str_replace(',', '.', $request->input('oil_plan')));
        $alldata->oil_fact = floatval(str_replace(',', '.', $request->input('oil_fact')));
        $alldata->oil_dlv_plan = floatval(str_replace(',', '.', $request->input('oil_dlv_plan')));
        $alldata->oil_dlv_fact = floatval(str_replace(',', '.', $request->input('oil_dlv_fact')));
        $alldata->gas_plan = floatval(str_replace(',', '.', $request->input('gas_plan')));
        $alldata->gas_fact = floatval(str_replace(',', '.', $request->input('gas_fact')));
        $alldata->liq_plan = floatval(str_replace(',', '.', $request->input('liq_plan')));
        $alldata->liq_fact = floatval(str_replace(',', '.', $request->input('liq_fact')));
        $alldata->fond_neftedob_ef = intval($request->input('fond_neftedob_ef'));
        $alldata->fond_neftedob_df = intval($request->input('fond_neftedob_df'));
        $alldata->prod_wells_idle = intval($request->input('prod_wells_idle'));
        $alldata->prod_wells_work = intval($request->input('fond_neftedob_df')) - intval($request->input('prod_wells_idle'));
        $alldata->fond_neftedob_bd = intval($request->input('fond_neftedob_bd'));
        $alldata->fond_neftedob_osvoenie = intval($request->input('fond_neftedob_osvoenie'));
        $alldata->fond_nagnetat_ef = intval($request->input('fond_nagnetat_ef'));
        $alldata->fond_nagnetat_df = intval($request->input('fond_nagnetat_df'));
        $alldata->inj_wells_idle = intval($request->input('inj_wells_idle'));
        $alldata->inj_wells_work = intval($request->input('fond_nagnetat_df')) - intval($request->input('inj_wells_idle'));
        $alldata->fond_nagnetat_bd = intval($request->input('fond_nagnetat_bd'));
        $alldata->fond_nagnetat_osvoenie = intval($request->input('fond_nagnetat_osvoenie'));
        $alldata->fond_neftedob_prs = intval($request->input('fond_neftedob_prs'));
        $alldata->fond_neftedob_oprs = intval($request->input('fond_neftedob_oprs'));
        $alldata->fond_neftedob_krs = intval($request->input('fond_neftedob_krs'));
        $alldata->fond_neftedob_okrs = intval($request->input('fond_neftedob_okrs'));
        $alldata->fond_neftedob_well_survey = intval($request->input('fond_neftedob_well_survey'));
        $alldata->fond_neftedob_others = intval($request->input('fond_neftedob_others'));
        $alldata->fond_neftedob_nrs = intval($request->input('fond_neftedob_nrs'));
        $alldata->otm_burenie_prohodka_plan = intval($request->input('otm_burenie_prohodka_plan'));
        $alldata->otm_burenie_prohodka_fact = intval($request->input('otm_burenie_prohodka_fact'));
        $alldata->otm_iz_burenia_skv_plan = intval($request->input('otm_iz_burenia_skv_plan'));
        $alldata->otm_iz_burenia_skv_fact = intval($request->input('otm_iz_burenia_skv_fact'));
        $alldata->tovarnyi_ostatok_nefti_today = intval($request->input('tovarnyi_ostatok_nefti_today'));

        $alldata->save();

        return redirect('ru/excelform')->with('success', __('app.created'));
    }
}
