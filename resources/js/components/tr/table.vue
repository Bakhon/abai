<template>
    <table class="table table-bordered table-dark table-responsive ce" style="position: sticky;left: 5.31%;right: 2.4%;top: 48.21%;bottom: 66.58%;background: #0D1E63;">
        <tr class="headerColumn">
            <td rowspan="4" @click="sortBy('well')">№ скв</td>
            <td rowspan="4" @click="sortBy('well_type')">Тип скважины</td>
            <td rowspan="4" @click="sortBy('horizon')">Горизонт</td>
            <td rowspan="4" @click="sortBy('cas_OD')">Наружный диаметр э/к</td>
            <td rowspan="4" @click="sortBy('tub_OD')">Наружный диаметр НТК</td>
            <td rowspan="4" @click="sortBy('choke_d')">Диаметр штуцера</td>
            <td rowspan="4" @click="sortBy('h_up_perf_vd')">Нвдп</td>
            <td rowspan="4" @click="sortBy('exp_meth')"><span>Способ эксплуатации</span></td>
            <td rowspan="4" @click="sortBy('pump_type')">Тип насоса</td>
            <td rowspan="4" @click="sortBy('freq')">Частота работы насоса или число оборотов</td>
            <td rowspan="4" @click="sortBy('h_pump_set')">Н сп насоса</td>
            <td rowspan="4" @click="sortBy('p_res')">Р пл</td>
            <td rowspan="4" @click="sortBy('h_dyn')">Н дин</td>
            <td rowspan="4" @click="sortBy('p_annular')">Р затр</td>
            <td class="colspan" colspan="4">Фактический режим</td>
            <td rowspan="4" @click="sortBy('well_status_last_day')">Состояние на конец месяца</td>
            <td rowspan="4" @click="sortBy('')">ГФ</td>
            <td rowspan="4" @click="sortBy('')">К пр</td>
            <td class="colspan" colspan="7">Расчет технологического потенциала от ИДН</td>
        </tr>
        <tr class="headerColumn">
            <td rowspan="3">P заб</td>
            <td rowspan="3">Q н</td>
            <td rowspan="3">Q ж</td>
            <td rowspan="3"><span>Обводненность</span></td>
            <td rowspan="3">P заб</td>
            <td class="colspan" colspan="2">ИДН</td>
            <td rowspan="3">К пр от стимуляции</td>
            <td class="colspan" colspan="2">ГРП</td>
            <td rowspan="3">Общий прирост Q н</td>
        </tr>
        <tr class="headerColumn">
            <td rowspan="2">Q ж</td>
            <td rowspan="2">Прирост Q н</td>
            <td rowspan="2">Q ж</td>
            <td rowspan="2">Прирост Q н</td>
        </tr>
        <tr></tr>
        <tr class="subHeaderColumn">
            <td></td>
            <td></td>
            <td></td>
            <td>мм</td>
            <td>мм</td>
            <td>м</td>
            <td>м</td>
            <td></td>
            <td></td>
            <td>Гц, об/мин</td>
            <td>м</td>
            <td>атм</td>
            <td>м</td>
            <td>атм</td>
            <td>атм</td>
            <td>т/сут</td>
            <td>м3/сут</td>
            <td>%</td>
            <td></td>
            <td>м3/т</td>
            <td>м3/сут/атм</td>
            <td>атм</td>
            <td>м3/сут</td>
            <td>т/сут</td>
            <td>м3/сут/атм</td>
            <td>м3/сут</td>
            <td>т/сут</td>
            <td>т/сут</td>
        </tr>
        <tr v-for="(row, row_index) in wells" :key="row_index">
            <td> {{row.well}}</td>
            <td>{{row.well_type}}</td>
            <td>{{row.horizon}}</td>
            <td>{{row.cas_OD}}</td>
            <td>{{row.tub_OD}}</td>
            <td>{{row.choke_d}}</td>
            <td>{{row.h_up_perf_vd}}</td>
            <td>{{row.exp_meth}}</td>
            <td>{{row.pump_type}}</td>
            <td>{{row.freq}}</td>
            <td>{{row.h_pump_set}}</td>
            <td>{{row.p_res}}</td>
            <td>{{row.h_dyn}}</td>
            <td>{{row.p_annular}}</td>
            <td>{{row.bhp}}</td>
            <td>{{row.q_o}}</td>
            <td>{{row.q_l}}</td>
            <td>{{row.wct}}</td>
            <td>{{row.well_status_last_day}}</td>
            <td>{{row.gor}}</td>
            <td>{{row.pi}}</td>
            <td>{{row.tp_idn_bhp}}</td>
            <td>{{row.tp_idn_liq}}</td>
            <td>{{row.tp_idn_oil_inc}}</td>
            <td>{{row.tp_idn_pi_after}}</td>
            <td>{{row.tp_idn_grp_q_liq}}</td>
            <td>{{row.tp_idn_grp_q_oil_inc}}</td>
            <td>{{row.EMPTY}}</td>
        </tr>
    </table>
</template>
<script>
export default {
    name: "TrTable",
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
