<!DOCTYPE html>
<html>
<head>
    <title>Import Excel File in Laravel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<br />
    <div class="container">
    <h3 align="center">Импорт суточных данных из Excel в базу данных MySQL</h3>
<br />
    @if(count($errors) > 0)
    <div class="alert alert-danger">
        Upload Validation Error<br><br>
        <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif

    @if($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif

    <!-- <form method="post" enctype="multipart/form-data" action="{{ url('/import_excel/import') }}"> -->
    <form method="post" enctype="multipart/form-data" action="{{ route('import') }}">
    {{ csrf_field() }}
    <div class="form-group">
        <table class="table">
            <tr>
            <td width="40%" align="right"><label>Выберите Excel файл</label></td>
            <td width="30">
            <input type="file" name="select_file" />
            </td>
            <td width="30%" align="left">
            <input type="submit" name="upload" class="btn btn-primary" value="Загрузить">
            </td>
            </tr>
            <tr>
            <td width="40%" align="right"></td>
            <td width="30"><span class="text-muted">.xls, .xslx</span></td>
            <td width="30%" align="left"></td>
            </tr>
        </table>
    </div>
    </form>

    <br />
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Оперативная информация по ДЗО для АО "НК  'КазМунайГаз'"</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                <th>Дата</th>
                <th>ДЗО</th>
                <th>Месторождение</th>
                <th>НГДУ</th>
                <th>Добыча нефти,план</th>
                <th>Добыча нефти,факт</th>
                <th>gk_plan</th>
                <th>gk_fact</th>
                <th>liq_plan</th>
                <th>liq_fact</th>
                <th>sdacha_nefti_kuun</th>
                <th>oil_dlv_plan</th>
                <th>oil_dlv_fact</th>
                <th>tovarnyi_ostatok_nefti_prev_day</th>
                <th>tovarnyi_ostatok_nefti_today</th>
                <th>dobycha_gaza_prirod_plan</th>
                <th>dobycha_gaza_prirod_fact</th>
                <th>sdacha_gaza_prirod_plan</th>
                <th>sdacha_gaza_prirod_fact</th>
                <th>raskhod_prirod_plan</th>
                <th>raskhod_prirod_fact</th>
                <th>pererabotka_gaza_prirod_plan</th>
                <th>pererabotka_gaza_prirod_fact</th>
                <th>dobycha_gaza_poput_plan</th>
                <th>dobycha_gaza_poput_fact</th>
                <th>sdacha_gaza_poput_plan</th>
                <th>sdacha_gaza_poput_fact</th>
                <th>raskhod_poput_plan</th>
                <th>raskhod_poput_fact</th>
                <th>raskhod_syraya_poput_plan</th>
                <th>raskhod_syraya_poput_fact</th>
                <th>raskhod_syraya_tovarnaya_plan</th>
                <th>raskhod_tovarnaya_poput_fact</th>
                <th>pererabotka_gaza_poput_plan</th>
                <th>pererabotka_gaza_poput_fact</th>
                <th>poput_tech_poteri</th>
                <th>poput_razresheno_sjiganie</th>
                <th>ppd_zakachka_morskoi_vody_plan</th>
                <th>ppd_zakachka_morskoi_vody_fact</th>
                <th>ppd_zakachka_stochnoi_vody_plan</th>
                <th>ppd_zakachka_stochnoi_vody_fact</th>
                <th>ppd_zakachka_albsen_vody_plan</th>
                <th>ppd_zakachka_albsen_vody_fact</th>
                <th>ppd_zakachka_gaza_plan</th>
                <th>ppd_zakachka_gaza_fact</th>
                <th>ppd_zakachka_plast_poput_vody_plan</th>
                <th>ppd_zakachka_plast_poput_vody_fact</th>
                <th>ppd_zakachka_plast_apsk_vody_plan</th>
                <th>ppd_zakachka_plast_apsk_vody_fact</th>
                <th>ppd_zakachka_voljskoy_vody_plan</th>
                <th>ppd_zakachka_voljskoy_vody_fact</th>
                <th>ppd_zakachka_senopal_vody_plan</th>
                <th>ppd_zakachka_senopal_vody_fact</th>
                <th>otm_iz_burenia_skv_plan</th>
                <th>otm_iz_burenia_skv_fact</th>
                <th>otm_burenie_prohodka_plan</th>
                <th>otm_burenie_prohodka_fact</th>
                <th>otm_krs_skv_plan</th>
                <th>otm_krs_skv_fact</th>
                <th>otm_prs_skv_plan</th>
                <th>otm_prs_skv_fact</th>
                <th>cpp_zakachka_para_plan</th>
                <th>cpp_zakachka_para_fact</th>
                <th>fond_neftedob_ef</th>
                <th>fond_neftedob_df</th>
                <th>prod_wells_work</th>
                <th>fond_neftedob_prs</th>
                <th>fond_neftedob_oprs</th>
                <th>fond_neftedob_krs</th>
                <th>fond_neftedob_okrs</th>
                <th>fond_neftedob_well_survey</th>
                <th>fond_neftedob_others</th>
                <th>fond_neftedob_bd</th>
                <th>fond_neftedob_osvoenie</th>
                <th>fond_neftedob_ofls</th>
                <th>fond_neftedob_nrs</th>
                <th>prod_wells_idle</th>
                <th>prod_wells_idle_el</th>
                <th>fond_neftedob_svabirovanie</th>
                <th>fond_neftedob_period</th>
                <th>fond_neftedob_vysokoobvod</th>
                <th>fond_nagnetat_ef</th>
                <th>fond_nagnetat_df</th>
                <th>inj_wells_work</th>
                <th>fond_nagnetat_prs</th>
                <th>fond_nagnetat_oprs</th>
                <th>fond_nagnetat_krs</th>
                <th>fond_nagnetat_okrs</th>
                <th>fond_nagnetat_well_survey</th>
                <th>fond_nagnetat_others</th>
                <th>fond_nagnetat_bd</th>
                <th>fond_nagnetat_osvoenie</th>
                <th>fond_nagnetat_ofls</th>
                <th>fond_nagnetat_konv</th>
                <th>fond_nagnetat_ostanovka</th>
                <th>fond_nagnetat_neftedob_fls</th>
                <th>fond_nagnetat_neftedob_konserv</th>
                <th>chem_prod_zakacka_demulg_amount</th>
                <th>chem_prod_zakacka_demulg_plan</th>
                <th>chem_prod_zakacka_demulg_fact</th>
                <th>chem_prod_zakacka_bakteracid_amount</th>
                <th>chem_prod_zakacka_bakteracid_plan</th>
                <th>chem_prod_zakacka_bakteracid_fact</th>
                <th>chem_prod_zakacka_ingibator_korrozin_amount</th>
                <th>chem_prod_zakacka_ingibator_korrozin_plan</th>
                <th>chem_prod_zakacka_ingibator_korrozin_fact</th>
                <th>chem_prod_zakacka_ingibator_soleotloj_amount</th>
                <th>chem_prod_zakacka_ingibator_soleotloj_plan</th>
                <th>chem_prod_zakacka_ingibator_soleotloj_fact</th>
                <th>tb_personal_plan</th>
                <th>tb_personal_fact</th>
                <th>tb_accident_total</th>
                <th>tb_accident_death</th>
                <th>tb_covid_prev_day</th>
                <th>tb_covid_total</th>
                <th>tb_covid_recover</th>
                </tr>
                @foreach($data as $row)
                    <tr>
                    <td>{{ $row->date }}</td>
                    <td>{{ $row->dzo }}</td>
                    <td>{{ $row->mestorozhdenie }}</td>
                    <td>{{ $row->ngdu }}</td>
                    <td>{{ $row->oil_plan }}</td>
                    <td>{{ $row->oil_fact }}</td>
                    <td>{{ $row->gk_plan }}</td>
                    <td>{{ $row->gk_fact }}</td>
                    <td>{{ $row->liq_plan }}</td>
                    <td>{{ $row->liq_fact }}</td>
                    <td>{{ $row->sdacha_nefti_kuun }}</td>
                    <td>{{ $row->oil_dlv_plan }}</td>
                    <td>{{ $row->oil_dlv_fact }}</td>
                    <td>{{ $row->tovarnyi_ostatok_nefti_prev_day }}</td>
                    <td>{{ $row->tovarnyi_ostatok_nefti_today }}</td>
                    <td>{{ $row->dobycha_gaza_prirod_plan }}</td>
                    <td>{{ $row->dobycha_gaza_prirod_fact }}</td>
                    <td>{{ $row->sdacha_gaza_prirod_plan }}</td>
                    <td>{{ $row->sdacha_gaza_prirod_fact }}</td>
                    <td>{{ $row->raskhod_prirod_plan }}</td>
                    <td>{{ $row->raskhod_prirod_fact }}</td>
                    <td>{{ $row->pererabotka_gaza_prirod_plan }}</td>
                    <td>{{ $row->pererabotka_gaza_prirod_fact }}</td>
                    <td>{{ $row->dobycha_gaza_poput_plan }}</td>
                    <td>{{ $row->dobycha_gaza_poput_fact }}</td>
                    <td>{{ $row->sdacha_gaza_poput_plan }}</td>
                    <td>{{ $row->sdacha_gaza_poput_fact }}</td>
                    <td>{{ $row->raskhod_poput_plan }}</td>
                    <td>{{ $row->raskhod_poput_fact }}</td>
                    <td>{{ $row->raskhod_syraya_poput_plan }}</td>
                    <td>{{ $row->raskhod_syraya_poput_fact }}</td>
                    <td>{{ $row->raskhod_syraya_tovarnaya_plan }}</td>
                    <td>{{ $row->raskhod_tovarnaya_poput_fact }}</td>
                    <td>{{ $row->pererabotka_gaza_poput_plan }}</td>
                    <td>{{ $row->pererabotka_gaza_poput_fact }}</td>
                    <td>{{ $row->poput_tech_poteri }}</td>
                    <td>{{ $row->poput_razresheno_sjiganie }}</td>
                    <td>{{ $row->ppd_zakachka_morskoi_vody_plan }}</td>
                    <td>{{ $row->ppd_zakachka_morskoi_vody_fact }}</td>
                    <td>{{ $row->ppd_zakachka_stochnoi_vody_plan }}</td>
                    <td>{{ $row->ppd_zakachka_stochnoi_vody_fact }}</td>
                    <td>{{ $row->ppd_zakachka_albsen_vody_plan }}</td>
                    <td>{{ $row->ppd_zakachka_albsen_vody_fact }}</td>
                    <td>{{ $row->ppd_zakachka_gaza_plan }}</td>
                    <td>{{ $row->ppd_zakachka_gaza_fact }}</td>
                    <td>{{ $row->ppd_zakachka_plast_poput_vody_plan }}</td>
                    <td>{{ $row->ppd_zakachka_plast_poput_vody_fact }}</td>
                    <td>{{ $row->ppd_zakachka_plast_apsk_vody_plan }}</td>
                    <td>{{ $row->ppd_zakachka_plast_apsk_vody_fact }}</td>
                    <td>{{ $row->ppd_zakachka_voljskoy_vody_plan }}</td>
                    <td>{{ $row->ppd_zakachka_voljskoy_vody_fact }}</td>
                    <td>{{ $row->ppd_zakachka_senopal_vody_plan }}</td>
                    <td>{{ $row->ppd_zakachka_senopal_vody_fact }}</td>
                    <td>{{ $row->otm_iz_burenia_skv_plan }}</td>
                    <td>{{ $row->otm_iz_burenia_skv_fact }}</td>
                    <td>{{ $row->otm_burenie_prohodka_plan }}</td>
                    <td>{{ $row->otm_burenie_prohodka_fact }}</td>
                    <td>{{ $row->otm_krs_skv_plan }}</td>
                    <td>{{ $row->otm_krs_skv_fact }}</td>
                    <td>{{ $row->otm_prs_skv_plan }}</td>
                    <td>{{ $row->otm_prs_skv_fact }}</td>
                    <td>{{ $row->cpp_zakachka_para_plan }}</td>
                    <td>{{ $row->cpp_zakachka_para_fact }}</td>
                    <td>{{ $row->fond_neftedob_ef }}</td>
                    <td>{{ $row->fond_neftedob_df }}</td>
                    <td>{{ $row->prod_wells_work }}</td>
                    <td>{{ $row->fond_neftedob_prs }}</td>
                    <td>{{ $row->fond_neftedob_oprs }}</td>
                    <td>{{ $row->fond_neftedob_krs }}</td>
                    <td>{{ $row->fond_neftedob_okrs }}</td>
                    <td>{{ $row->fond_neftedob_well_survey }}</td>
                    <td>{{ $row->fond_neftedob_others }}</td>
                    <td>{{ $row->fond_neftedob_bd }}</td>
                    <td>{{ $row->fond_neftedob_osvoenie }}</td>
                    <td>{{ $row->fond_neftedob_ofls }}</td>
                    <td>{{ $row->fond_neftedob_nrs }}</td>
                    <td>{{ $row->prod_wells_idle }}</td>
                    <td>{{ $row->fond_neftedob_prostoy_el }}</td>
                    <td>{{ $row->fond_neftedob_svabirovanie }}</td>
                    <td>{{ $row->fond_neftedob_period }}</td>
                    <td>{{ $row->fond_neftedob_vysokoobvod }}</td>
                    <td>{{ $row->fond_nagnetat_ef }}</td>
                    <td>{{ $row->fond_nagnetat_df }}</td>
                    <td>{{ $row->inj_wells_work }}</td>
                    <td>{{ $row->fond_nagnetat_prs }}</td>
                    <td>{{ $row->fond_nagnetat_oprs }}</td>
                    <td>{{ $row->fond_nagnetat_krs }}</td>
                    <td>{{ $row->fond_nagnetat_okrs }}</td>
                    <td>{{ $row->fond_nagnetat_well_survey }}</td>
                    <td>{{ $row->fond_nagnetat_others }}</td>
                    <td>{{ $row->fond_nagnetat_bd }}</td>
                    <td>{{ $row->fond_nagnetat_osvoenie }}</td>
                    <td>{{ $row->fond_nagnetat_ofls }}</td>
                    <td>{{ $row->fond_nagnetat_konv }}</td>
                    <td>{{ $row->fond_nagnetat_ostanovka }}</td>
                    <td>{{ $row->fond_nagnetat_neftedob_fls }}</td>
                    <td>{{ $row->fond_nagnetat_neftedob_konserv }}</td>
                    <td>{{ $row->chem_prod_zakacka_demulg_amount }}</td>
                    <td>{{ $row->chem_prod_zakacka_demulg_plan }}</td>
                    <td>{{ $row->chem_prod_zakacka_demulg_fact }}</td>
                    <td>{{ $row->chem_prod_zakacka_bakteracid_amount }}</td>
                    <td>{{ $row->chem_prod_zakacka_bakteracid_plan }}</td>
                    <td>{{ $row->chem_prod_zakacka_bakteracid_fact }}</td>
                    <td>{{ $row->chem_prod_zakacka_ingibator_korrozin_amount }}</td>
                    <td>{{ $row->chem_prod_zakacka_ingibator_korrozin_plan }}</td>
                    <td>{{ $row->chem_prod_zakacka_ingibator_korrozin_fact }}</td>
                    <td>{{ $row->chem_prod_zakacka_ingibator_soleotloj_amount }}</td>
                    <td>{{ $row->chem_prod_zakacka_ingibator_soleotloj_plan }}</td>
                    <td>{{ $row->chem_prod_zakacka_ingibator_soleotloj_fact }}</td>
                    <td>{{ $row->tb_personal_plan }}</td>
                    <td>{{ $row->tb_personal_fact }}</td>
                    <td>{{ $row->tb_accident_total }}</td>
                    <td>{{ $row->tb_accident_death }}</td>
                    <td>{{ $row->tb_covid_prev_day }}</td>
                    <td>{{ $row->tb_covid_total }}</td>
                    <td>{{ $row->tb_covid_recover }}</td>
                    </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>