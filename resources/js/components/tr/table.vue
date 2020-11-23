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
            <td contenteditable='true'>{{row.well}}</td>
            <td>{{row.well_type}}</td>
            <td>{{row.horizon}}</td>
            <td>{{row.cas_OD}}</td>
            <td>{{row.tub_OD}}</td>
            <td>{{row.choke_d}}</td>
            <td>{{row.h_up_perf_vd}}</td>
            <td>{{row.exp_meth}}</td>
            <td>{{row.pump_type}}</td>
            <td>{{row.freq}}</td>
            <td>{{Math.round(row.h_pump_set*10)/10}}</td>

            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].p_res[1][0] !== '0'}">
                <span class="circle-err" :style="`background :${getColor(
            wells[row_index].p_res[1][0])}`"> </span>
                <span>{{Math.round(row.p_res[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].p_res[1][1]}}
                </span>
            </td>

            <td>{{Math.round(row.h_dyn*10)/10}}</td>
            <td>{{Math.round(row.p_annular*10)/10}}</td>
            <td>{{Math.round(row.bhp*10)/10}}</td>
            <td>{{Math.round(row.q_o*10)/10}}</td>
            <td>{{Math.round(row.q_l*10)/10}}</td>
            <td>{{Math.round(row.wct*10)/10}}</td>
            <td>{{row.well_status_last_day[0]}}</td>
            <td>{{Math.round(row.gor*10)/10}}</td>
            <td>{{Math.round(row.pi*10)/10}}</td>
            <td>{{Math.round(row.tp_idn_bhp*10)/10}}</td>
            <td>{{Math.round(row.tp_idn_liq*10)/10}}</td>
            <td>{{Math.round(row.tp_idn_oil_inc*10)/10}}</td>
            <td>{{Math.round(row.tp_idn_pi_after*10)/10}}</td>
            <td>{{Math.round(row.tp_idn_grp_q_liq*10)/10}}</td>
            <td>{{Math.round(row.tp_idn_grp_q_oil_inc*10)/10}}</td>
            <td>{{Math.round(row.EMPTY*10)/10}}</td>
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
        },
        getColor(status) {
            if (status === "1") return "#ffff00";
            return "#ff0000";
        }
    }
}
</script>
