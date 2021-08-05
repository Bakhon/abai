<template>
    <table class="table table-bordered table-dark table-responsive trkrtableborderedtabledarktableresponsive" style="background: #0D1E63; margin-bottom: 0;">
        <thead>
            <tr class="headerColumn trkrheadercolumn" style="background: #333975;">
                <td rowspan="4" class="th">№</td>
                <td rowspan="4" class="th" style="background: #333975;">{{trans('tr.ngdu_field')}}</td>
                <td rowspan="4" class="th">{{trans('tr.well_number')}}</td>
                <td rowspan="4" class="th">{{trans('tr.well_type')}}</td>
                <td rowspan="4" class="th">{{trans('tr.u_horizon')}}</td>
                <td rowspan="4" class="th">{{trans('tr.u_object')}}</td>
                <td rowspan="4" class="th">{{trans('tr.u_block')}}</td>
                <td rowspan="4" class="th">{{trans('tr.outer_diameter_producing_casing')}}</td>
                <td rowspan="4" class="th">{{trans('tr.artificial_slaughter')}}</td>
                <td rowspan="4" class="th">{{trans('tr.perforation_intervals')}}</td>
                <td rowspan="4" class="th">{{trans('tr.h_up_perf_md')}}</td>
                <td rowspan="4" class="th">{{trans('tr.productivity_index')}}</td>
                <td rowspan="4" class="th">{{trans('tr.operation_method')}}</td>
                <td rowspan="4" class="th">{{trans('tr.pump_type')}}</td>
                <td rowspan="4" class="th">{{trans('tr.outer_diameter_nkt')}}</td>
                <td rowspan="4" class="th">{{trans('tr.h_pump_set')}}</td>
                <td rowspan="4" class="th">{{trans('tr.tub_eqiup')}}</td>
                <td rowspan="4" class="th">{{trans('tr.h_packer_set')}}</td>
                <td rowspan="4" class="th">{{trans('tr.pump_frequency_or_speed')}}</td>
                <td rowspan="4" class="th">{{trans('tr.stroke_length')}}</td>
                <td rowspan="4" class="th">{{trans('tr.swing_number')}}</td>
                <td rowspan="4" class="th">{{trans('tr.choke_diameter')}}</td>


                <td class="colspan th" colspan="8">{{trans('tr.actual_mode')}}</td>
                <td rowspan="4" class="th">{{trans('tr.state_at_the_end_of_the_month')}}</td>
                <td class="colspan th" colspan="12">{{trans('tr.intended_mode')}}</td>
            </tr>
            <tr class="headerColumn trkrheadercolumn" style="background: #333975;">
                <td rowspan="3" class="th">{{trans('tr.h_dynamic')}}</td>
                <td rowspan="3" class="th">{{trans('tr.annular_pressure')}}</td>
                <td rowspan="3" class="th">{{trans('tr.pipe_pressure')}}</td>
                <td rowspan="3" class="th">{{trans('tr.p_layer')}}</td>
                <td rowspan="3" class="th" style="background: #333975;">{{trans('tr.bottomhole_pressure')}}</td>
                <td rowspan="3" class="th">{{trans('tr.q_oil')}}</td>
                <td rowspan="3" class="th" style="background: #333975;">{{trans('tr.q_liquid')}}</td>
                <td rowspan="3" class="th">{{trans('tr.water_cut')}}</td>

                <td rowspan="3" class="th">{{trans('tr.choke_diameter')}}</td>
                <td rowspan="3" class="th">{{trans('tr.q_oil')}}</td>
                <td rowspan="3" class="th" style="background: #333975;">{{trans('tr.q_liquid')}}</td>
                <td rowspan="3" class="th" style="background: #333975;">{{trans('tr.q_gas')}}</td>
                <td rowspan="3" class="th">{{trans('tr.water_cut')}}</td>
                <td rowspan="3" class="th">{{trans('tr.gas_factor')}}</td>
                <td rowspan="3" class="th"><span>{{trans('tr.work_days')}}</span></td>
                <td rowspan="3" class="th"><span>{{trans('tr.planned_monthly_oil')}}</span></td>
                <td rowspan="3" class="th"><span>{{trans('tr.planned_monthly_gas')}}</span></td>
                <td rowspan="3" class="th"><span>{{trans('tr.planned_monthly_liquid')}}</span></td>
                <td rowspan="3" class="th"><span>{{trans('tr.monthly_liquid_production')}}</span></td>
                <td rowspan="3" class="th"><span>{{trans('tr.tr_measure_to_ensure')}}</span></td>
                

            </tr>
            <tr class="headerColumn trkrheadercolumn" style="background: #333975;">
            </tr>
            <tr></tr>
            <tr class="subHeaderColumn" style="background: #333975; cursor: pointer;">
                <td class="th"><i class="fa fa-fw fa-sort"></i></td>
                <td class="th">
                    <div class="icons_filt_sort" ><i class="fa fa-fw fa-sort icon_sort" @click="sortBy('field')"></i>
                      <div>
                        <b-dropdown no-caret  toggle-class="drop-filter-custom" >
                          <template #button-content class="outer_button_filter">        
                            <i class="fas fa-filter icon_filter" ></i>
                          </template>
                            <b-dropdown-form class="external_field_filter">
                              <b-form-group
                                label=""
                                v-slot="{ ariaDescribedby }"
                                @submit.stop.prevent
                                class="field_form_fil"
                              >
                                <b-form-checkbox-group
                                  v-model="selectField"
                                  :options="fieldFilterData"
                                  :aria-describedby="ariaDescribedby"                                  
                                >
                                </b-form-checkbox-group>
                              </b-form-group>
                              <div class="field_filter_text">
                                <a href="#" class="form_text"  @click.prevent="chooseFilter"
                                  >{{trans('tr.form')}}
                                  </a>
                                  <a href="#" class="discard_text" @click.prevent="dropFilter('tr/SET_FIELD')"
                                  >{{trans('tr.reset')}}
                                  </a>
                              </div>
                            </b-dropdown-form>
                          </b-dropdown>
                        </div>
                      </div>
                    </td>
                <td class="th">
                    <div class="icons_filt_sort" ><i class="fa fa-fw fa-sort icon_sort" @click="sortBy('rus_wellname')"></i>
                      <div>
                        <b-dropdown no-caret  toggle-class="drop-filter-custom" >
                          <template #button-content class="outer_button_filter">        
                            <i class="fas fa-filter icon_filter" ></i>
                          </template>
                            <b-dropdown-form class="external_well_filter">
                              <b-form-group
                                label=""
                                v-slot="{ ariaDescribedby }"
                                @submit.stop.prevent
                                class="well_form_fil"
                              >
                                <b-form-checkbox-group
                                v-model="selectWellName"
                                :options="wellNameFilterData"
                                :aria-describedby="ariaDescribedby"                                  
                              >
                              </b-form-checkbox-group>
                              </b-form-group>
                              <div class="field_filter_text">
                                <a href="#" class="form_text"  @click.prevent="chooseFilter"
                                  >{{trans('tr.form')}}
                                  </a>
                                  <a href="#" class="discard_text" @click.prevent="dropFilter('tr/SET_WELLNAME')"
                                  >{{trans('tr.reset')}}
                                  </a>
                              </div>
                            </b-dropdown-form>
                          </b-dropdown>
                        </div>
                      </div>
                    </td>
                <td class="th">
                    <div class="icons_filt_sort" ><i class="fa fa-fw fa-sort icon_sort" @click="sortBy('well_type')"></i>
                      <div>
                        <b-dropdown no-caret  toggle-class="drop-filter-custom" >
                          <template #button-content class="outer_button_filter">        
                            <i class="fas fa-filter icon_filter" ></i>
                          </template>
                            <b-dropdown-form class="external_field_filter">
                              <b-form-group
                                label=""
                                v-slot="{ ariaDescribedby }"
                                @submit.stop.prevent
                                class="field_form_fil"
                              >
                                <b-form-checkbox-group
                                v-model="selectWellType"
                                :options="wellTypeFilterData"
                                :aria-describedby="ariaDescribedby"                                  
                              >
                              </b-form-checkbox-group>
                              </b-form-group>
                              <div class="field_filter_text">
                                <a href="#" class="form_text"  @click.prevent="chooseFilter"
                                  >{{trans('tr.form')}}
                                  </a>
                                  <a href="#" class="discard_text" @click.prevent="dropFilter('tr/SET_WELLTYPE')"
                                  >{{trans('tr.reset')}}
                                  </a>
                              </div>
                            </b-dropdown-form>
                          </b-dropdown>
                        </div>
                      </div>
                    </td>
                <td class="th">
                    <div class="icons_filt_sort" ><i class="fa fa-fw fa-sort icon_sort" @click="sortBy('horizon')"></i>
                      <div>
                        <b-dropdown no-caret  toggle-class="drop-filter-custom" >
                          <template #button-content class="outer_button_filter">        
                            <i class="fas fa-filter icon_filter" ></i>
                          </template>
                            <b-dropdown-form class="external_field_filter">
                              <b-form-group
                                label=""
                                v-slot="{ ariaDescribedby }"
                                @submit.stop.prevent
                                class="horizon_form_fil"
                              >
                                <b-form-checkbox-group
                                v-model="selectHorizon"
                                :options="horizonFilterData"
                                :aria-describedby="ariaDescribedby"                                  
                              >
                              </b-form-checkbox-group>
                              </b-form-group>
                              <div class="field_filter_text">
                                <a href="#" class="form_text"  @click.prevent="chooseFilter"
                                  >{{trans('tr.form')}}
                                  </a>
                                  <a href="#" class="discard_text" @click.prevent="dropFilter('tr/SET_HORIZON')"
                                  >{{trans('tr.reset')}}
                                  </a>
                              </div>
                            </b-dropdown-form>
                          </b-dropdown>
                        </div>
                      </div>
                    </td>
                <td class="th">
                    <div class="icons_filt_sort" ><i class="fa fa-fw fa-sort icon_sort" @click="sortBy('object')"></i>
                      <div>
                        <b-dropdown no-caret  toggle-class="drop-filter-custom" >
                          <template #button-content class="outer_button_filter">        
                            <i class="fas fa-filter icon_filter" ></i>
                          </template>
                            <b-dropdown-form class="external_field_filter">
                              <b-form-group
                                label=""
                                v-slot="{ ariaDescribedby }"
                                @submit.stop.prevent
                                class="obj_form_fil"
                              >
                              <b-form-checkbox-group
                                v-model="selectObject"
                                :options="objectFilterData"
                                :aria-describedby="ariaDescribedby"                                  
                              >
                              </b-form-checkbox-group>
                              </b-form-group>
                              <div class="field_filter_text">
                                <a href="#" class="form_text"  @click.prevent="chooseFilter"
                                  >{{trans('tr.form')}}
                                  </a>
                                  <a href="#" class="discard_text" @click.prevent="dropFilter('tr/SET_OBJECT')"
                                  >{{trans('tr.reset')}}
                                  </a>
                              </div>
                            </b-dropdown-form>
                          </b-dropdown>
                        </div>
                      </div>
                    </td> 
                <td class="th">
                    <div class="icons_filt_sort" ><i class="fa fa-fw fa-sort icon_sort" @click="sortBy('block')"></i>
                      <div>
                        <b-dropdown no-caret  toggle-class="drop-filter-custom" >
                          <template #button-content class="outer_button_filter">        
                            <i class="fas fa-filter icon_filter" ></i>
                          </template>
                            <b-dropdown-form class="external_field_filter">
                              <b-form-group
                                label=""
                                v-slot="{ ariaDescribedby }"
                                @submit.stop.prevent
                                class="block_form_fil"
                              >
                              <b-form-checkbox-group
                                v-model="selectBlock"
                                :options="blockFilterData"
                                :aria-describedby="ariaDescribedby"                                  
                              >
                              </b-form-checkbox-group>
                              </b-form-group>
                              <div class="field_filter_text">
                                <a href="#" class="form_text"  @click.prevent="chooseFilter"
                                  >{{trans('tr.form')}}
                                  </a>
                                  <a href="#" class="discard_text" @click.prevent="dropFilter('tr/SET_BLOCK')"
                                  >{{trans('tr.reset')}}
                                  </a>
                              </div>
                            </b-dropdown-form>
                          </b-dropdown>
                        </div>
                      </div>
                    </td>
                <td @click="sortBy('cas_OD')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.mm')}}</td>
                <td @click="sortBy('artificial_bottom_hole')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m')}}</td>
                <td @click="sortBy('perf_intervals')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m')}}</td>
                <td @click="sortBy('h_perf')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m')}}</td>
                <td @click="sortBy('pi')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3_day_atm')}}</td>
                <td class="th">
                    <div class="icons_filt_sort" ><i class="fa fa-fw fa-sort icon_sort" @click="sortBy('exp_meth')"></i>
                      <div>
                        <b-dropdown no-caret  toggle-class="drop-filter-custom" >
                          <template #button-content class="outer_button_filter">        
                            <i class="fas fa-filter icon_filter" ></i>
                          </template>
                            <b-dropdown-form class="external_field_filter">
                              <b-form-group
                                label=""
                                v-slot="{ ariaDescribedby }"
                                @submit.stop.prevent
                                class="exp_meth_form_fil"
                              >
                              <b-form-checkbox-group
                                v-model="selectExpMeth"
                                :options="expMethFilterData"
                                :aria-describedby="ariaDescribedby"                                  
                              >
                              </b-form-checkbox-group>
                              </b-form-group>
                              <div class="field_filter_text">
                                <a href="#" class="form_text"  @click.prevent="chooseFilter"
                                  >{{trans('tr.form')}}
                                  </a>
                                  <a href="#" class="discard_text" @click.prevent="dropFilter('tr/SET_EXPMETH')"
                                  >{{trans('tr.reset')}}
                                  </a>
                              </div>
                            </b-dropdown-form>
                          </b-dropdown>
                        </div>
                      </div>
                </td>
                <td @click="sortBy('pump_type')" class="th"><i class="fa fa-fw fa-sort"></i></td>
                <td @click="sortBy('tub_OD')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.mm')}}</td>
                <td @click="sortBy('h_pump_set')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m')}}</td>
                <td @click="sortBy('tub_eqiup')" class="th"><i class="fa fa-fw fa-sort"></i></td>
                <td @click="sortBy('h_packer_set')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m')}}</td>
                <td @click="sortBy('freq')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.gc_ob/min')}}</td>
                <td @click="sortBy('stroke_len')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m')}}</td>
                <td @click="sortBy('spm')" class="th"><i class="fa fa-fw fa-sort">{{trans('tr.swings/min')}}</i></td>
                <td @click="sortBy('choke_d')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.mm')}}</td>

                <td @click="sortBy('h_dyn')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m')}}</td>
                <td @click="sortBy('p_annular')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.atm')}}</td>
                <td @click="sortBy('p_tubing')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.atm')}}</td>
                <td @click="sortBy('p_res')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.atm')}}</td>
                <td @click="sortBy('bhp')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.atm')}}</td>
                <td @click="sortBy('q_o')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.t_day')}}</td>
                <td @click="sortBy('q_l')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3_day')}}</td>
                <td @click="sortBy('wct')" class="th"><i class="fa fa-fw fa-sort"></i>%</td>

                <td @click="sortBy('well_status_last_day')" class="th"><i class="fa fa-fw fa-sort"></i></td>

                <td @click="sortBy('planned_choke')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.mm')}}</td>
                <td @click="sortBy('planned_oil')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.t_day')}}</td>
                <td @click="sortBy('planned_liq')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3_day')}}</td>
                <td @click="sortBy('planned_gas')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.thousan_m3_day')}}</td>
                <td @click="sortBy('planned_wct')" class="th"><i class="fa fa-fw fa-sort"></i>%</td>
                <td @click="sortBy('planned_gor')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3/t')}}</td>
                <td @click="sortBy('planned_month_days')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.day')}}</td>
                <td @click="sortBy('planned_monthly_oil')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.tonn')}}</td>
                <td @click="sortBy('planned_monthly_gas')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.thousand_m3')}}</td>
                <td @click="sortBy('planned_monthly_liq')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3')}}</td>
                <td @click="sortBy('planned_monthly_water')" class="th"><i class="fa fa-fw fa-sort"></i>{{trans('tr.m3')}}</td>
                <td @click="sortBy('planned_events')" class="th"><i class="fa fa-fw fa-sort"></i></td>
            </tr>
        </thead>
        <tbody class="table_tbody">
            <tr v-for="(row, row_index) in wells" :key="row_index" class="trtablerow">
                <td class="fixcol" :class="{'activ': isActiveClass(row)}">{{ row_index + 1 }}</td>
                <td class="fixcol" :class="{'activ': isActiveClass(row)}">{{row.field}} </td>
                <td class="fixcol" :class="{'activ': isActiveClass(row)}">{{row.rus_wellname}} </td>
                <td :class="{'cell-with-comment': isCommentClass(row_index,`well_type`), 'activ': isActiveClass(row)}" td class="fixcol">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].well_type[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].well_type[1][0])}`"> </span>
                    <span>{{row.well_type[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].well_type[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`horizon`), 'activ': isActiveClass(row)}" class="tb">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].horizon[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].horizon[1][0])}`"> </span>
                    <span>{{row.horizon[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].horizon[1][1]}}
                    </span>
                </td>


                <td class="fixcol" :class="{'activ': isActiveClass(row)}">{{row.object}} </td>


                <td :class="{'cell-with-comment': isCommentClass(row_index,`block`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].block[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].block[1][0])}`"> </span>
                    <span>{{row.block[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].block[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`cas_OD`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].cas_OD[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].cas_OD[1][0])}`"> </span>
                    <span v-if="row.cas_OD[0]!=null">{{row.cas_OD[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].cas_OD[1][1]}}
                    </span>
                </td>

                <td class="fixcol" :class="{'activ': isActiveClass(row)}">{{row.artificial_bottom_hole}} </td>

                <td class="fixcol" :class="{'activ': isActiveClass(row)}">{{row.perf_intervals}} </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`h_perf`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].h_perf[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].h_perf[1][0])}`"> </span>
                    <span v-if="row.h_perf[0]!=null">{{row.h_perf[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].h_perf[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`pi`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].pi[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].pi[1][0])}`"> </span>
                    <span v-if="row.pi[0]!=null">{{Math.round(row.pi[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].pi[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`exp_meth`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].exp_meth[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].exp_meth[1][0])}`"> </span>
                    <span>{{row.exp_meth[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].exp_meth[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`pump_type`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].pump_type[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].pump_type[1][0])}`"> </span>
                    <span>{{row.pump_type[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].pump_type[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`tub_OD`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].tub_OD[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].tub_OD[1][0])}`"> </span>
                    <span v-if="row.tub_OD[0]!=null">{{row.tub_OD[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].tub_OD[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`h_pump_set`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].h_pump_set[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].h_pump_set[1][0])}`"> </span>
                    <span v-if="row.h_pump_set[0]!=null">{{Math.round(row.h_pump_set[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].h_pump_set[1][1]}}
                    </span>
                </td>

                <td class="fixcol" :class="{'activ': isActiveClass(row)}">{{row.tub_eqiup}} </td>   

                <td class="fixcol" :class="{'activ': isActiveClass(row)}">{{row.h_packer_set}} </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`freq`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].freq[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].freq[1][0])}`"> </span>
                    <span v-if="row.freq[0]!=null">{{row.freq[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].freq[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`stroke_len`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].stroke_len[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].stroke_len[1][0])}`"> </span>
                    <span v-if="row.stroke_len[0]!=null">{{row.stroke_len[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].stroke_len[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`spm`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].spm[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].spm[1][0])}`"> </span>
                    <span v-if="row.spm[0]!=null">{{row.spm[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].spm[1][1]}}
                    </span>
                </td>
                
                <td :class="{'cell-with-comment': isCommentClass(row_index,`choke_d`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].choke_d[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].choke_d[1][0])}`"> </span>
                    <span v-if="row.choke_d[0]!=null">{{row.choke_d[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].choke_d[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`h_dyn`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].h_dyn[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].h_dyn[1][0])}`"> </span>
                    <span v-if="row.h_dyn[0]!=null">{{Math.round(row.h_dyn[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].h_dyn[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`p_annular`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].p_annular[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].p_annular[1][0])}`"> </span>
                    <span v-if="row.p_annular[0]!=null">{{Math.round(row.p_annular[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].p_annular[1][1]}}
                    </span>
                </td>

                <td class="fixcol" :class="{'activ': isActiveClass(row)}">{{row.p_tubing}} </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`p_res`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].p_res[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].p_res[1][0])}`"> </span>
                    <span v-if="row.p_res[0]!=null">{{Math.round(row.p_res[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].p_res[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`bhp`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].bhp[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].bhp[1][0])}`"> </span>
                    <span v-if="row.bhp[0]!=null">{{Math.round(row.bhp[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].bhp[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`q_o`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].q_o[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].q_o[1][0])}`"> </span>
                    <span v-if="row.q_o[0]!=null">{{Math.round(row.q_o[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].q_o[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`q_l`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].q_l[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].q_l[1][0])}`"> </span>
                    <span v-if="row.q_l[0]!=null">{{Math.round(row.q_l[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].q_l[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`wct`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].wct[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].wct[1][0])}`"> </span>
                    <span v-if="row.wct[0]!=null">{{Math.round(row.wct[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].wct[1][1]}}
                    </span>
                </td>


                <td :class="{'cell-with-comment': isCommentClass(row_index,`well_status_last_day`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].well_status_last_day[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].well_status_last_day[1][0])}`"> </span>
                    <span v-if="row.well_status_last_day[0]!=null">{{row.well_status_last_day[0]}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].well_status_last_day[1][1]}}
                    </span>
                </td>

                
                <td :class="{'cell-with-comment': isCommentClass(row_index,`planned_choke`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_choke[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_choke[1][0])}`"> </span>
                    <span v-if="row.planned_choke[0]!=null">{{Math.round(row.planned_choke[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_choke[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`planned_oil`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_oil[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_oil[1][0])}`"> </span>
                    <span v-if="row.planned_oil[0]!=null">{{Math.round(row.planned_oil[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_oil[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`planned_liq`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_liq[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_liq[1][0])}`"> </span>
                    <span v-if="row.planned_liq[0]!=null">{{Math.round(row.planned_liq[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_liq[1][1]}}
                    </span>
                </td>

                <td class="fixcol" :class="{'activ': isActiveClass(row)}">{{Math.round(row.planned_gas*10)/10}} </td>


                <td :class="{'cell-with-comment': isCommentClass(row_index,`planned_wct`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_wct[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_wct[1][0])}`"> </span>
                    <span v-if="row.planned_wct[0]!=null">{{Math.round(row.planned_wct[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_wct[1][1]}}
                    </span>
                </td>

                <td class="fixcol" :class="{'activ': isActiveClass(row)}">{{Math.round(row.planned_month_days*10)/10}} </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`planned_month_days`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_month_days[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_month_days[1][0])}`"> </span>
                    <span v-if="row.planned_month_days[0]!=null">{{Math.round(row.planned_month_days[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_month_days[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`planned_monthly_oil`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_monthly_oil[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_monthly_oil[1][0])}`"> </span>
                    <span v-if="row.planned_monthly_oil[0]!=null">{{Math.round(row.planned_monthly_oil[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_monthly_oil[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`planned_monthly_gas`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_monthly_gas[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_monthly_gas[1][0])}`"> </span>
                    <span v-if="row.planned_monthly_gas[0]!=null">{{Math.round(row.planned_monthly_gas[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_monthly_gas[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`planned_monthly_liq`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_monthly_liq[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_monthly_liq[1][0])}`"> </span>
                    <span v-if="row.planned_monthly_liq[0]!=null">{{Math.round(row.planned_monthly_liq[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_monthly_liq[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`planned_monthly_water`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_monthly_water[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_monthly_water[1][0])}`"> </span>
                    <span v-if="row.planned_monthly_water[0]!=null">{{Math.round(row.planned_monthly_water[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_monthly_water[1][1]}}
                    </span>
                </td>

                <td :class="{'cell-with-comment': isCommentClass(row_index,`planned_events`), 'activ': isActiveClass(row)}">
                    <span :class="{'circle-err': wells && wells[row_index] &&
                wells[row_index].planned_events[1][0] !== '0'}" :style="`background :${getColor(
                wells[row_index].planned_events[1][0])}`"> </span>
                    <span v-if="row.planned_events[0]!=null">{{Math.round(row.planned_events[0]*10)/10}}</span>
                    <span v-if="wells && wells[row_index]" class="cell-comment">
                        {{ wells[row_index].planned_events[1][1]}}
                    </span>
                </td>

            </tr>
        </tbody>
    </table>
</template>
<script>
export default {
    name: "TrTable",
    props: {
        wells: Array,
        blockFilterData: Array,
        horizonFilterData: Array,
        objectFilterData: Array,
        fieldFilterData: Array,
        wellTypeFilterData: Array,
        expMethFilterData: Array,
        wellNameFilterData: Array,
    },
    computed: {
        selectHorizon: {
            get(){
                return this.$store.state.tr.horizon;
            }, 
            set(newVal){
                this.$store.commit("tr/SET_HORIZON", newVal);
            }, 
        },
        selectObject: {
            get(){
                return this.$store.state.tr.object;
            }, 
            set(newVal){
                this.$store.commit("tr/SET_OBJECT", newVal);
            }, 
        },
        selectField: {
            get(){
                return this.$store.state.tr.field;
            }, 
            set(newVal){
                this.$store.commit("tr/SET_FIELD", newVal);
            }, 
        },
        selectExpMeth: {
            get(){
                return this.$store.state.tr.expMeth;
            }, 
            set(newVal){
                this.$store.commit("tr/SET_EXPMETH", newVal);
            }, 
        },
        selectWellType: {
            get(){
                return this.$store.state.tr.wellType;
            }, 
            set(newVal){
                this.$store.commit("tr/SET_WELLTYPE", newVal);
            }, 
        },
        selectWellName: {
            get(){
                return this.$store.state.tr.wellName;
            }, 
            set(newVal){
                this.$store.commit("tr/SET_WELLNAME", newVal);
            }, 
        },
        selectBlock: {
            get(){
                return this.$store.state.tr.block;
            }, 
            set(newVal){
                this.$store.commit("tr/SET_BLOCK", newVal);
            }, 
        },
    },
    data: function () {
        return {
            isEdit: false,
        }
    },
    methods: {
        sortBy(type) {
            this.$emit('onSort', type);
        },
        dropFilter(x) {
            this.$emit('dropFilters', x);
        },
        getColor(status) {
            if (status === "1") return "#ffff00";
            return "#ff0000";
        },
        editable(row) {
            console.log(row)
        },
        chooseFilter() {
             this.$emit('filter');
        },
        isCommentClass (row_index, value) {
        return this.wells &&
            this.wells[row_index] &&
            this.wells[row_index][value][1][0] !== '0';
        },
        isActiveClass (row) {
            if (row.rus_wellname) {
                return false
            } else {
                return true
            }
        },
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
.activ.activ {
  border-bottom: 2px solid rgb(145, 145, 145) ;
  border-top: 2px solid rgb(145, 145, 145);
  font-size: 11px;
}

</style>