@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{ route('dzodaily.index') }}">{{__('app.back')}}</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dzodaily.update', $row->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Дата:</strong>
                                        <input type="data" name="date" value="{{$row->date}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>__time:</strong>
                                        <input type="integer" name="__time" value="{{$row->__time}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>ДЗО:</strong>
                                        <input type="text" name="dzo" value="{{$row->dzo}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Добыча нефти план(oil_plan):</strong>
                                        <input type="float" name="oil_plan" value="{{$row->oil_plan}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Добыча нефти ОПЕК план(oil_opek_plan):</strong>
                                        <input type="float" name="oil_opek_plan" value="{{$row->oil_opek_plan}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Добыча нефти факт(oil_fact):</strong>
                                        <input type="float" name="oil_fact" value="{{$row->oil_fact}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Добыча конденсата план(gk_plan):</strong>
                                        <input type="float" name="gk_plan" value="{{$row->gk_plan}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Добыча конденсата факт(gk_fact):</strong>
                                        <input type="float" name="gk_fact" value="{{$row->gk_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Сдача нефти план(oil_dlv_plan):</strong>
                                        <input type="float" name="oil_dlv_plan" value="{{$row->gk_plan}} " class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Сдача нефти ОПЕК план(oil_dlv_opek_plan):</strong>
                                        <input type="float" name="oil_dlv_opek_plan" value="{{$row->gk_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="f orm-group">
                                        <strong>Сдача нефти факт(oil_dlv_fact):</strong>
                                        <input type="float" name="oil_dlv_fact" value="{{$row->gk_plan}}"  class="form-control" placeholder="Пример: 0.9">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Добыча конденсата план(gk_plan):</strong>
                                        <input type="float" name="gk_plan" value="{{$row->gk_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Добыча конденсата факт(gk_fact):</strong>
                                        <input type="float" name="gk_fact" value="{{$row->gk_fact}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Товарный остаток(tovarnyi_ostatok_nefti_today):</strong>
                                        <input type="float" name="tovarnyi_ostatok_nefti_today" value="{{$row->tovarnyi_ostatok_nefti_today}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Добыча газа план(gas_plan):</strong>
                                        <input type="float" name="gas_plan" value="{{$row->gas_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Добыча газа факт(gas_fact):</strong>
                                        <input type="float" name="gas_fact" value="{{$row->gas_fact}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Добыча газа природный план(dobycha_gaza_prirod_plan):</strong>
                                        <input type="float" name="dobycha_gaza_prirod_plan" value="{{$row->dobycha_gaza_prirod_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Добыча газа природный факт(dobycha_gaza_prirod_fact):</strong>
                                        <input type="float" name="dobycha_gaza_prirod_fact" value="{{$row->dobycha_gaza_prirod_fact}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Сдача газа природный план(sdacha_gaza_prirod_plan):</strong>
                                        <input type="float" name="sdacha_gaza_prirod_plan" value="{{$row->sdacha_gaza_prirod_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Сдача газа природный факт(sdacha_gaza_prirod_fact):</strong>
                                        <input type="float" name="sdacha_gaza_prirod_fact" value="{{$row->sdacha_gaza_prirod_fact}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Добыча газа попутный план(dobycha_gaza_poput_plan):</strong>
                                        <input type="float" name="dobycha_gaza_poput_plan" value="{{$row->dobycha_gaza_poput_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Добыча газа попутный факт(dobycha_gaza_poput_fact):</strong>
                                        <input type="float" name="dobycha_gaza_poput_fact" value="{{$row->dobycha_gaza_poput_fact}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Сдача газа попутный план(sdacha_gaza_poput_plan):</strong>
                                        <input type="float" name="sdacha_gaza_poput_plan" value="{{$row->sdacha_gaza_poput_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Сдача газа попутный факт(sdacha_gaza_poput_fact):</strong>
                                        <input type="float" name="sdacha_gaza_poput_fact" value="{{$row->sdacha_gaza_poput_fact}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Расход газа попутный план(raskhod_poput_plan):</strong>
                                        <input type="float" name="raskhod_poput_plan" value="{{$row->raskhod_poput_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Расход газа попутный факт(raskhod_poput_fact):</strong>
                                        <input type="float" name="raskhod_poput_fact" value="{{$row->raskhod_poput_fact}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Переработка газа попутный план(pererabotka_gaza_poput_plan):</strong>
                                        <input type="float" name="pererabotka_gaza_poput_plan" value="{{$row->pererabotka_gaza_poput_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Переработка газа попутный факт(pererabotka_gaza_poput_fact):</strong>
                                        <input type="float" name="pererabotka_gaza_poput_fact" value="{{$row->pererabotka_gaza_poput_fact}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Закачка воды план(liq_plan):</strong>
                                        <input type="float" name="liq_plan" value="{{$row->liq_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Закачка воды факт(liq_fact):</strong>
                                        <input type="float" name="liq_fact" value="{{$row->liq_fact}}"  class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Закачка морской воды план(ppd_zakachka_morskoi_vody_plan):</strong>
                                        <input type="float" name="ppd_zakachka_morskoi_vody_plan" value="{{$row->ppd_zakachka_morskoi_vody_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Закачка морской воды факт(ppd_zakachka_morskoi_vody_fact):</strong>
                                        <input type="float" name="ppd_zakachka_morskoi_vody_fact" value="{{$row->ppd_zakachka_morskoi_vody_fact}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Закачка сточной воды план(ppd_zakachka_stochnoi_vody_plan):</strong>
                                        <input type="float" name="ppd_zakachka_stochnoi_vody_plan" value="{{$row->ppd_zakachka_stochnoi_vody_plan}} " class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Закачка сточной воды факт(ppd_zakachka_stochnoi_vody_fact):</strong>
                                        <input type="float" name="ppd_zakachka_stochnoi_vody_fact" value="{{$row->ppd_zakachka_stochnoi_vody_fact}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Закачка альбсен воды план(ppd_zakachka_albsen_vody_plan):</strong>
                                        <input type="float" name="ppd_zakachka_albsen_vody_plan" value="{{$row->ppd_zakachka_albsen_vody_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Закачка альбсен воды факт(ppd_zakachka_albsen_vody_fact):</strong>
                                        <input type="float" name="ppd_zakachka_albsen_vody_fact" value="{{$row->ppd_zakachka_albsen_vody_fact}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Закачка пара план(cpp_zakachka_para_plan):</strong>
                                        <input type="float" name="cpp_zakachka_para_plan" value="{{$row->cpp_zakachka_para_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Закачка пара факт(cpp_zakachka_para_fact):</strong>
                                        <input type="float" name="cpp_zakachka_para_fact" value="{{$row->cpp_zakachka_para_fact}}"  class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Э/Ф(fond_neftedob_ef):</strong>
                                        <input type="float" name="fond_neftedob_ef" value="{{$row->fond_neftedob_ef}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Д/Ф(fond_neftedob_df):</strong>
                                        <input type="float" name="fond_neftedob_df" value="{{$row->fond_neftedob_df}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>В работе(prod_wells_work):</strong>
                                        <input type="float" name="prod_wells_work" value="{{$row->prod_wells_work}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>В простое(prod_wells_idle):</strong>
                                        <input type="float" name="prod_wells_idle" value="{{$row->prod_wells_idle}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Б/Д(fond_neftedob_bd):</strong>
                                        <input type="float" name="fond_neftedob_bd" value="{{$row->fond_neftedob_bd}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>В освоении(fond_neftedob_osvoenie):</strong>
                                        <input type="float" name="fond_neftedob_osvoenie" value="{{$row->fond_neftedob_osvoenie}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>В ожид.ликв.(fond_neftedob_ofls):</strong>
                                        <input type="float" name="fond_neftedob_ofls" value="{{$row->fond_neftedob_ofls}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>В ПРС(fond_neftedob_prs):</strong>
                                        <input type="float" name="fond_neftedob_prs" value="{{$row->fond_neftedob_prs}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Ожидание ПРС(fond_neftedob_oprs):</strong>
                                        <input type="float" name="fond_neftedob_oprs" value="{{$row->fond_neftedob_oprs}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>В КРС(fond_neftedob_krs):</strong>
                                        <input type="float" name="fond_neftedob_krs" value="{{$row->fond_neftedob_krs}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Ожидание КРС(fond_neftedob_okrs):</strong>
                                        <input type="float" name="fond_neftedob_okrs" value="{{$row->fond_neftedob_okrs}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Исследование скважин(fond_neftedob_well_survey):</strong>
                                        <input type="float" name="fond_neftedob_well_survey" value="{{$row->fond_neftedob_well_survey}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Нерентабельные(fond_neftedob_nrs):</strong>
                                        <input type="float" name="fond_neftedob_nrs" value="{{$row->fond_neftedob_nrs}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Прочий простой(fond_neftedob_others):</strong>
                                        <input type="float" name="fond_neftedob_others" value="{{$row->fond_neftedob_others}}"  class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Э/Ф(fond_nagnetat_ef):</strong>
                                        <input type="float" name="fond_neftedob_ef" value="{{$row->fond_neftedob_ef}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Д/Ф(fond_nagnetat_df):</strong>
                                        <input type="float" name="fond_neftedob_df" value="{{$row->fond_neftedob_df}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>В работе(inj_wells_work):</strong>
                                        <input type="float" name="prod_wells_work" value="{{$row->prod_wells_work}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>В простое(inj_wells_idle):</strong>
                                        <input type="float" name="prod_wells_idle" value="{{$row->prod_wells_idle}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Б/Д(fond_nagnetat_bd):</strong>
                                        <input type="float" name="fond_neftedob_bd" value="{{$row->fond_neftedob_bd}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>В освоении(fond_nagnetat_osvoenie):</strong>
                                        <input type="float" name="fond_neftedob_osvoenie" value="{{$row->fond_neftedob_osvoenie}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>В ожид.ликв.(fond_nagnetat_ofls):</strong>
                                        <input type="float" name="fond_neftedob_ofls" value="{{$row->fond_neftedob_ofls}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>В консервации(fond_nagnetat_konv):</strong>
                                        <input type="float" name="fond_nagnetat_konv" value="{{$row->fond_nagnetat_konv}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>В ПРС(fond_nagnetat_prs):</strong>
                                        <input type="float" name="fond_neftedob_prs" value="{{$row->fond_neftedob_prs}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Ожидание ПРС(fond_nagnetat_oprs):</strong>
                                        <input type="float" name="fond_neftedob_oprs" value="{{$row->fond_neftedob_oprs}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>В КРС(fond_nagnetat_krs):</strong>
                                        <input type="float" name="fond_neftedob_krs" value="{{$row->fond_neftedob_krs}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Ожидание КРС(fond_nagnetat_okrs):</strong>
                                        <input type="float" name="fond_neftedob_okrs" value="{{$row->fond_neftedob_okrs}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Исследование скважин(fond_nagnetat_well_survey):</strong>
                                        <input type="float" name="fond_neftedob_well_survey" value="{{$row->fond_neftedob_well_survey}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Прочий простой(fond_nagnetat_others):</strong>
                                        <input type="float" name="fond_neftedob_others" value="{{$row->fond_neftedob_others}}"  class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Скважин из бурения план(otm_iz_burenia_skv_plan):</strong>
                                        <input type="float" name="otm_iz_burenia_skv_plan" value="{{$row->otm_iz_burenia_skv_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Скважин из бурения факт(otm_iz_burenia_skv_fact):</strong>
                                        <input type="float" name="otm_iz_burenia_skv_fact" value="{{$row->otm_iz_burenia_skv_fact}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Бурение проходка план(otm_burenie_prohodka_plan):</strong>
                                        <input type="float" name="otm_burenie_prohodka_plan" value="{{$row->otm_burenie_prohodka_plan}}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Бурение проходка факт(otm_burenie_prohodka_fact):</strong>
                                        <input type="float" name="otm_burenie_prohodka_fact" value="{{$row->otm_burenie_prohodka_fact}}"  class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Общий COVID(tb_covid_total):</strong>
                                        <input type="integer" name="tb_covid_total" value="{{$row->tb_covid_total}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Выздоровели COVID(tb_covid_recover):</strong>
                                        <input type="integer" name="tb_covid_recover" value="{{$row->tb_covid_recover}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">{{__('app.submit')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
