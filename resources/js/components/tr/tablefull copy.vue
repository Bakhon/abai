<template>
    <table class="table table-bordered table-dark table-responsive ce" style="position: sticky;left: 5.31%;right: 2.4%;top: 48.21%;bottom: 66.58%;background: #0D1E63;">
        <tr class="headerColumn">
            <td rowspan="4" @click="sortBy('field')"><span>НГДУ/месторождение</span></td>
            <td rowspan="4" @click="sortBy('well')"><span>№ скв</span></td>
            <td rowspan="4" @click="sortBy('well_type')"><span>Тип скважины</span></td>
            <td rowspan="4" @click="sortBy('horizon')"><span>Горизонт</span></td>

            <td rowspan="4" @click="sortBy('well')"><span>Блок</span></td>
            <td rowspan="4" @click="sortBy('well')"><span>R контура питания</span></td>

            <td rowspan="4" @click="sortBy('cas_OD')"><span>Наружный диаметр э/к</span></td>
            <td rowspan="4" @click="sortBy('cas_OD')"><span>Внутренний диаметр э/к</span></td>

            <td rowspan="4" @click="sortBy('tub_OD')"><span>Наружный диаметр НТК</span></td>
            <td rowspan="4" @click="sortBy('tub_OD')"><span>Внутренний диаметр НТК</span></td>

            <td rowspan="4" @click="sortBy('choke_d')"><span>Диаметр штуцера</span></td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')"><span>Нвдп</span></td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')"><span>Удлинение(Нвдп)</span></td>

            <td rowspan="4" @click="sortBy('exp_meth')"><span>Способ эксплуатации</span></td>
            <td rowspan="4" @click="sortBy('pump_type')"><span>Тип Насоса</span></td>

            <td rowspan="4" @click="sortBy('h_up_perf_vd')"><span>Тип СК</span></td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')"><span>Число качаний</span></td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')"><span>Длина хода</span></td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')"><span>Q теор</span></td>

            <td rowspan="4" @click="sortBy('freq')"><span>Частота работы насоса или число оборотов</span></td>
            <td rowspan="4" @click="sortBy('h_pump_set')"><span>Н сп насоса</span></td>

            <td rowspan="4" @click="sortBy('h_up_perf_vd')"><span>P буф</span></td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')"><span>P лин</span></td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')"><span>P пл</span></td>
            <td rowspan="4" @click="sortBy('h_dyn')"><span>Н дин</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Р затр</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Р на приеме</span></td>

            <td class="colspan" colspan="5">Данные за предыдущий месяц</td>

            <td class="colspan" colspan="4">Фактический режим</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Состояние на конец месяца</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>P нас</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>ГФ</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Т пл</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Т уст</span></td>

            <td class="colspan" colspan="4">ГРП</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>"Вязкость нефти в пл. условиях"</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>"Вязкость воды в пл. условиях"</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>"Вязкость жидкости"</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>"Объемный коэффициент"</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>"Плотность нефти"</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>"Плотность воды"</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Н перф</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>k</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>КН</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>К пр</span></td>

            <td class="colspan" colspan="7">Расчет технологического потенциала от ИДН</td>
            <td class="colspan" colspan="3">Расчёт геологического потенциала</td>
            <td class="colspan" colspan="2">Проверка</td>

            <td rowspan="4" @click="sortBy('p_annular')"><span>Максимальная глубина спуска насоса при ИДН</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Дата остановки</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Расчлененность</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Зона</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Цех</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Фонтан через насос</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Нерентабельная</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Неустановившийся режим</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Дата ввода в эксплуатацию</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Назначение по проекту</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Р заб замерное</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Нефтенасыщенная толщина</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Накопленная добыча нефти</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Максимальный дебит жидкости за всю историю работы</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Расстояние до нагн скважины</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Расстояние до ВНК</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Текущий забой по скважине, м</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Кподачи насоса</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Тип ГЗУ</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Рпл начальное</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Qr характеристический дебит жидкости</span></td>

            <td class="colspan" colspan="2">АПВ</td>

            <td class="colspan" colspan="1">Планируемые мероприятия</td>

            <!-- <td rowspan="4" @click="sortBy('p_annular')"><span>Мероприятия</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Сведения о тех.состоянии  экс.колонны</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Комментарии</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Дата последнего ГТМ</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Вид последнего ГТМ</span></td> -->



        </tr>
        <tr class="headerColumn">
            <td rowspan="3"><span>P заб</span></td>
            <td rowspan="3"><span>Q ж</span></td>
            <td rowspan="3"><span>Обводненность</span></td>
            <td rowspan="3"><span>Hдин</span></td>
            <td rowspan="3"><span>Kпр</span></td>

            <td rowspan="3"><span>P заб</span></td>
            <td rowspan="3"><span>Q н</span></td>
            <td rowspan="3"><span>Q ж</span></td>
            <td rowspan="3"><span>Обводненность</span></td>

            <td rowspan="3"><span>Скин</span></td>
            <td rowspan="3"><span>JD факт</span></td>
            <td rowspan="3"><span>Дата проведения</span></td>
            <td rowspan="3"><span>Фирма</span></td>

            <td rowspan="3"><span>Р заб</span></td>

            <td class="colspan" colspan="4">ИДН</td>
            <td rowspan="3"><span>JD опт</span></td>
            <td rowspan="3"><span>Skin</span></td>
            <td rowspan="3"><span>К пр от стимуляции</span></td>

            <td class="colspan" colspan="4">ГРП</td>
            <td rowspan="3"><span>% прироста Q н</span></td>
            <td rowspan="3"><span>Р заб</span></td>

            <td class="colspan" colspan="4">ИДН</td>

            <td class="colspan" colspan="4">ГРП</td>

            <td class="colspan" colspan="2">Ошибки</td>

            <td class="colspan" colspan="2">Предупреждения</td>
            <td rowspan="3"><span>Траб</span></td>
            <td rowspan="3"><span>Тнак</span></td>

            <td class="colspan" colspan="3">Изоляционные работы</td>


        </tr>
        <tr class="headerColumn">
            <td rowspan="2"><span>Q ж</span></td>
            <td rowspan="2"><span>Q ж  с поправкой на D э/к</span></td>
            <td rowspan="2"><span>Q н</span></td>
            <td rowspan="2"><span>Прирост Q н</span></td>

            <td rowspan="2"><span>Q ж</span></td>
            <td rowspan="2"><span>Q ж  с поправкой на D э/к</span></td>
            <td rowspan="2"><span>Q н</span></td>
            <td rowspan="2"><span>Прирост Q н</span></td>

            <td rowspan="2"><span>Q ж</span></td>
            <td rowspan="2"><span>Q ж  с поправкой на D э/к</span></td>
            <td rowspan="2"><span>Q н</span></td>
            <td rowspan="2"><span>Прирост Q н</span></td>

            <td rowspan="2"><span>Q ж</span></td>
            <td rowspan="2"><span>Q ж  с поправкой на D э/к</span></td>
            <td rowspan="2"><span>Q н</span></td>
            <td rowspan="2"><span>Прирост Q н</span></td>

            <td rowspan="2"><span>Число ошибок</span></td>
            <td rowspan="2"><span>Первая ошибка</span></td>

            <td rowspan="2"><span>Число предупреждений</span></td>
            <td rowspan="2"><span>Первое предупреждение</span></td>

            <td rowspan="2"><span>Проводить</span></td>
            <td rowspan="2"><span>Дебит жидкости</span></td>
            <td rowspan="2"><span>Обводненность</span></td>


        </tr>
        <tr></tr>
        <tr class="subHeaderColumn">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>м</td>
            <td>мм</td>
            <td>мм</td>
            <td>мм</td>
            <td>мм</td>
            <td>м</td>
            <td>м</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>м</td>
            <td>м3/сут</td>
            <td>Гц, об/мин</td>
            <td>м</td>
            <td>атм</td>
            <td>атм</td>
            <td>атм</td>
            <td>м</td>
            <td>атм</td>
            <td>атм</td>
            <td>атм</td>
            <td>м3/сут</td>
            <td>%</td>
            <td>м</td>
            <td>м3/сут/атм</td>
            <td>атм</td>
            <td>т/сут</td>
            <td>м3/сут</td>
            <td>%</td>
            <td></td>
            <td>атм</td>
            <td>м3/т</td>
            <td>ºC</td>
            <td></td>
            <td></td>
            <td></td>
            <td>д/м/г</td>
            <td></td>
            <td>сПз</td>
            <td>сПз</td>
            <td>сПз</td>
            <td>м3/м3</td>
            <td>г/см3</td>
            <td>г/см3</td>
            <td>м</td>
            <td>мД</td>
            <td>мДм</td>
            <td>м3/сут/атм</td>
            <td>атм</td>
            <td>м3/сут</td>
            <td>м3/сут</td>
            <td>т/сут</td>
            <td>т/сут</td>
            <td></td>
            <td></td>
            <td>м3/сут/атм</td>
            <td>м3/сут</td>
            <td>м3/сут</td>
            <td>т/сут</td>
            <td>т/сут</td>
            <td>%</td>
            <td>атм</td>
            <td>м3/сут</td>
            <td>м3/сут</td>
            <td>т/сут</td>
            <td>т/сут</td>
            <td>%</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>д/м/г</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>д/м/г</td>
            <td></td>
            <td>атм</td>
            <td>м</td>
            <td>тыс.т</td>
            <td>м3/сут</td>
            <td>м</td>
            <td>м</td>
            <td></td>
            <td>м3/сут</td>
            <td></td>
            <td>атм</td>
            <td>м3/сут</td>
            <td>час</td>
            <td>час</td>
            <td>атм</td>
            <td>м3/сут</td>
            <td>%</td>
            <!-- <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td> -->
        </tr>


        <tr v-for="(row, row_index) in wells" :key="row_index">
            <td>{{row.uwi_num}}</td>
            <td>{{row.gu}}</td>
            <td>{{row.field}}</td>
            <td>{{row.well}}</td>
            <td>{{row.well_type}}</td>
            <td>{{row.horizon}}</td>
            <td>{{row.block}}</td>
            <td>{{row.r_con}}</td>
            <td>{{row.cas_OD}}</td>
            <td>{{row.cas_ID}}</td>
            <td>{{row.tub_OD}}</td>
            <td>{{row.tub_ID}}</td>
            <td>{{row.choke_d}}</td>
            <td>{{row.h_up_perf_vd}}</td>
            <td>{{row.h_up_perf_md}}</td>
            <td>{{row.exp_meth}}</td>
            <td>{{row.pump_type}}</td>
            <td>{{row.spm}}</td>
            <td>{{row.stroke_len}}</td>
            <td>{{row.q_theor}}</td>
            <td>{{row.freq}}</td>
            <td>{{row.h_pump_set}}</td>
            <td>{{row.whp}}</td>
            <td>{{row.line_p}}</td>
            <td>{{row.p_res}}</td>
            <td>{{row.h_dyn}}</td>
            <td>{{row.p_annular}}</td>
            <td>{{row.p_intake}}</td>
            <td>{{row.bhp_prev_m}}</td>
            <td>{{row.q_l_prev_m}}</td>
            <td>{{row.wct_prev_m}}</td>
            <td>{{row.h_dyn_prev_m}}</td>
            <td>{{row.pi_prev_m}}</td>
            <td>{{row.bhp}}</td>
            <td>{{row.q_o}}</td>
            <td>{{row.q_l}}</td>
            <td>{{row.wct}}</td>
            <td>{{row.well_status_last_day}}</td>
            <td>{{row.P_bubble_point}}</td>
            <td>{{row.gor}}</td>
            <td>{{row.t_res}}</td>
            <td>{{row.wht}}</td>
            <td>{{row.grp_skin}}</td>
            <td>{{row.grp_jd}}</td>
            <td>{{row.grp_date}}</td>
            <td>{{row.grp_contractor}}</td>
            <td>{{row.visc_oil_rc}}</td>
            <td>{{row.visc_wat_rc}}</td>
            <td>{{row.visc_liq_rc}}</td>
            <td>{{row.bo}}</td>
            <td>{{row.dens_oil}}</td>
            <td>{{row.dens_liq}}</td>
            <td>{{row.h_perf}}</td>
            <td>{{row.k}}</td>
            <td>{{row.kh}}</td>
            <td>{{row.pi}}</td>
            <td>{{row.tp_idn_bhp}}</td>
            <td>{{row.tp_idn_liq}}</td>
            <td>{{row.tp_idn_liq_cas_d_corr}}</td>
            <td>{{row.tp_idn_oil}}</td>
            <td>{{row.tp_idn_oil_inc}}</td>
            <td>{{row.tp_idn_jd}}</td>
            <td>{{row.tp_idn_skin}}</td>
            <td>{{row.tp_idn_pi_after}}</td>
            <td>{{row.tp_idn_grp_q_liq}}</td>
            <td>{{row.tp_idn_grp_q_liq_cas_d_corr}}</td>
            <td>{{row.tp_idn_grp_q_oil}}</td>
            <td>{{row.tp_idn_grp_q_oil_inc}}</td>
            <td>{{row.tp_idn_q_oil_inc_perc}}</td>
            <td>{{row.gp_idn_bhp}}</td>
            <td>{{row.gp_idn_q_liq}}</td>
            <td>{{row.gp_idn_q_liq_cas_d_corr}}</td>
            <td>{{row.gp_idn_q_oil}}</td>
            <td>{{row.gp_idn_q_oil_inc}}</td>
            <td>{{row.gp_grp_q_liq}}</td>
            <td>{{row.gp_grp_q_liq_cas_d_corr}}</td>
            <td>{{row.gp_grp_q_oil}}</td>
            <td>{{row.gp_grp_q_oil_inc}}</td>
            <td>{{row.error_count}}</td>
            <td>{{row.error_first}}</td>
            <td>{{row.error_warning}}</td>
            <td>{{row.error_first_warning}}</td>
            <td>{{row.idn_pump_depth_max}}</td>
            <td>{{row.stop_date}}</td>
            <td>{{row.layers_count}}</td>
            <td>{{row.zone}}</td>
            <td>{{row.tseh}}</td>
            <td>{{row.semi_free_flow}}</td>
            <td>{{row.non_profit}}</td>
            <td>{{row.unsteady state}}</td>
            <td>{{row.start_up_date}}</td>
            <td>{{row.well_project_purpose}}</td>
            <td>{{row.bhp_meter}}</td>
            <td>{{row.oil_net_pay}}</td>
            <td>{{row.oil_cumulative}}</td>
            <td>{{row.max_q_liq_hist}}</td>
            <td>{{row.dist_to_inj_well}}</td>
            <td>{{row.dist_to_woc}}</td>
            <td>{{row.curr_bh}}</td>
            <td>{{row.pump_fillage}}</td>
            <td>{{row.gzu_type}}</td>
            <td>{{row.p_res_init}}</td>
            <td>{{row.q_liq_charac}}</td>

            <td>{{row.APV_t_rab}}</td>
            <td>{{row.APV_t_nak}}</td>
            <td>{{row.plan_izo_work}}</td>
            <td>{{row.plan_act_q_l}}</td>
            <td>{{row.plan_act_wct}}</td>
            <td>{{row.plan_activities}}</td>
            <td>{{row.plan_casing_info}}</td>
            <td>{{row.plan_comment}}</td>
            <!-- <td>{{row.q_liq_charac}}</td>
            <td>{{row.q_liq_charac}}</td>
            <td>{{row.q_liq_charac}}</td>
            <td>{{row.q_liq_charac}}</td>
            <td>{{row.q_liq_charac}}</td>-->

        </tr>
    </table>
</template>
<script>
export default {
    name: "TrFullTable",
    props: {
        wells: Array
    },
    methods: {
        sortBy(type) {
            this.$emit('onSort', type);
        }
    }
}
</script>



