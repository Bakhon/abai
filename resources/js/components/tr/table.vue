<template>
    <table class="table table-bordered table-dark table-responsive trkrtableborderedtabledarktableresponsive" style="background: #0D1E63; margin-bottom: 0;">
        <thead>
            <tr class="headerColumn trkrheadercolumn" style="background: #333975;">
                <td rowspan="4" class="th" style="background: #333975;">{{trans('tr.well_number')}}</td>
                <td rowspan="4" class="th">{{trans('tr.well_type')}}</td>
                <td rowspan="4" class="th">{{trans('tr.u_horizon')}}</td>
                <td rowspan="4" class="th">{{trans('tr.u_object')}}</td>
                <td rowspan="4" class="th">{{trans('tr.block')}}</td>
                <td rowspan="4" class="th">{{trans('tr.outer_diameter_producing_casing')}}</td>
                <td rowspan="4" class="th">{{trans('tr.outer_diameter_nkt')}}</td>
                <td rowspan="4" class="th">{{trans('tr.choke_diameter')}}</td>
                <td rowspan="4" class="th">{{trans('tr.h_water_permeability')}}</td>
                <td rowspan="4" class="th">{{trans('tr.operation_method')}}</td>
                <td rowspan="4" class="th">{{trans('tr.pump_type')}}</td>
                <td rowspan="4" class="th">{{trans('tr.pump_frequency_or_speed')}}</td>
                <td rowspan="4" class="th">{{trans('tr.h_pump_set')}}</td>
                <td rowspan="4" class="th">{{trans('tr.p_layer')}}</td>
                <td rowspan="4" class="th">{{trans('tr.h_dynamic')}}</td>
                <td rowspan="4" class="th">{{trans('tr.annular_pressure')}}</td>
                <td class="colspan th" colspan="5">{{trans('tr.actual_mode')}}</td>
                <td rowspan="4" class="th">{{trans('tr.state_at_the_end_of_the_month')}}</td>
                <td rowspan="4" class="th">{{trans('tr.productivity_index')}}</td>
                <td class="colspan th" colspan="7">{{trans('tr.calculation_of_technological_potential_from_IDN')}}</td>
                <td class="colspan th" colspan="6">{{trans('tr.intended_mode')}}</td>
            </tr>
            <tr class="headerColumn trkrheadercolumn" style="background: #333975;">
                <td rowspan="3" class="th" style="background: #333975;">{{trans('tr.bottomhole_pressure')}}</td>
                <td rowspan="3" class="th">{{trans('tr.q_oil')}}</td>
                <td rowspan="3" class="th" style="background: #333975;">{{trans('tr.q_liquid')}}</td>
                <td rowspan="3" class="th">{{trans('tr.water_cut')}}</td>
                <td rowspan="3" class="th">{{trans('tr.gas_factor')}}</td>
                <td rowspan="3" class="th">{{trans('tr.bottomhole_pressure')}}</td>
                <td class="colspan th" colspan="2">{{trans('tr.idn')}}</td>
                <td rowspan="3" class="th">{{trans('tr.stimulation_coefficient_of_productivity')}}</td>
                <td class="colspan th" colspan="2">{{trans('tr.grp')}}</td>
                <td rowspan="3" class="th">{{trans('tr.q_oil_total_growth')}}</td>

                <td rowspan="3" class="th">{{trans('tr.choke_diameter')}}</td>
                <td rowspan="3" class="th">{{trans('tr.q_oil')}}</td>
                <td rowspan="3" class="th" style="background: #333975;">{{trans('tr.q_liquid')}}</td>
                <td rowspan="3" class="th" style="background: #333975;">{{trans('tr.q_gas')}}</td>
                <td rowspan="3" class="th">{{trans('tr.water_cut')}}</td>
                <td rowspan="3" class="th">{{trans('tr.gas_factor')}}</td>

            </tr>
            <tr class="headerColumn trkrheadercolumn" style="background: #333975;">
                <td rowspan="2" class="th" style="background: #333975;">{{trans('tr.q_liquid')}}</td>
                <td rowspan="2" class="th" style="background: #333975;">{{trans('tr.q_oil_gain')}}</td>
                <td rowspan="2" class="th" style="background: #333975;">{{trans('tr.q_liquid')}}</td>
                <td rowspan="2" class="th">{{trans('tr.q_oil_gain')}}</td>
            </tr>
            <tr></tr>
            <tr class="subHeaderColumn" style="background: #333975; cursor: pointer;">
                <td @click="sortBy('well')" class="th" style="background: #333975;"><i class="fa fa-fw fa-sort"></i></td>
                <td @click="sortBy('well_type')" class="th"><i class="fa fa-fw fa-sort"></i></td>
                <td @click="sortBy('horizon')" class="th"><i class="fa fa-fw fa-sort"></i></td>
                <td @click="sortBy('object')" class="th"><i class="fa fa-fw fa-sort"></i></td>
                <td @click="sortBy('block')" class="th"><i class="fa fa-fw fa-sort"></i></td>
                <td @click="sortBy('cas_OD')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.mm')}}</td>
                <td @click="sortBy('tub_OD')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.mm')}}</td>
                <td @click="sortBy('choke_d')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.mm')}}</td>
                <td @click="sortBy('h_up_perf_md')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m')}}</td>
                <td @click="sortBy('exp_meth')" class="th"><i class="fa fa-fw fa-sort"></i></td>
                <td @click="sortBy('pump_type')" class="th"><i class="fa fa-fw fa-sort"></i></td>
                <td @click="sortBy('freq')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.gc_ob/min')}}</td>
                <td @click="sortBy('h_pump_set')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m')}}</td>
                <td @click="sortBy('p_res')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.atm')}}</td>
                <td @click="sortBy('h_dyn')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m')}}</td>
                <td @click="sortBy('p_annular')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.atm')}}</td>
                <td @click="sortBy('bhp')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.atm')}}</td>
                <td @click="sortBy('q_o')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.t_day')}}</td>
                <td @click="sortBy('q_l')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3_day')}}</td>
                <td @click="sortBy('wct')" class="th"><i class="fa fa-fw fa-sort"></i>%</td>
                <td @click="sortBy('gor')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3/t')}}</td>
                <td @click="sortBy('well_status_last_day')" class="th"><i class="fa fa-fw fa-sort"></i></td>
                <td @click="sortBy('pi')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3_day_atm')}}</td>
                <td @click="sortBy('tp_idn_bhp')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.atm')}}</td>
                <td @click="sortBy('tp_idn_liq')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3_day')}}</td>
                <td @click="sortBy('tp_idn_oil_inc')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.t_day')}}</td>
                <td @click="sortBy('tp_idn_pi_after')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3_day_atm')}}</td>
                <td @click="sortBy('tp_idn_grp_q_liq')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3_day')}}</td>
                <td @click="sortBy('tp_idn_grp_q_oil_inc')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.t_day')}}</td>
                <td @click="sortBy('gt_total_inc')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.t_day')}}</td>
                <td @click="sortBy('planned_choke')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.mm')}}</td>
                <td @click="sortBy('planned_oil')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.t_day')}}</td>
                <td @click="sortBy('planned_liq')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3_day')}}</td>
                <td @click="sortBy('planned_gas')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.thousan_m3_day')}}</td>
                <td @click="sortBy('planned_wct')" class="th"><i class="fa fa-fw fa-sort"></i>%</td>
                <td @click="sortBy('planned_gor')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3/t')}}</td>
            </tr>
        </thead>
        <tbody class="table_tbody">
            <tr v-for="(row, row_index) in wells" :key="row_index" class="trtablerow">
                <td class="fixcol">{{row.rus_wellname}} </td>
                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].well_type[1][0] !== '0'}" td class="fixcol">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].well_type[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].well_type[1][0])}`"> </span>
                    <span>{{row.well_type[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].well_type[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].horizon[1][0] !== '0'}" class="tb">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].horizon[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].horizon[1][0])}`"> </span>
                    <span>{{row.horizon[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].horizon[1][1]}}
                    </span>
                </td>


                <td class="fixcol">{{row.object}} </td>


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

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].cas_OD[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].cas_OD[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].cas_OD[1][0])}`"> </span>
                    <span v-if="row.cas_OD[0]!=null">{{row.cas_OD[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].cas_OD[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].tub_OD[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].tub_OD[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].tub_OD[1][0])}`"> </span>
                    <span v-if="row.tub_OD[0]!=null">{{row.tub_OD[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].tub_OD[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].choke_d[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].choke_d[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].choke_d[1][0])}`"> </span>
                    <span v-if="row.choke_d[0]!=null">{{row.choke_d[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].choke_d[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].h_up_perf_md[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].h_up_perf_md[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].h_up_perf_md[1][0])}`"> </span>
                    <span v-if="row.h_up_perf_md[0]!=null">{{Math.round(row.h_up_perf_md[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].h_up_perf_md[1][1]}}
                    </span>
                </td>
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

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].freq[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].freq[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].freq[1][0])}`"> </span>
                    <span v-if="row.freq[0]!=null">{{row.freq[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].freq[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].h_pump_set[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].h_pump_set[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].h_pump_set[1][0])}`"> </span>
                    <span v-if="row.h_pump_set[0]!=null">{{Math.round(row.h_pump_set[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].h_pump_set[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].p_res[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].p_res[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].p_res[1][0])}`"> </span>
                    <span v-if="row.p_res[0]!=null">{{Math.round(row.p_res[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].p_res[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].h_dyn[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].h_dyn[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].h_dyn[1][0])}`"> </span>
                    <span v-if="row.h_dyn[0]!=null">{{Math.round(row.h_dyn[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].h_dyn[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].p_annular[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].p_annular[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].p_annular[1][0])}`"> </span>
                    <span v-if="row.p_annular[0]!=null">{{Math.round(row.p_annular[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].p_annular[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].bhp[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].bhp[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].bhp[1][0])}`"> </span>
                    <span v-if="row.bhp[0]!=null">{{Math.round(row.bhp[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].bhp[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].q_o[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].q_o[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].q_o[1][0])}`"> </span>
                    <span v-if="row.q_o[0]!=null">{{Math.round(row.q_o[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].q_o[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].q_l[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].q_l[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].q_l[1][0])}`"> </span>
                    <span v-if="row.q_l[0]!=null">{{Math.round(row.q_l[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].q_l[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].wct[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].wct[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].wct[1][0])}`"> </span>
                    <span v-if="row.wct[0]!=null">{{Math.round(row.wct[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].wct[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].gor[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].gor[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].gor[1][0])}`"> </span>
                    <span v-if="row.gor[0]!=null">{{Math.round(row.gor[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].gor[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].well_status_last_day[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].well_status_last_day[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].well_status_last_day[1][0])}`"> </span>
                    <span v-if="row.well_status_last_day[0]!=null">{{row.well_status_last_day[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].well_status_last_day[1][1]}}
                    </span>
                </td>


                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].pi[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].pi[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].pi[1][0])}`"> </span>
                    <span v-if="row.pi[0]!=null">{{Math.round(row.pi[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].pi[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].tp_idn_bhp[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].tp_idn_bhp[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].tp_idn_bhp[1][0])}`"> </span>
                    <span v-if="row.tp_idn_bhp[0]!=null">{{Math.round(row.tp_idn_bhp[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].tp_idn_bhp[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].tp_idn_liq[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].tp_idn_liq[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].tp_idn_liq[1][0])}`"> </span>
                    <span v-if="row.tp_idn_liq[0]!=null">{{Math.round(row.tp_idn_liq[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].tp_idn_liq[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].tp_idn_oil_inc[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].tp_idn_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].tp_idn_oil_inc[1][0])}`"> </span>
                    <span v-if="row.tp_idn_oil_inc[0]!=null">{{Math.round(row.tp_idn_oil_inc[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].tp_idn_oil_inc[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].tp_idn_pi_after[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].tp_idn_pi_after[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].tp_idn_pi_after[1][0])}`"> </span>
                    <span v-if="row.tp_idn_pi_after[0]!=null">{{Math.round(row.tp_idn_pi_after[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].tp_idn_pi_after[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].tp_idn_grp_q_liq[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].tp_idn_grp_q_liq[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].tp_idn_grp_q_liq[1][0])}`"> </span>
                    <span v-if="row.tp_idn_grp_q_liq[0]!=null">{{Math.round(row.tp_idn_grp_q_liq[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].tp_idn_grp_q_liq[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].tp_idn_grp_q_oil_inc[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].tp_idn_grp_q_oil_inc[1][0])}`"> </span>
                    <span v-if="row.tp_idn_grp_q_oil_inc[0]!=null">{{Math.round(row.tp_idn_grp_q_oil_inc[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].tp_idn_grp_q_oil_inc[1][1]}}
                    </span>
                </td>

                <td><span v-if="row.gt_total_inc!=null">{{Math.round(row.gt_total_inc*10)/10}}</span></td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].planned_choke[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_choke[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_choke[1][0])}`"> </span>
                    <span v-if="row.planned_choke[0]!=null">{{Math.round(row.planned_choke[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_choke[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].planned_oil[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_oil[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_oil[1][0])}`"> </span>
                    <span v-if="row.planned_oil[0]!=null">{{Math.round(row.planned_oil[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_oil[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].planned_liq[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_liq[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_liq[1][0])}`"> </span>
                    <span v-if="row.planned_liq[0]!=null">{{Math.round(row.planned_liq[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_liq[1][1]}}
                    </span>
                </td>

                <td class="fixcol">{{Math.round(row.planned_gas*10)/10}} </td>


                <td :class="{'cell-with-comment': wells && wells[row_index] &&
                wells[row_index].planned_wct[1][0] !== '0'}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_wct[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_wct[1][0])}`"> </span>
                    <span v-if="row.planned_wct[0]!=null">{{Math.round(row.planned_wct[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_wct[1][1]}}
                    </span>
                </td>

                <td class="fixcol">{{Math.round(row.planned_gor*10)/10}} </td>

            </tr>
        </tbody>
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
<style scoped>
.trkrheadercolumn {
    background: #333975;
}
.trkrsubheadercolumn {
    background: #333975;
}
tr:nth-child(odd) {
  background-color: #454d7d;
}
tr:nth-child(even) {
  background-color: #454d7d73;
}
.table th, .table td {
    padding: 5px !important;
}
.trkrtableborderedtabledarktableresponsive {
    font-size: 9px;
    padding: unset;
}

.table .th {
    position: sticky;
    background: rgb(51, 57, 117);
}
.table tr:first-child .th {
    top: -1px;
    z-index: 3000;
}
.table.table tr .th:first-child {
    z-index: 3010;
}
.table tr:nth-child(2) .th {
    top: 22px;
    z-index: 3000;
}
.table tr:nth-child(3) .th {
    top: 46px;
    z-index: 3000;
}
.table tr:nth-child(4) .th {
    top: 81px;
    z-index: 3000;
}
.table tr:nth-child(5) .th {
    top: 88px;
    z-index: 3000;
}


.trtablerow {
    position: relative;
}

tr td:first-child {
  position: sticky;
  left: -1px;
  width: 100px;
  z-index: 3009;
}

tr:nth-child(odd) .fixcol:first-child {
  background-color: #454d7d;
}
tr:nth-child(even) .fixcol:first-child {
  background-color: #26336f;
}


.table_tbody {
position: static;
}



/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #333975;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #656A8A;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #272953;
}

</style>