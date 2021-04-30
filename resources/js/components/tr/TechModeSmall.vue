<template>
    <div class="table-outer"> 
          <div class="table-inner abat_tr">
                
                    
                    <el-table-column
                      :label="trans('tr.well_number')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="rus_wellname"
                            label=""
                            width="150"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.well_type')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="well_type"
                            label=""
                            width="150"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `well_type`)" :placement="isPlacement(scope.$index, `well_type`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`well_type`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`well_type`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].well_type[1][0]
                                            )}`"
                                          >
                                          </span><span>{{ scope.row.well_type[0] }}</span>  

                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.horizon')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="horizon"
                            label=""
                            width="100"
                            sortable

                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `horizon`)" :placement="isPlacement(scope.$index, `horizon`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`horizon`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`horizon`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].horizon[1][0]
                                            )}`"
                                          >
                                          </span><span>{{ scope.row.horizon[0] }}</span>  
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.object')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="object"
                            label=""
                            width="150"
                            sortable

                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.block')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="block"
                            label=""
                            width="150"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `block`)" :placement="isPlacement(scope.$index, `block`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`horizon`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`block`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].block[1][0]
                                            )}`"
                                          >
                                          </span><span>{{ scope.row.block[0] }}</span>  
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <el-table-column
                      :label="trans('tr.r_feed_loop')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="r_con"
                            label=""
                            width="150"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `r_con`)" :placement="isPlacement(scope.$index, `r_con`)">
                                <div v-if="edit" :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`r_con`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`r_con`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].r_con[1][0]
                                            )}`"
                                          >
                                          </span>
                                          <el-input
                                            class="input_edit"
                                            @change="editrow(scope.row,scope.$index)"
                                            v-model="scope.row.r_con[0]"
                                            :disabled="!edit">
                                          </el-input>
                                          
                                </div>
                                <div v-else :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`r_con`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`r_con`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].r_con[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.r_con[0] != null">
                                          {{_.round(scope.row.r_con[0], 1)}}
                                    </span>

                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <el-table-column
                      :label="trans('tr.outer_diameter_producing_casing')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="cas_OD"
                            label=""
                            width="180"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `cas_OD`)" :placement="isPlacement(scope.$index, `cas_OD`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`cas_OD`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`cas_OD`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].cas_OD[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.cas_OD[0] != null">
                                              {{_.round(scope.row.cas_OD[0], 1)}}
                                            </span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.inner_diameter_producing_casing')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="cas_ID"
                            label=""
                            width="180"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <el-table-column
                      :label="trans('tr.outer_diameter_nkt')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="tub_OD"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `tub_OD`)" :placement="isPlacement(scope.$index, `tub_OD`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`tub_OD`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`tub_OD`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].tub_OD[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.tub_OD[0] != null">{{_.round(scope.row.tub_OD[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.inner_diameter_nkt')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="tub_ID"
                            label=""
                            width="200"
                            sortable
                            >
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.choke_diameter')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="choke_d"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `choke_d`)" :placement="isPlacement(scope.$index, `choke_d`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`choke_d`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`choke_d`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].choke_d[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.choke_d[0] != null">{{_.round(scope.row.choke_d[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.h_water_permeability')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="h_up_perf_md"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `h_up_perf_md`)" :placement="isPlacement(scope.$index, `h_up_perf_md`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`h_up_perf_md`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`h_up_perf_md`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].h_up_perf_md[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.h_up_perf_md[0] != null">{{_.round(scope.row.h_up_perf_md[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.h_water_permeability_extension')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="h_up_perf_ext"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `h_up_perf_ext`)" :placement="isPlacement(scope.$index, `h_up_perf_ext`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`h_up_perf_ext`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`h_up_perf_ext`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].h_up_perf_ext[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.h_up_perf_ext[0] != null">{{_.round(scope.row.h_up_perf_ext[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.operation_method')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="exp_meth"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `exp_meth`)" :placement="isPlacement(scope.$index, `exp_meth`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`exp_meth`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`exp_meth`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].exp_meth[1][0]
                                            )}`"
                                          >
                                          </span><span>{{ scope.row.exp_meth[0] }}</span>  
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.pump_type')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="pump_type"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `pump_type`)" :placement="isPlacement(scope.$index, `pump_type`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`pump_type`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`pump_type`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].pump_type[1][0]
                                            )}`"
                                          >
                                          </span><span>{{ scope.row.pump_type[0] }}</span>  
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <el-table-column
                      :label="trans('tr.sk_type')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="type_sr"
                            label=""
                            width="200"
                            sortable
                            >
                            
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.swing_number')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="spm"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `spm`)" :placement="isPlacement(scope.$index, `spm`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`spm`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`spm`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].spm[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.spm[0] != null">{{_.round(scope.row.spm[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.stroke_length')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="stroke_len"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `stroke_len`)" :placement="isPlacement(scope.$index, `stroke_len`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`stroke_len`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`stroke_len`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].stroke_len[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.stroke_len[0] != null">{{_.round(scope.row.stroke_len[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.q_theor')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="q_theor"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `q_theor`)" :placement="isPlacement(scope.$index, `q_theor`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`q_theor`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`q_theor`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].q_theor[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.q_theor[0] != null">{{_.round(scope.row.q_theor[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.pump_frequency_or_speed')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="freq"
                            label=""
                            width="400"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `freq`)" :placement="isPlacement(scope.$index, `freq`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`freq`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`freq`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].freq[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.freq[0] != null">{{_.round(scope.row.freq[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <el-table-column
                      :label="trans('tr.h_pump_set')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="h_pump_set"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `h_pump_set`)" :placement="isPlacement(scope.$index, `h_pump_set`)">
                                <div v-if="edit" :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`h_pump_set`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`h_pump_set`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].h_pump_set[1][0]
                                            )}`"
                                          >
                                            </span>
                                            <el-input
                                            class="input_edit"
                                            @change="editrow(scope.row,scope.$index)"
                                            v-model="scope.row.h_pump_set[0]"
                                            :disabled="!edit">
                                          </el-input>
                                </div>
                                <div v-else :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`h_pump_set`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`h_pump_set`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].h_pump_set[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.h_pump_set[0] != null">{{_.round(scope.row.h_pump_set[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.p_buffer')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="whp"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `whp`)" :placement="isPlacement(scope.$index, `whp`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`whp`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`whp`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].whp[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.whp[0] != null">{{_.round(scope.row.whp[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.p_linear')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="line_p"
                            label=""
                            width="200"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `line_p`)" :placement="isPlacement(scope.$index, `line_p`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`line_p`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`line_p`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].line_p[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.line_p[0] != null">{{_.round(scope.row.line_p[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.p_layer')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="p_res"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `p_res`)" :placement="isPlacement(scope.$index, `p_res`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`p_res`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`p_res`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].p_res[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.p_res[0] != null">{{_.round(scope.row.p_res[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.h_dynamic')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="h_dyn"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `h_dyn`)" :placement="isPlacement(scope.$index, `h_dyn`)">
                                <div v-if="edit" :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`h_dyn`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`h_dyn`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].h_dyn[1][0]
                                            )}`"
                                          >
                                            </span>
                                            <el-input
                                            class="input_edit"
                                            @change="editrow(scope.row,scope.$index)"
                                            v-model="scope.row.h_dyn[0]"
                                            :disabled="!edit">
                                          </el-input>
                                </div>
                                <div v-else :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`h_dyn`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`h_dyn`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].h_dyn[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.h_dyn[0] != null">{{_.round(scope.row.h_dyn[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.annular_pressure')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="p_annular"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `p_annular`)" :placement="isPlacement(scope.$index, `p_annular`)">
                                <div v-if="edit" :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`p_annular`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`p_annular`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].p_annular[1][0]
                                            )}`"
                                          >
                                            </span>
                                            <el-input
                                            class="input_edit"
                                            @change="editrow(scope.row,scope.$index)"
                                            v-model="scope.row.p_annular[0]"
                                            :disabled="!edit">
                                          </el-input>

                                </div>
                                <div v-else :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`p_annular`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`p_annular`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].p_annular[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.p_annular[0] != null">{{_.round(scope.row.p_annular[0], 1)}}</span>
                                </div>
                                   
                              </el-tooltip> 
                            </template>
                          </el-table-column>

                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column
                      :label="trans('tr.p_intake')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="p_intake"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `p_intake`)" :placement="isPlacement(scope.$index, `p_intake`)">
                                <div v-if="edit" :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`p_intake`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`p_intake`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].p_intake[1][0]
                                            )}`"
                                          >
                                            </span>
                                            <el-input
                                            class="input_edit"
                                            @change="editrow(scope.row,scope.$index)"
                                            v-model="scope.row.p_intake[0]"
                                            :disabled="!edit">
                                          </el-input>

                                </div> 
                                <div v-else :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`p_intake`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`p_intake`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].p_intake[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.p_intake[0] != null">{{_.round(scope.row.p_intake[0], 1)}}</span>
                                </div>  
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>


                    <!-- Данные за предыдущий месяц -->
                    <el-table-column
                      :label="trans('tr.previous_month_data')"
                      >
                      <el-table-column label="" >
                        <el-table-column
                        :label="trans('tr.bottomhole_pressure')"
                        >

                          <el-table-column
                            prop="bhp_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <span>
                                  {{ Math.round(scope.row.bhp_prev_m * 10) / 10 }}
                              </span>
                            </template>
               
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.q_liquid')"
                        >
                          <el-table-column
                            prop="q_l_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <span>
                                  {{ Math.round(scope.row.q_l_prev_m * 10) / 10 }}
                              </span>
                            </template>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.water_cut')"
                        >
                          <el-table-column
                            prop="wct_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <span>
                                  {{ Math.round(scope.row.wct_prev_m * 10) / 10 }}
                              </span>
                            </template>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.h_dyn')"
                        >
                          <el-table-column
                            prop="h_dyn_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <span>
                                  {{ Math.round(scope.row.h_dyn_prev_m * 10) / 10 }}
                              </span>
                            </template>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.k_prod')"
                        >
                          <el-table-column
                            prop="pi_prev_m"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <span>
                                  {{ Math.round(scope.row.pi_prev_m * 10) / 10 }}
                              </span>
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <!-- Фактический режим -->
                    <el-table-column
                      :label="trans('tr.actual_mode')"
                      >
                      <el-table-column label="" >
                        <el-table-column
                        :label="trans('tr.bottomhole_pressure')"
                        >
                          <el-table-column
                            prop="bhp"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `bhp`)" :placement="isPlacement(scope.$index, `bhp`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`bhp`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`bhp`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].bhp[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.bhp[0] != null">{{_.round(scope.row.bhp[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.q_oil')"
                        >
                          <el-table-column
                            prop="q_o"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `q_o`)" :placement="isPlacement(scope.$index, `q_o`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`q_o`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`q_o`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].q_o[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.q_o[0] != null">{{_.round(scope.row.q_o[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.q_liquid')"
                        >
                          <el-table-column
                            prop="q_l"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `q_l`)" :placement="isPlacement(scope.$index, `q_l`)">
                                <div v-if="edit" :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`q_l`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`q_l`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].q_l[1][0]
                                            )}`"
                                          >
                                          </span>
                                          <el-input
                                            class="input_edit"
                                            @change="editrow(scope.row,scope.$index)"
                                            v-model="scope.row.q_l[0]"
                                            :disabled="!edit">
                                          </el-input>
                                          
                                </div>
                                <div v-else :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`q_l`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`q_l`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].q_l[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.q_l[0] != null">{{_.round(scope.row.q_l[0], 1)}}</span>
                                </div>
                                    
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.water_cut')"
                        >
                          <el-table-column
                            prop="wct"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `wct`)" :placement="isPlacement(scope.$index, `wct`)">
                                <div v-if="edit" :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`wct`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`wct`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].wct[1][0]
                                            )}`"
                                          >
                                            </span>
                                            <el-input
                                            class="input_edit"
                                            @change="editrow(scope.row,scope.$index)"
                                            v-model="scope.row.wct[0]"
                                            :disabled="!edit">
                                          </el-input>
                                </div> 
                                <div v-else :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`wct`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`wct`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].wct[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.wct[0] != null">{{_.round(scope.row.wct[0], 1)}}</span>
                                </div>
                                  
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column
                        :label="trans('tr.gas_factor')"
                        >
                          <el-table-column
                            prop="gor"
                            label=""
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `gor`)" :placement="isPlacement(scope.$index, `gor`)">
                                <div v-if="edit" :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`gor`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`gor`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].gor[1][0]
                                            )}`"
                                          >
                                            </span>
                                            <el-input
                                            class="input_edit"
                                            @change="editrow(scope.row,scope.$index)"
                                            v-model="scope.row.gor[0]"
                                            :disabled="!edit">
                                          </el-input>
                                </div>
                                <div v-else :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`gor`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`gor`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].gor[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.gor[0] != null">{{_.round(scope.row.gor[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
          
                    <el-table-column
                      :label="trans('tr.state_at_the_end_of_the_month')"
                      >
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column 
                            prop="well_status_last_day"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `well_status_last_day`)" :placement="isPlacement(scope.$index, `well_status_last_day`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`well_status_last_day`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`well_status_last_day`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].well_status_last_day[1][0]
                                            )}`"
                                          >
                                          </span><span>{{ scope.row.well_status_last_day[0] }}</span>  
                                </div>   
                              </el-tooltip> 
                            </template>

                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <el-table-column :label="trans('tr.p_saturation')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="P_bubble_point"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `P_bubble_point`)" :placement="isPlacement(scope.$index, `P_bubble_point`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`P_bubble_point`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`P_bubble_point`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].P_bubble_point[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.P_bubble_point[0] != null">{{_.round(scope.row.P_bubble_point[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.t_layer')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="t_res"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `t_res`)" :placement="isPlacement(scope.$index, `t_res`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`t_res`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`t_res`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].t_res[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.t_res[0] != null">{{_.round(scope.row.t_res[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.t_mouth')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="wht"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                                <span v-if="scope.row.wht != null">{{Math.round(scope.row.wht * 10) / 10}}</span>
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>

                    <!-- ГРП -->
                    <el-table-column :label="trans('tr.grp')">
                      <el-table-column label="">
                        <el-table-column :label="trans('tr.skin')">
                          <el-table-column
                            prop="grp_skin"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `grp_skin`)" :placement="isPlacement(scope.$index, `grp_skin`)">
                                <div v-if="edit" :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`grp_skin`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`grp_skin`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].grp_skin[1][0]
                                            )}`"
                                          >
                                            </span>
                                            <el-input
                                            class="input_edit"
                                            @change="editrow(scope.row,scope.$index)"
                                            v-model="scope.row.grp_skin[0]"
                                            :disabled="!edit">
                                          </el-input>

                                </div> 
                                <div v-else :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`grp_skin`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`grp_skin`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].grp_skin[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.grp_skin[0] != null">{{_.round(scope.row.grp_skin[0], 1)}}</span>
                                </div>  
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column :label="trans('tr.jd_fact')">
                          <el-table-column
                            prop="grp_jd"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                                <span v-if="scope.row.grp_jd != null">{{_.round(scope.row.grp_skin[0], 2)}}</span>
                            </template>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column :label="trans('tr.grp_date')">
                          <el-table-column
                            prop="grp_date"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `grp_date`)" :placement="isPlacement(scope.$index, `grp_date`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`grp_date`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`grp_date`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].grp_date[1][0]
                                            )}`"
                                          >
                                          </span><span>{{ scope.row.grp_date[0] }}</span>  
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                        <el-table-column :label="trans('tr.firm')">
                          <el-table-column
                            prop="grp_contractor"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `grp_contractor`)" :placement="isPlacement(scope.$index, `grp_contractor`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`grp_contractor`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`grp_contractor`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].grp_contractor[1][0]
                                            )}`"
                                          >
                                          </span><span>{{ scope.row.grp_contractor[0] }}</span>  
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.oil_viscosity_in_reservoir_conditions')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="visc_oil_rc"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `visc_oil_rc`)" :placement="isPlacement(scope.$index, `visc_oil_rc`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`visc_oil_rc`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`visc_oil_rc`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].visc_oil_rc[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.visc_oil_rc[0] != null">{{_.round(scope.row.visc_oil_rc[0], 2)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.water_viscosity_at_reservoir_conditions')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="visc_wat_rc"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `visc_wat_rc`)" :placement="isPlacement(scope.$index, `visc_wat_rc`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`visc_wat_rc`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`visc_wat_rc`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].visc_wat_rc[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.visc_wat_rc[0] != null">{{_.round(scope.row.visc_wat_rc[0], 2)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.liquid_viscosity')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="visc_liq_rc"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `visc_liq_rc`)" :placement="isPlacement(scope.$index, `visc_liq_rc`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`visc_liq_rc`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`visc_liq_rc`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].visc_liq_rc[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.visc_liq_rc[0] != null">{{_.round(scope.row.visc_liq_rc[0], 2)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.b_oil')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="bo"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `bo`)" :placement="isPlacement(scope.$index, `bo`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`bo`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`bo`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].bo[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.bo[0] != null">{{_.round(scope.row.bo[0], 2)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.oil_density')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="dens_oil"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `dens_oil`)" :placement="isPlacement(scope.$index, `dens_oil`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`dens_oil`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`dens_oil`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].dens_oil[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.dens_oil[0] != null">{{_.round(scope.row.dens_oil[0], 2)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.water_density')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="dens_liq"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `dens_liq`)" :placement="isPlacement(scope.$index, `dens_liq`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`dens_liq`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`dens_liq`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].dens_liq[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.dens_liq[0] != null">{{_.round(scope.row.dens_liq[0], 2)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.h_up_perf_md')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="h_perf"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                                <span v-if="scope.row.h_perf != null">{{_.round(scope.row.h_perf[0], 1)}}</span>
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column label="k">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="k"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `k`)" :placement="isPlacement(scope.$index, `k`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`k`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`k`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].k[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.k[0] != null">{{_.round(scope.row.k[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column label="KH">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="kh"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `kh`)" :placement="isPlacement(scope.$index, `kh`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`kh`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`kh`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].kh[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.kh[0] != null">{{_.round(scope.row.kh[0], 1)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    <el-table-column :label="trans('tr.pi')">
                      <el-table-column label="" prop="fake" >
                        <el-table-column label="" >
                          <el-table-column
                            prop="pi"
                            width="130"
                            sortable
                            >
                            <template slot-scope="scope">
                              <el-tooltip class="item" effect="dark"  v-bind:content="haveTooltip(scope.$index, `pi`)" :placement="isPlacement(scope.$index, `pi`)">
                                <div :class="{'cell-with-comment': isCellWithCommentClass(scope.$index,`pi`)}" >
                                          <span
                                            :class="{
                                              'circle-err': isCircleErrClass(scope.$index,`pi`)}"
                                            :style="`background :${getColor(
                                              wells[scope.$index].pi[1][0]
                                            )}`"
                                          >
                                            </span><span v-if="scope.row.pi[0] != null">{{_.round(scope.row.pi[0], 2)}}</span>
                                </div>   
                              </el-tooltip> 
                            </template>
                          </el-table-column>
                        </el-table-column>
                      </el-table-column>
                    </el-table-column>
                    
                  <el-pagination
                    round
                    :page-count="pageCount"
                    @current-change="pageChangeHandler"
                    layout="prev, pager, next"
                    :class="'pagination'">
                  </el-pagination>
          </div>
        </div>
</template>
<script>
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import { isString } from "lodash";
import paginationMixin from "~/mixins/pagination.mixin.js";

Vue.use(ElementUI); 
export default {
    name: "TechModeSmall",
    mixins: [paginationMixin],
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


.el-table__body-wrapper {}

.el-table__body-wrapper td {
    height: auto;
    margin: 0;
    padding: 0;
    background: transparent;
}

.el-table__body-wrapper td .cell {
    line-height: 1.3;
    padding: 12px 0;
    margin: 0;
    height: auto;
    width: 100%;
    background: transparent;
}

.el-table__body-wrapper tr:nth-child(even) {
    background: #202b6b!important;
}

.el-table__body-wrapper tr:hover {
    background: #4c5cb5!important;
}

.el-table__body-wrapper tr:hover td {
    background: #4c5cb5!important;
}

.el-table__header-wrapper th {
    padding: 0;
    height: auto;
}

.el-table__header-wrapper th div {
    background: rgb(51, 57, 117);
    height: auto;
    padding: 20px 0;
    color: #fff;
    font-size: 14px;
}
.el-table thead.is-group th {
    background: rgb(51, 57, 117);
}
.el-table th, .el-table tr {
    background-color: #454D7D;
    color: #fff
}

.no_border.no_border  {
  border-bottom: none;
  
}
.cell-comment {
    display: none;
    width: auto;
    position:absolute;
    z-index:3060;
    text-align: Left;
    opacity: 0.4;
    transition: opacity 2s;
    border-radius: 6px;
    background-color: #555;
    padding:3px;
    bottom: 31px;
    margin-left: 18px;
}
.circle-err {
    display: block;
    height: 10px;
    border-radius: 50px;
    width: 10px;
    margin-right: 20px;
    background: rgb(255, 0, 0);
    margin-left: 18px;
}
.cell-with-comment:hover .cell-comment {
    display: flex;
    opacity: 1;
}
.pagination {
    justify-content: center;
    background: #fff;
}
</style>