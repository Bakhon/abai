<template>
    <table class="table table-bordered table-dark table-responsive ce" style="position: sticky;left: 5.31%;right: 2.4%;top: 48.21%;bottom: 66.58%;background: #0D1E63;">
        <tr class="headerColumn">
            <td rowspan="4" @click="sortBy('field')">Раб. Группа</td>
            <td rowspan="4" @click="sortBy('field')">НГДУ/месторождение</td>
            <td rowspan="4" @click="sortBy('well')">№ скв</td>
            <td rowspan="4" @click="sortBy('well_type')">Тип скважины</td>
            <td rowspan="4" @click="sortBy('horizon')">Горизонт</td>
            <td rowspan="4" @click="sortBy('well')">Блок</td>
            <td rowspan="4" @click="sortBy('well')">R контура питания</td>
            <td rowspan="4" @click="sortBy('cas_OD')">Наружный диаметр э/к</td>
            <td rowspan="4" @click="sortBy('cas_OD')">Внутренний диаметр э/к</td>
            <td rowspan="4" @click="sortBy('tub_OD')">Наружный диаметр НТК</td>
            <td rowspan="4" @click="sortBy('tub_OD')">Внутренний диаметр НТК</td>
            <td rowspan="4" @click="sortBy('choke_d')">Диаметр штуцера</td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')">Нвдп</td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')">Удлинение(Нвдп)</td>
            <td rowspan="4" @click="sortBy('exp_meth')">Способ эксплуатации</td>
            <td rowspan="4" @click="sortBy('pump_type')">Тип Насоса</td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')">Тип СК</td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')">Число качаний</td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')">Длина хода</td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')">Q теор</td>
            <td rowspan="4" @click="sortBy('freq')"><span>Частота работы насоса или число оборотов</span></td>
            <td rowspan="4" @click="sortBy('h_pump_set')">Н сп насоса</td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')">P буф</td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')">P лин</td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')">P пл</td>
            <td rowspan="4" @click="sortBy('h_dyn')">Н дин</td>
            <td rowspan="4" @click="sortBy('p_annular')">Р затр</td>
            <td rowspan="4" @click="sortBy('p_annular')">Р на приеме</td>
            <td class="colspan" colspan="5">Данные за предыдущий месяц</td>
            <td class="colspan" colspan="4">Фактический режим</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Состояние на конец месяца</span></td>
            <td rowspan="4" @click="sortBy('p_annular')">P нас</td>
            <td rowspan="4" @click="sortBy('p_annular')">ГФ</td>
            <td rowspan="4" @click="sortBy('p_annular')">Т пл</td>
            <td rowspan="4" @click="sortBy('p_annular')">Т уст</td>
            <td class="colspan" colspan="4">ГРП</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>"Вязкость нефти в пл. условиях"</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>"Вязкость воды в пл. условиях"</span></td>
            <td rowspan="4" @click="sortBy('p_annular')">"Вязкость жидкости"</td>
            <td rowspan="4" @click="sortBy('p_annular')">"Объемный коэффициент"</td>
            <td rowspan="4" @click="sortBy('p_annular')">"Плотность нефти"</td>
            <td rowspan="4" @click="sortBy('p_annular')">"Плотность воды"</td>
            <td rowspan="4" @click="sortBy('p_annular')">Н перф</td>
            <td rowspan="4" @click="sortBy('p_annular')">k</td>
            <td rowspan="4" @click="sortBy('p_annular')">КН</td>
            <td rowspan="4" @click="sortBy('p_annular')">К пр</td>
            <td class="colspan" colspan="13">Расчет технологического потенциала от ИДН</td>
            <td class="colspan" colspan="9">Расчёт геологического потенциала</td>
            <td class="colspan" colspan="4">Проверка</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Максимальная глубина спуска насоса при ИДН</span></td>
            <td rowspan="4" @click="sortBy('p_annular')">Дата остановки</td>
            <td rowspan="4" @click="sortBy('p_annular')">Расчлененность</td>
            <td rowspan="4" @click="sortBy('p_annular')">Зона</td>
            <td rowspan="4" @click="sortBy('p_annular')">Цех</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Фонтан через насос</span></td>
            <td rowspan="4" @click="sortBy('p_annular')">Нерентабельная</td>
            <td rowspan="4" @click="sortBy('p_annular')">Неустановившийся режим</td>
            <td rowspan="4" @click="sortBy('p_annular')">Дата ввода в эксплуатацию</td>
            <td rowspan="4" @click="sortBy('p_annular')">Назначение по проекту</td>
            <td rowspan="4" @click="sortBy('p_annular')">Р заб замерное</td>
            <td rowspan="4" @click="sortBy('p_annular')">Нефтенасыщенная толщина</td>
            <td rowspan="4" @click="sortBy('p_annular')">Накопленная добыча нефти</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Максимальный дебит жидкости за всю историю работы</span></td>
            <td rowspan="4" @click="sortBy('p_annular')">Расстояние до нагн скважины</td>
            <td rowspan="4" @click="sortBy('p_annular')">Расстояние до ВНК</td>
            <td rowspan="4" @click="sortBy('p_annular')">Текущий забой по скважине, м</td>
            <td rowspan="4" @click="sortBy('p_annular')">Кподачи насоса</td>
            <td rowspan="4" @click="sortBy('p_annular')">Тип ГЗУ</td>
            <td rowspan="4" @click="sortBy('p_annular')">Рпл начальное</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Qr характеристический дебит жидкости</span></td>
            <td class="colspan" colspan="2">АПВ</td>
            <td class="colspan" colspan="3">Планируемые мероприятия</td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Мероприятия</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Сведения о тех.состоянии  экс.колонны</span></td>
            <td rowspan="4" @click="sortBy('p_annular')"><span>Комментарии</span></td>
            <!-- <td rowspan="4" @click="sortBy('p_annular')"><span>Дата последнего ГТМ</span></td>
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
            <td></td>
            <td></td>
            <td></td>
            <!-- <td></td>
            <td></td> -->
        </tr>
        <tr v-for="(row, row_index) in wells" :key="row_index">
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
            <td>{{row.EMPTY}}</td>
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
            <td>{{row.unsteady_state}}</td>
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



