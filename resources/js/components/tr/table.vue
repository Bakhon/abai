<template>
    <table class="table table-bordered table-dark table-responsive ce" style="position: sticky;left: 5.31%;right: 2.4%;top: 48.21%;bottom: 66.58%;background: #0D1E63;">
        <tr class="headerColumn" style="background: #333975 ">
            <td rowspan="4">№ скв</td>
            <td rowspan="4">Тип скважины</td>
            <td rowspan="4">Горизонт</td>
            <td rowspan="4">Блок</td>
            <td rowspan="4">Наружный диаметр э/к</td>
            <td rowspan="4">Наружный диаметр НКТ</td>
            <td rowspan="4">Диаметр штуцера</td>
            <td rowspan="4">Нвдп</td>
            <td rowspan="4">Способ эксплуатации</td>
            <td rowspan="4">Тип насоса</td>
            <td rowspan="4">Частота работы насоса или число оборотов</td>
            <td rowspan="4">Н сп насоса</td>
            <td rowspan="4">Р пл</td>
            <td rowspan="4">Н дин</td>
            <td rowspan="4">Р затр</td>
            <td class="colspan" colspan="4">Фактический режим</td>
            <td rowspan="4">Состояние на конец месяца</td>
            <td rowspan="4">ГФ</td>
            <td rowspan="4">К прод</td>
            <td class="colspan" colspan="7">Расчет технологического потенциала от ИДН</td>
        </tr>
        <tr class="headerColumn">
            <td rowspan="3" style="background: #333975 ">P заб</td>
            <td rowspan="3" style="background: #333975 ">Q н</td>
            <td rowspan="3" style="background: #333975 ">Q ж</td>
            <td rowspan="3" style="background: #333975 ">Обводненность</td>
            <td rowspan="3" style="background: #333975 ">P заб</td>
            <td class="colspan" colspan="2" style="background: #333975 ">ИДН</td>
            <td rowspan="3" style="background: #333975 ">К прод от стимуляции</td>
            <td class="colspan" colspan="2" style="background: #333975 ">ГРП</td>
            <td rowspan="3" style="background: #333975 ">Общий прирост Q н</td>
        </tr>
        <tr class="headerColumn">
            <td rowspan="2" style="background: #333975 ">Q ж</td>
            <td rowspan="2" style="background: #333975 ">Прирост Q н</td>
            <td rowspan="2" style="background: #333975 ">Q ж</td>
            <td rowspan="2" style="background: #333975 ">Прирост Q н</td>
        </tr>
        <tr></tr>
        <tr class="subHeaderColumn" style="background: #333975">
            <td @click="sortBy('well')"></td>
            <td @click="sortBy('well_type')"></td>
            <td @click="sortBy('horizon')"></td>
            <td @click="sortBy('block')"></td>
            <td @click="sortBy('cas_OD')">мм</td>
            <td @click="sortBy('tub_OD')">мм</td>
            <td @click="sortBy('choke_d')">мм</td>
            <td @click="sortBy('h_up_perf_md')">м</td>
            <td @click="sortBy('exp_meth')"></td>
            <td @click="sortBy('pump_type')"></td>
            <td @click="sortBy('freq')">Гц, об/мин</td>
            <td @click="sortBy('h_pump_set')">м</td>
            <td @click="sortBy('p_res')">атм</td>
            <td @click="sortBy('h_dyn')">м</td>
            <td @click="sortBy('p_annular')">атм</td>
            <td @click="sortBy('bhp')">атм</td>
            <td @click="sortBy('q_o')">т/сут</td>
            <td @click="sortBy('q_l')">м3/сут</td>
            <td @click="sortBy('wct')">%</td>
            <td @click="sortBy('well_status_last_day')"></td>
            <td @click="sortBy('gor')">м3/т</td>
            <td @click="sortBy('pi')">м3/сут/атм</td>
            <td @click="sortBy('tp_idn_bhp')">атм</td>
            <td @click="sortBy('tp_idn_liq')">м3/сут</td>
            <td @click="sortBy('tp_idn_oil_inc')">т/сут</td>
            <td @click="sortBy('tp_idn_pi_after')">м3/сут/атм</td>
            <td @click="sortBy('tp_idn_grp_q_liq')">м3/сут</td>
            <td @click="sortBy('tp_idn_grp_q_oil_inc')">т/сут</td>
            <td @click="sortBy('EMPTY')">т/сут</td>
        </tr>
        <tr v-for="(row, row_index) in wells" :key="row_index">
            <td>{{row.well}}</td>
            <!-- <td>{{row.well_type}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].well_type[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].well_type[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].well_type[1][0])}`"> </span>
                <span>{{row.well_type[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].well_type[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.horizon}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].horizon[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].horizon[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].horizon[1][0])}`"> </span>
                <span>{{row.horizon[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].horizon[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.block}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].block[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].block[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].block[1][0])}`"> </span>
                <span>{{row.block[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].block[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.cas_OD}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].cas_OD[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].cas_OD[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].cas_OD[1][0])}`"> </span>
                <span>{{row.cas_OD[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].cas_OD[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.tub_OD}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tub_OD[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tub_OD[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tub_OD[1][0])}`"> </span>
                <span>{{row.tub_OD[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tub_OD[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.choke_d}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].choke_d[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].choke_d[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].choke_d[1][0])}`"> </span>
                <span>{{row.choke_d[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].choke_d[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.h_up_perf_md}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].h_up_perf_md[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].h_up_perf_md[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].h_up_perf_md[1][0])}`"> </span>
                <span>{{Math.round(row.h_up_perf_md[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].h_up_perf_md[1][1]}}
                </span>
            </td>
            <!-- <td>{{row.exp_meth}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].exp_meth[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].exp_meth[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].exp_meth[1][0])}`"> </span>
                <span>{{row.exp_meth[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].exp_meth[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.pump_type}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].pump_type[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].pump_type[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].pump_type[1][0])}`"> </span>
                <span>{{row.pump_type[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].pump_type[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.freq[1][1]}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].freq[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].freq[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].freq[1][0])}`"> </span>
                <span>{{wells[row_index].freq[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].freq[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.h_pump_set*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].h_pump_set[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].h_pump_set[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].h_pump_set[1][0])}`"> </span>
                <span>{{Math.round(row.h_pump_set[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].h_pump_set[1][1]}}
                </span>
            </td>

            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].p_res[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].p_res[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].p_res[1][0])}`"> </span>
                <span>{{Math.round(row.p_res[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].p_res[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.h_dyn*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].h_dyn[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].h_dyn[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].h_dyn[1][0])}`"> </span>
                <span>{{Math.round(row.h_dyn[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].h_dyn[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.p_annular*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].p_annular[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].p_annular[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].p_annular[1][0])}`"> </span>
                <span>{{Math.round(row.p_annular[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].p_annular[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.bhp*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].bhp[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].bhp[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].bhp[1][0])}`"> </span>
                <span>{{Math.round(row.bhp[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].bhp[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.q_o*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].q_o[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].q_o[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].q_o[1][0])}`"> </span>
                <span>{{Math.round(row.q_o[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].q_o[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.q_l*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].q_l[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].q_l[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].q_l[1][0])}`"> </span>
                <span>{{Math.round(row.q_l[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].q_l[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.wct*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].wct[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].wct[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].wct[1][0])}`"> </span>
                <span>{{Math.round(row.wct[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].wct[1][1]}}
                </span>
            </td>

            <!-- <td>{{row.well_status_last_day[0]}}</td> -->

            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].well_status_last_day[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].well_status_last_day[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].well_status_last_day[1][0])}`"> </span>
                <span>{{row.well_status_last_day[0]}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].well_status_last_day[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.gor*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].gor[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].gor[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].gor[1][0])}`"> </span>
                <span>{{Math.round(row.gor[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].gor[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.pi*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].pi[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].pi[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].pi[1][0])}`"> </span>
                <span>{{Math.round(row.pi[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].pi[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_bhp*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_bhp[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_bhp[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_bhp[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_bhp[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_bhp[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_liq*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_liq[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_liq[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_liq[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_liq[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_liq[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_oil_inc*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_oil_inc[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_oil_inc[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_oil_inc[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_oil_inc[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_pi_after*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_pi_after[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_pi_after[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_pi_after[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_pi_after[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_pi_after[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_grp_q_liq*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_grp_q_liq[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_grp_q_liq[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_grp_q_liq[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_grp_q_liq[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_grp_q_liq[1][1]}}
                </span>
            </td>

            <!-- <td>{{Math.round(row.tp_idn_grp_q_oil_inc*10)/10}}</td> -->
            <td :class="{'cell-with-comment': wells && wells[row_index] &&
            wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0'}">
                <span :class="{'circle-err': wells && wells[row_index] &&
            wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
            wells[row_index].tp_idn_grp_q_oil_inc[1][0])}`"> </span>
                <span>{{Math.round(row.tp_idn_grp_q_oil_inc[0]*10)/10}}</span>
                <span v-if="wells && wells[row_index]" class="cell-comment">
                    {{ wells[row_index].tp_idn_grp_q_oil_inc[1][1]}}
                </span>
            </td>

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
    data: function () {
        return {
            edit: false,
        }
    },
    methods: {
        sortBy(type) {
            this.$emit('onSort', type);
        },
        getColor(status) {
            if (status === "1") return "#ffff00";
            return "#ff0000";
        },
        editable(row) {
            console.log(row)
        }
    }
}
</script>
