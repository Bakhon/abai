<template>
  <div class="gno-page-wrapper">
    <div>
      <div class="row gno-page-container">
        <div class="second-column col-lg-3 order-md-2">
          <div class="col-md-12 second-column-container">
            <!-- Выбор скважины start -->
            <div class="tables-string-gno col-12">
              <div class="choosing-well-title col-12">{{trans('pgno.choose_well')}}</div>
              <div class="choosing-well-data  col-7">{{trans('pgno.mestorozhdenie')}}</div>
              <div class="choosing-well-data table-border-gno cell4-gno-second  col-5">
                <select class="select-gno2" v-model="field">
                  <option v-for="org in this.orgs" :value="org.short_name" :key="org.id">
                  {{org.full_name}}
                  </option>
                </select>
              </div>
              <div class="choosing-well-data table-border-gno-top  col-7">
                {{trans('pgno.well')}} №
              </div>
              <div class="choosing-well-data table-border-gno table-border-gno-top cell4-gno-second  col-5">
                <input v-model="wellNumber" onfocus="this.value=''" type="text"  @change="getWellNumber(wellNumber)" class="square2" />
              </div>
              <div class="choosing-well-data table-border-gno-top  col-7">
                {{trans('pgno.new_well')}}
                <input :checked="isYoungAge" v-model="isYoungAge" class="checkbox0" type="checkbox" />
              </div>
              <div class="choosing-well-data table-border-gno table-border-gno-top cell4-gno-second  col-5">
                {{trans('pgno.grp')}}
                <input class="checkbox0" v-model="hasGrp" :disabled="!isYoungAge" type="checkbox" />
              </div>

              <div class="choosing-well-data table-border-gno-top  col-7">{{trans('pgno.horizon')}}</div>
              <div class="choosing-well-data table-border-gno table-border-gno-top cell4-gno-second  col-5">
                {{ horizon }}
              </div>

              <div class="choosing-well-data table-border-gno-top  col-7">
                {{trans('pgno.method_of_operation')}}
              </div>
              <div class="choosing-well-data table-border-gno table-border-gno-top cell4-gno-second  col-5">

                {{ expMeth }}

              </div>

              <div class="choosing-well-data table-border-gno-top  col-7">
                {{ tseh }}
              </div>
              <div class="choosing-well-data table-border-gno-top cell4-gno-second  col-5">
                {{ gu }}
              </div>

              <div class="choosing-well-data col-7">
                {{ ngdu }}
              </div>
              <div class="choosing-well-data cell4-gno-second  col-5" >
                <div>
                  {{ao}}
                </div>
              </div>
            </div>
            <!-- Выбор скважины end -->

            <!-- Конструкция start-->
            <div class="tables-string-gno1-1">
              <div class="construction no-gutter col-12"><b>{{trans('pgno.construction')}}</b></div>
              <div class="construction-data no-gutter col-7">{{trans('pgno.naruznii_diametr_ex_col')}}</div>
              <div class="construction-data table-border-gno cell4-gno-second no-gutter col-5">
                {{ casOD }} {{trans('measurements.mm')}}
              </div>

              <div class="construction-data table-border-gno-top no-gutter col-7">
                {{trans('pgno.vnutrenii_diametr_ex_col')}}
              </div>
              <div class="construction-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                {{ casID }} {{trans('measurements.mm')}}
              </div>

              <div class="construction-data table-border-gno-top no-gutter col-7">
                {{trans('pgno.glubina_perf')}}
              </div>
              <div class="construction-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                {{ hPerf }} {{trans('measurements.m')}}
              </div>

              <div class="construction-data table-border-gno-top no-gutter col-7">
                {{trans('pgno.udlinenie_perf')}}
              </div>
              <div class="construction-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                {{ udl }} {{trans('measurements.m')}}
              </div>

              <div class="construction-data table-border-gno-top no-gutter col-7">
                {{trans('pgno.tekushii_zaboi')}}
              </div>
              <div class="construction-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                {{ curr }} {{trans('measurements.m')}}
              </div>
            </div>
            <!-- Конструкция end -->

            <!-- Кнопка инклонометрии start -->
            <div class="inclinom-button" @click="InclMenu()">{{trans('pgno.inclinometria')}}</div>
            <!-- Кнопка инклонометрии end-->

            <div class="spoiler"
                 :class="{ 'opened': activeRightTabName === 'devices' }">
              <input class="checkbox-devices" 
                type="checkbox"
                tabindex="-1"
                :checked="activeRightTabName === 'devices'"
                @change="setActiveRightTabName($event, 'devices')"/>
              <div class="right-side-box">
                <div class="select-well no-gutter col-12">
                  <div class="devices-title"><b>{{trans('pgno.devices')}}</b></div>
                </div>
                <span class="closer">
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M11.8083 6.4147L11.4156 6.80558C11.2917 6.92697 11.1271 6.99486 10.951 6.99486C10.775 6.99486 10.6104 6.92697 10.4864 6.80558L6.003 2.37722L1.51331 6.81073C1.38935 6.93211 1.22477 7 1.04872 7C0.873717 7 0.708088 6.93211 0.585169 6.81073L0.19141 6.4219C-0.0638035 6.16885 -0.0638035 5.75738 0.19141 5.50536L5.53632 0.207788C5.66028 0.0853782 5.82487 0 6.00195 0H6.00404C6.18008 0 6.34467 0.0853782 6.46863 0.207788L11.8083 5.49096C11.9323 5.61234 12 5.78001 12 5.95386C12 6.1277 11.9323 6.29229 11.8083 6.4147Z"
                      fill="#FEFEFE" />
                  </svg>
                </span>
                <span class="open">
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M11.8083 0.585305L11.4156 0.194416C11.2917 0.0730345 11.1271 0.00514328 10.951 0.00514328C10.775 0.00514328 10.6104 0.0730345 10.4864 0.194416L6.003 4.62278L1.51331 0.189273C1.38935 0.0678913 1.22477 0 1.04872 0C0.873717 0 0.708088 0.0678913 0.585169 0.189273L0.19141 0.578104C-0.0638035 0.831154 -0.0638035 1.24262 0.19141 1.49464L5.53632 6.79221C5.66028 6.91462 5.82487 7 6.00195 7H6.00404C6.18008 7 6.34467 6.91462 6.46863 6.79221L11.8083 1.50904C11.9323 1.38766 12 1.21999 12 1.04614C12 0.8723 11.9323 0.707715 11.8083 0.585305Z"
                      fill="#FEFEFE" />
                  </svg>
                </span>

                <div class="right-block-details" v-show="activeRightTabName === 'devices'">
                  <div class="devices-data no-gutter col-7">
                    {{trans('pgno.stanok_kachalka')}}
                  </div>
                  <div class="devices-data table-border-gno cell4-gno-second no-gutter col-5">
                    {{ sk }}
                  </div>

                  <div class="hide-block"  v-show="!hasStrokeLength">
                    <div class="devices-data table-border-gno-top no-gutter col-7">
                    {{trans('pgno.dlina_hoda')}}
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{strokeLenDev}} {{trans('measurements.m')}}
                  </div>
                  </div>

                  <div v-if="expChoose">
                    <div v-if="expChoose ? 'ШГН' : 'ЭЦН' && 'УЭЦН'"></div>
                    <div class="devices-data table-border-gno-top no-gutter col-7">
                    {{ freq }}
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{spmDev}} 
                  </div>

                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    {{ dNasosa }}
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ pumpType }}
                  </div>
                  </div>
                  
                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    {{trans('pgno.h_spuska')}}
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ hPumpSet }} {{trans('measurements.m')}}
                  </div>

                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    {{trans('pgno.naruzhnii_nkt')}}
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ tubOD }} {{trans('measurements.mm')}}
                  </div>
                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    {{trans('pgno.vnutrenii_nkt')}}
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ tubID }} {{trans('measurements.mm')}}
                  </div>
                  <div class="devices-data table-border-gno-top no-gutter col-7">
                    {{trans('pgno.data_zapuska')}}
                  </div>
                  <div class="devices-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ stopDate }}
                  </div>
                  <div class="prs-button" @click="onPrsButtonClick()">{{trans('pgno.istoria_krs_prs')}}</div>
                </div>
              </div>
            </div>

            <div class="spoiler"
                 :class="{ 'opened': activeRightTabName === 'pvt' }">
              <input class="checkbox-devices"
                     type="checkbox"
                     tabindex="-1"
                     :checked="activeRightTabName === 'pvt'"
                     @change="setActiveRightTabName($event, 'pvt')"/>
              <div class="right-side-box">
                <div class="select-well no-gutter col-12">
                  <div class="pvt-title">{{trans('pgno.pvt')}}</div>
                </div>
                <span class="closer">
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M11.8083 6.4147L11.4156 6.80558C11.2917 6.92697 11.1271 6.99486 10.951 6.99486C10.775 6.99486 10.6104 6.92697 10.4864 6.80558L6.003 2.37722L1.51331 6.81073C1.38935 6.93211 1.22477 7 1.04872 7C0.873717 7 0.708088 6.93211 0.585169 6.81073L0.19141 6.4219C-0.0638035 6.16885 -0.0638035 5.75738 0.19141 5.50536L5.53632 0.207788C5.66028 0.0853782 5.82487 0 6.00195 0H6.00404C6.18008 0 6.34467 0.0853782 6.46863 0.207788L11.8083 5.49096C11.9323 5.61234 12 5.78001 12 5.95386C12 6.1277 11.9323 6.29229 11.8083 6.4147Z"
                      fill="#FEFEFE" />
                  </svg>
                </span>

                <span class="open">
                  <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M11.8083 0.585305L11.4156 0.194416C11.2917 0.0730345 11.1271 0.00514328 10.951 0.00514328C10.775 0.00514328 10.6104 0.0730345 10.4864 0.194416L6.003 4.62278L1.51331 0.189273C1.38935 0.0678913 1.22477 0 1.04872 0C0.873717 0 0.708088 0.0678913 0.585169 0.189273L0.19141 0.578104C-0.0638035 0.831154 -0.0638035 1.24262 0.19141 1.49464L5.53632 6.79221C5.66028 6.91462 5.82487 7 6.00195 7H6.00404C6.18008 7 6.34467 6.91462 6.46863 6.79221L11.8083 1.50904C11.9323 1.38766 12 1.21999 12 1.04614C12 0.8723 11.9323 0.707715 11.8083 0.585305Z"
                      fill="#FEFEFE" />
                  </svg>
                </span>

                <div class="right-block-details" v-show="activeRightTabName === 'pvt'">
                  <div class="pvt-data no-gutter col-7">{{trans('pgno.p_nas')}}</div>
                  <div class="pvt-data table-border-gno cell4-gno-second no-gutter col-5">
                    {{ PBubblePoint }} {{trans('measurements.atm')}}
                  </div>

                  <div class="pvt-data table-border-gno-top no-gutter col-7">{{trans('pgno.gf')}}</div>
                  <div class="pvt-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ gor }} {{trans('measurements.m3/t')}}
                  </div>

                  <div class="pvt-data table-border-gno-top no-gutter col-7">{{trans('pgno.t_pl')}}</div>
                  <div class="pvt-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ tRes }} {{trans('measurements.celsius')}}
                  </div>

                  <div class="pvt-data table-border-gno-top no-gutter col-7">
                    {{trans('pgno.vyazkost_nefti')}}
                  </div>
                  <div class="pvt-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ viscOilRc }} {{trans('measurements.spz')}}
                  </div>

                  <div class="pvt-data table-border-gno-top no-gutter col-7">
                    {{trans('pgno.vyazkost_vody')}}
                  </div>
                  <div class="pvt-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ viscWaterRc }} {{trans('measurements.spz')}}
                  </div>

                  <div class="pvt-data table-border-gno-top no-gutter col-7">
                    {{trans('pgno.plotnost_nefti')}}
                  </div>
                  <div class="pvt-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ densOil }} {{trans('measurements.g/sm3')}}
                  </div>
                  <div class="pvt-data table-border-gno-top no-gutter col-7">
                    {{trans('pgno.plotnost_vody')}}
                  </div>
                  <div class="pvt-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ densWater }} {{trans('measurements.g/sm3')}}
                  </div>
                </div>
              </div>
            </div>

            <div class="spoiler"
                 :class="{ 'opened': activeRightTabName === 'technological-mode' || (windowWidth <= 1300 && windowWidth > 991) }">
              <input style="width: 845px; height: 45px;"
                     type="checkbox"
                     tabindex="-1"
                     :checked="activeRightTabName === 'technological-mode'"
                     @click="setActiveRightTabName($event, 'technological-mode')"/>
              <div class="right-side-box">
                <div class="select-well no-gutter col-12">

                  <div class="technological-mode-title">{{trans('pgno.technologicheskii_rezhim')}}</div>
                </div>

                <div class="right-block-details"
                  v-show="activeRightTabName === 'technological-mode' || (windowWidth <= 1300 && windowWidth > 991)">
                  <div class="tech-data no-gutter col-7">{{trans('pgno.q_zhidkosti')}}</div>
                  <div class="tech-data table-border-gno cell4-gno-second no-gutter col-5">
                    {{ qL }} {{trans('measurements.m3/day')}}
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">{{trans('pgno.q_nefti')}}</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ qO }} {{trans('measurements.t/d')}}
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">{{trans('pgno.obvodnenost')}}</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ wct }} {{trans('measurements.percent')}}
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">{{trans('pgno.p_zab')}}</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ bhp }} {{trans('measurements.atm')}}
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">{{trans('pgno.p_pl')}}</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ pRes }} {{trans('measurements.at')}}
                  </div>

                  <div class="tech-data table-border-gno-top no-gutter col-7">{{trans('pgno.h_dyn')}}</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ hDyn }} {{trans('measurements.m')}}
                  </div>
                  <div class="tech-data table-border-gno-top no-gutter col-7">{{trans('pgno.p_zat')}}</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ pAnnular }} {{trans('measurements.atm')}}
                  </div>
                  <div class="tech-data table-border-gno-top no-gutter col-7">{{trans('pgno.p_buf')}}</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ whp }} {{trans('measurements.atm')}}
                  </div>
                  <div class="tech-data table-border-gno-top no-gutter col-7">{{trans('pgno.p_lin')}}</div>
                  <div class="tech-data table-border-gno table-border-gno-top cell4-gno-second no-gutter col-5">
                    {{ lineP }} {{trans('measurements.atm')}}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="no-gutter col-lg-9 order-md-1 first-column container-fluid no-gutter">
          <div class="no-gutter col-md-12 first-column-curve-block">
            <div class="background">
              <modal class="modal-bign-wrapper" name="modalIncl" :draggable="false" :width="1300" :height="700"
                style="background: transparent;" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">{{trans('pgno.inclinometria')}}</div>

                    <button type="button" class="modal-bign-button" @click="closeInclModal()">
                      {{trans('pgno.zakrit')}}
                    </button>
                  </div>

                  <div class="Table" align="center" x:publishsource="Excel">
                    <inclinometria @update-hpump="setHpumpValueFromIncl($event)" :isButtonHpump="isButtonHpump" :wellNumber="wellNumber" :expChoose="expChoose" :wellIncl="wellIncl" :is-loading.sync="isLoading">
                    </inclinometria>
                  </div>
                </div>
              </modal>

               <modal class="modal-bign-wrapper" name="modalSeparation" :draggable="false" :width="1000" :height="500"
                style="background: transparent;" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title"></div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modalSeparation')">
                      {{trans('pgno.zakrit')}}
                    </button>
                  </div>

                  <div class="Table" align="center" x:publishsource="Excel">
                    <tabs></tabs>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper" name="modal-prs" :draggable="true" :width="1263" :height="612"
                style="background: transparent;" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">{{trans('pgno.istoria_remontov')}} {{wellNumber}}</div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modal-prs')">
                      {{trans('pgno.zakrit')}}
                    </button>
                  </div>

                  <div class="Table" align="center" x:publishsource="Excel">
                    <prs-crs :wellNumber="wellNumber" :wellIncl="wellIncl" :field="field" :is-loading.sync="isLoading"></prs-crs>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper" name="modalOldWell" :draggable="true" :width="1080" :height="450" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      {{trans('pgno.analis_potenciala')}}
                    </div>
                   
                <div class="download-button-excel">
                  <div class="dropdown">
                    <button class="download-curve-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M4.16699 11.1538V14.5C4.16699 14.7761 4.39085 15 4.66699 15H15.667C15.9431 15 16.167 14.7761 16.167 14.5V11.1538" stroke="white" stroke-linecap="round"/>
                      <path d="M10.1667 5V11.1539" stroke="white" stroke-linecap="round"/>
                      <path d="M7.5957 9.61572L10.1671 11.9234L12.7386 9.61572" stroke="white" stroke-linecap="round"/>
                      </svg>
                      {{trans('pgno.download')}}
                      <svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1.5 1L5.93356 4.94095C5.97145 4.97462 6.02855 4.97462 6.06644 4.94095L10.5 1" stroke="white" stroke-width="1.4" stroke-linecap="round"/>
                      </svg>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#" @click="takePhotoOldNewWell()">Photo</a>
                      <a class="dropdown-item" href="#" @click="downloadExcel()">MS Excel</a>
                    </div>
                  </div>
                </div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modalOldWell')">
                     {{trans('pgno.zakrit')}}
                    </button>
                  </div>

                  <div class="modal-old-well-content-container">
                    
                    <div class="modal-old-well-plotly-container">
                      <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
                    </div>

                    <div class="modal-analysis-menu">
                      <div class="form-check">
                        <input v-model="isAnalysisBoxValue1" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()"
                          type="checkbox" />
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">{{trans('pgno.ppl_equal_pnach')}}</label>
                      </div>
                      <div class="form-check">
                        <input v-model="isAnalysisBoxValue2" class="checkbox-modal-analysnauryzbekis-menu"
                          @change="postAnalysisOld()" type="checkbox" />
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">{{trans('pgno.hdin_equal_hdin_min')}}</label>
                      </div>
                      <div class="form-check">
                        <input v-model="isAnalysisBoxValue3" class="checkbox-modal-analysnauryzbekis-menu"
                          @change="postAnalysisOld()" type="checkbox" />
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">{{trans('pgno.p_zab_more_p_nas')}}</label>
                      </div>
                      <div class="form-check">
                        <input v-model="isAnalysisBoxValue4" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()"
                          type="checkbox" />
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">{{trans('pgno.q_liq_equal_q_liq')}}</label>
                      </div>
                      <div class="form-check">
                        <input v-model="isAnalysisBoxValue5" class="checkbox-modal-analysis-menu" @change="postAnalysisOld()"
                          type="checkbox" />
                        <label for="checkbox1" class="checkbox-modal-analysis-menu-label">{{trans('pgno.obv_obv_acma')}}</label>
                      </div>
                      <button type="button" class="old_well_button" @click="setGraphOld()">
                        {{trans('pgno.primenit_korrektirovki')}}
                      </button>
                    </div>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper" name="modalNewWell" :draggable="true" :width="1150" :height="450" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      {{trans('pgno.analis_potenciala')}}
                    </div>

                    <div class="download-button-excel">
                  <div class="dropdown">
                    <button class="download-curve-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M4.16699 11.1538V14.5C4.16699 14.7761 4.39085 15 4.66699 15H15.667C15.9431 15 16.167 14.7761 16.167 14.5V11.1538" stroke="white" stroke-linecap="round"/>
                      <path d="M10.1667 5V11.1539" stroke="white" stroke-linecap="round"/>
                      <path d="M7.5957 9.61572L10.1671 11.9234L12.7386 9.61572" stroke="white" stroke-linecap="round"/>
                      </svg>
                      {{trans('pgno.download')}}
                      <svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1.5 1L5.93356 4.94095C5.97145 4.97462 6.02855 4.97462 6.06644 4.94095L10.5 1" stroke="white" stroke-width="1.4" stroke-linecap="round"/>
                      </svg>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#" @click="takePhotoOldNewWell()">Photo</a>
                      <a class="dropdown-item" href="#" @click="downloadExcel()">MS Excel</a>
                    </div>
                  </div>
                </div>


                    <button type="button" class="modal-bign-button" @click="closeModal('modalNewWell')">
                      {{trans('pgno.zakrit')}}
                    </button>
                  </div>

                  <div class="modal-old-well-content-container">
                    <div class="modal-old-well-plotly-container">
                      <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
                    </div>
                    <div class="modal-analysis-menu">
                      <div class="form-check-new">
                        <input v-model="isAnalysisBoxValue6" class="new-checkbox-modal-analysis-menu"
                          @change="postAnalysisNew()" type="checkbox" />
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">{{trans('pgno.p_pl_p_izobar')}}</label>
                      </div>
                      <div class="form-check-new">
                        <input v-model="isAnalysisBoxValue7" class="new-checkbox-modal-analysis-menu"
                          @change="postAnalysisNew()" type="checkbox" />
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">{{trans('pgno.k_pr_k_po_okr')}}</label>
                      </div>
                      <div class="form-check-new">
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">{{trans('obv_po_okr')}}</label>
                        <label for="checkbox1">{{ wctOkr }}%</label>
                      </div>
                      <div class="form-check-new">
                        <input v-model="isAnalysisBoxValue8" class="new-checkbox-modal-analysis-menu"
                          @change="postAnalysisNew()" type="checkbox" />
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">{{trans('pgno.p_zab_more_p_nas')}}</label>
                      </div>
                      <div class="form-check-new">
                        <input v-model="hasGrp" class="new-checkbox-modal-analysis-menu" @change="postAnalysisNew()"
                          type="checkbox" />
                        <label for="checkbox1" class="new-checkbox-modal-analysis-menu-label">{{trans('pgno.s_grp')}}</label>
                      </div>
                      <div class="icon-for-table" @click="onOpenTable()">
                        <svg width="31" height="35" viewBox="0 0 31 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15.8654 0.56543C7.5741 0.56543 0.851562 7.05353 0.851562 15.0557C0.851562 19.2903 2.73469 23.1007 5.73609 25.7508L4.40373 34.6378L11.9882 29.0583C13.2252 29.3767 14.5247 29.5473 15.8654 29.5473C24.1566 29.5473 30.8807 23.0578 30.8807 15.0557C30.8807 7.05353 24.1566 0.56543 15.8654 0.56543ZM18.9912 23.0236C18.2183 23.3179 17.6029 23.541 17.1415 23.6956C16.6815 23.8503 16.1462 23.9274 15.5377 23.9274C14.6019 23.9274 13.8735 23.7069 13.3551 23.2663C12.8364 22.826 12.5786 22.2678 12.5786 21.5896C12.5786 21.3258 12.5974 21.0558 12.6359 20.7811C12.6751 20.506 12.7373 20.1971 12.8225 19.8499L13.7899 16.5522C13.8747 16.236 13.9487 15.9355 14.0071 15.6557C14.0655 15.3733 14.0937 15.1146 14.0937 14.8792C14.0937 14.4596 14.0033 14.1653 13.8242 13.9997C13.6421 13.8338 13.3005 13.753 12.7908 13.753C12.5416 13.753 12.2849 13.7887 12.0218 13.8633C11.7612 13.9408 11.535 14.0106 11.3495 14.0794L11.6047 13.0635C12.2377 12.8146 12.844 12.601 13.4223 12.4245C14.0006 12.2451 14.5473 12.1571 15.0623 12.1571C15.9913 12.1571 16.7079 12.3754 17.2128 12.8069C17.7149 13.2403 17.968 13.8032 17.968 14.4953C17.968 14.6387 17.9499 14.8915 17.916 15.2521C17.8813 15.6138 17.8163 15.9438 17.7225 16.2469L16.7603 19.5348C16.6815 19.7983 16.6115 20.1003 16.5481 20.4376C16.4855 20.7749 16.4553 21.0325 16.4553 21.2053C16.4553 21.642 16.5557 21.9403 16.7593 22.0986C16.9599 22.2569 17.3119 22.3366 17.8099 22.3366C18.0452 22.3366 18.3085 22.2959 18.6059 22.2176C18.9008 22.139 19.1145 22.0692 19.2491 22.0091L18.9912 23.0236ZM18.8208 9.6788C18.3722 10.0812 17.8318 10.2825 17.1999 10.2825C16.5696 10.2825 16.0256 10.0812 15.5732 9.6788C15.123 9.27673 14.8957 8.78698 14.8957 8.21535C14.8957 7.64517 15.1245 7.1543 15.5732 6.74823C16.0256 6.34106 16.5696 6.13876 17.1999 6.13876C17.8318 6.13876 18.3733 6.34106 18.8208 6.74823C19.2694 7.1543 19.4944 7.64517 19.4944 8.21535C19.4944 8.78843 19.2694 9.27673 18.8208 9.6788Z"
                            fill="#FEFEFE" /></svg>
                      </div>
                      <button type="button" class="old_well_button" @click="setGraphNew()">
                        {{trans('pgno.primenit_korrektirovki')}}
                      </button>
                    </div>
                  </div>
                </div>
              </modal>

              <modal class="" name="modalNearWells" :draggable="true" :width="1150" :height="450" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      {{trans('pgno.analis_potenciala')}}
                    </div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modalNearWells')">
                      {{trans('pgno.zakrit')}}
                    </button>

                  </div>
                  <div class="tablePgno no-gutter">
                    <perfect-scrollbar>
                      <table class="gno-table-with-header pgno" style="height: inherit;">
                        <thead>
                          <tr height="10" style="height: 10pt;">
                            <td>
                              № п/п
                            </td>
                            <td>
                              {{trans('pgno.number_of_well')}}
                            </td>
                            <td>
                              {{trans('pgno.distance')}}, {{trans('measurements.m')}}
                            </td>
                            <td>
                             {{trans('pgno.influence_factor')}}
                            </td>
                            <td>
                              {{trans('pgno.k_prod')}}, {{trans('measurements.m3/d/atm')}}
                            </td>
                            <td>
                              {{trans('pgno.kh')}}
                            </td>
                            <td>
                              {{trans('pgno.skin_factor')}}
                            </td>
                            <td>
                              {{trans('pgno.p_pl')}}, {{trans('measurements.atm')}}
                            </td>
                            <td>
                              {{trans('pgno.p_zab')}}, {{trans('measurements.atm')}}
                            </td>
                            <td>
                              {{trans('pgno.q_liq')}}, {{trans('measurements.m3/day')}}
                            </td>
                            <td>
                              {{trans('pgno.wc')}}, {{trans('measurements.percent')}}
                            </td>
                            <td>
                                {{trans('pgno.q_nefti')}}, {{trans('measurements.t/d')}}
                            </td>
                          </tr>
                        </thead>
                        <tbody>
                          <tr style="font-weight: bold;">
                            <td></td>
                            <td>{{this.wellOkr}}</td>
                            <td></td>
                            <td></td>
                            <td>{{this.piOkr}}</td>
                            <td>{{this.khOkr}}</td>
                            <td>{{this.skinOkr}}</td>
                            <td>{{this.presOkr}}</td>
                            <td></td>
                            <td></td>
                            <td>{{this.wctOkr}}</td>
                            <td></td>

                          </tr>
                          <tr v-for="(row, row_index) in this.nearWells" :key="row_index">
                            <td>{{row.index + 1}}</td>
                            <td>{{row.well}}</td>
                            <td>{{row.dist.toFixed(0)}}</td>
                            <td>{{row.k_v.toFixed(3)}}</td>
                            <td>{{row.pi.toFixed(2)}}</td>
                            <td>{{row.kh.toFixed(1)}}</td>
                            <td>{{row.tp_idn_skin.toFixed(1)}}</td>
                            <td>{{row.p_res.toFixed(0)}}</td>
                            <td>{{row.bhp.toFixed(0)}}</td>
                            <td>{{row.q_l.toFixed(0)}}</td>
                            <td>{{row.wct.toFixed(0)}}</td>
                            <td>{{row.q_o.toFixed(1)}}</td>
                          </tr>
                        </tbody>
                      </table>
                    </perfect-scrollbar>
                  </div>
                </div>
              </modal>


              <modal class="modal-bign-wrapper chart" name="modalExpAnalysis" :draggable="true" :width="1300" :height="550"
                :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      
                    </div> 

                    <button type="button" class="modal-bign-button" @click="closeModal('modalExpAnalysis')">
                      {{trans('pgno.zakrit')}}
                    </button>
                  </div>

                  <div>
                    <div class="nno-graph">
                      <economic :data="expAnalysisData"></economic>
                    </div>

                    <div class="nno-modal-button-wrapper">
                      <div class="nno-modal-buttons-container">
                        <div class="nno-icon" @click="onShowTable()">
                          <svg width="31" height="35" viewBox="0 0 31 35" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M15.131 0.290039C6.83973 0.290039 0.117188 6.77814 0.117188 14.7803C0.117188 19.0149 2.00031 22.8253 5.00172 25.4754L3.66936 34.3624L11.2537 28.7829C12.4906 29.1013 13.7903 29.2719 15.131 29.2719C23.4223 29.2719 30.1463 22.7824 30.1463 14.7803C30.1463 6.77814 23.4223 0.290039 15.131 0.290039ZM18.2567 22.7482C17.4838 23.0426 16.8686 23.2656 16.4071 23.4202C15.9471 23.5749 15.4118 23.6521 14.8033 23.6521C13.8676 23.6521 13.1392 23.4316 12.6208 22.9909C12.102 22.5506 11.8441 21.9925 11.8441 21.3142C11.8441 21.0504 11.863 20.7804 11.9015 20.5057C11.9407 20.2306 12.0029 19.9217 12.0881 19.5746L13.0555 16.2768C13.1403 15.9606 13.2141 15.6601 13.2726 15.3803C13.331 15.0979 13.3593 14.8392 13.3593 14.6038C13.3593 14.1843 13.2689 13.8899 13.0898 13.7244C12.9077 13.5584 12.5661 13.4776 12.0564 13.4776C11.8072 13.4776 11.5504 13.5133 11.2872 13.5879C11.0267 13.6654 10.8006 13.7352 10.6151 13.804L10.8703 12.7881C11.5033 12.5392 12.1096 12.3256 12.6879 12.1491C13.2663 11.9698 13.8129 11.8817 14.3279 11.8817C15.2569 11.8817 15.9736 12.1 16.4784 12.5316C16.9806 12.9649 17.2336 13.5278 17.2336 14.2199C17.2336 14.3633 17.2154 14.6162 17.1814 14.9768C17.1468 15.3385 17.082 15.6685 16.9881 15.9716L16.026 19.2594C15.9472 19.5229 15.8771 19.8249 15.8137 20.1622C15.7512 20.4995 15.721 20.7571 15.721 20.93C15.721 21.3666 15.8212 21.665 16.0248 21.8233C16.2254 21.9816 16.5775 22.0612 17.0756 22.0612C17.3108 22.0612 17.5739 22.0205 17.8714 21.9422C18.1662 21.8636 18.3801 21.7938 18.5147 21.7337L18.2567 22.7482ZM18.0863 9.40345C17.6376 9.80588 17.0974 10.0071 16.4656 10.0071C15.8352 10.0071 15.2912 9.80588 14.8388 9.40345C14.3887 9.00138 14.1612 8.51159 14.1612 7.93996C14.1612 7.36978 14.3902 6.87891 14.8388 6.47284C15.2912 6.06567 15.8352 5.86336 16.4656 5.86336C17.0974 5.86336 17.6388 6.06567 18.0863 6.47284C18.5349 6.87891 18.76 7.36978 18.76 7.93996C18.76 8.51304 18.5349 9.00138 18.0863 9.40345Z"
                              fill="#FEFEFE" />
                          </svg>
                        </div>

                        <button class="button-nno" @click="onCompareNpv()">
                          {{trans('pgno.sposob_exp_npv')}}
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper chart" :draggable="true" name="tablePGNO" :width="500" :height="550" :adaptive="true">
                <div class="modal-bign modal-bign-container no-padding">
                  <div class="modal-bign-header with-padding">
                    <div class="modal-bign-title">
                       {{trans('pgno.informacia')}}
                    </div>

                    <button type="button" class="modal-bign-button" @click="closeEconomicModal()">
                      {{trans('pgno.zakrit')}}
                    </button>
                  </div>

                  <div class="tablePgno no-gutter">
                    <perfect-scrollbar>
                      <table class="gno-table-with-header pgno">
                        <thead>
                          <tr height="60" style="height: 60pt;">
                            <td>
                              {{trans('pgno.naimenovanie')}}
                            </td>
                            <td>
                              {{trans('pgno.shgn_pokupka')}}
                            </td>
                            <td>
                              {{trans('pgno.ecn_arenda')}}
                            </td>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>{{trans('pgno.dop_dobycha_zhidkosti')}}</td>
                            <td>
                              {{ Math.round(expAnalysisData.npvTable1.liquid) }}
                            </td>
                            <td>
                              {{ Math.round(expAnalysisData.npvTable2.liquid) }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.dop_dobycha_nefti')}}</td>
                            <td>{{ Math.round(expAnalysisData.npvTable1.oil) }}</td>
                            <td>{{ Math.round(expAnalysisData.npvTable2.oil) }}</td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.kol_otrabot_dnei')}}</td>
                            <td>
                              {{ Math.round(expAnalysisData.npvTable1.workday) }}
                            </td>
                            <td>
                              {{ Math.round(expAnalysisData.npvTable2.workday) }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.kol_prs')}}</td>
                            <td>
                              {{
                              Math.round(expAnalysisData.npvTable1.kolichestvoPrs)
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(expAnalysisData.npvTable2.kolichestvoPrs)
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.srednee_prod_prs')}}</td>
                            <td>
                              {{ expAnalysisData.npvTable1.sredniiPrs }}
                            </td>
                            <td>
                              {{ expAnalysisData.npvTable2.sredniiPrs }}
                            </td>
                          </tr>
                          <tr>
                            <td>
                              {{trans('pgno.raspred_po_naprav_ndo')}}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiNdo 
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiNdo
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.opred_dohod_chasti')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiDohod / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiDohod / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.raschet_ndpi')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiNdpi / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiNdpi / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.raschet_rent_naloga')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiRent / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiRent / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.raschet_etp')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiEtp / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiEtp / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.raschet_rashodov_po_trans_nefti')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiTrans / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiTrans / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.zatraty_na_electro')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiZatrElectShgn /
                                1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiZatrElectEcn / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.zatraty_na_podgotovku')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiZatrPrep / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiZatrPrep / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.zatraty_na_prs')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiZatrPrs / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiZatrPrs / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.zatraty_za_sut_obsluzh')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiZatrSutObs / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiZatrSutObs / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.stoimost_arendy_oborudov')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiArenda / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiArenda / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.amortizacia')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiAmortizacia / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiAmortizacia / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.operacionaya_prybil')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiOperPryb / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiOperPryb / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.kpn')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiKpn / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiKpn / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.chistaya_prybil')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiChistPryb / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiChistPryb / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.kvl')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiKvl / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiKvl / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.svobodni_denezh_potok')}}</td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable1.godovoiSvobPot / 1000
                              )
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(
                                expAnalysisData.npvTable2.godovoiSvobPot / 1000
                              )
                            }}
                            </td>
                          </tr>
                          <tr>
                            <td>{{trans('pgno.npv')}}</td>
                            <td>
                              {{
                              Math.round(expAnalysisData.npvTable1.npv / 1000000)
                            }}
                            </td>
                            <td>
                              {{
                              Math.round(expAnalysisData.npvTable2.npv / 1000000)
                            }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </perfect-scrollbar>
                  </div>
                </div>
              </modal>

              <modal name="modalPGNO" :draggable="true" :width="1150" :height="400" :adaptive="true">
                <div class="modal-bign3"></div>
              </modal> 

              <modal name="paramSep" :draggable="true" :width="1150" :height="400" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      {{trans('pgno.analis_potenciala')}}
                    </div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modalNearWells')">
                      {{trans('pgno.zakrit')}}
                    </button>

                  </div>
                  <div class="tablePgno no-gutter">
                    
                  </div>
                </div>
              </modal>

              <div class="gno-line-chart"  v-if="isVisibleChart">
                <div class="download-button-excel-1">
                  <div class="dropdown">
                    <button class="download-curve-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M4.16699 11.1538V14.5C4.16699 14.7761 4.39085 15 4.66699 15H15.667C15.9431 15 16.167 14.7761 16.167 14.5V11.1538" stroke="white" stroke-linecap="round"/>
                      <path d="M10.1667 5V11.1539" stroke="white" stroke-linecap="round"/>
                      <path d="M7.5957 9.61572L10.1671 11.9234L12.7386 9.61572" stroke="white" stroke-linecap="round"/>
                      </svg>
                      {{trans('pgno.download')}}
                      <svg width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M1.5 1L5.93356 4.94095C5.97145 4.97462 6.02855 4.97462 6.06644 4.94095L10.5 1" stroke="white" stroke-width="1.4" stroke-linecap="round"/>
                      </svg>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#" @click="takePhoto()">Photo</a>
                      <a class="dropdown-item" href="#" @click="downloadExcel()">MS Excel</a>
                    </div>
                  </div>
                </div>
                <inflow-curve>
                </inflow-curve>
                
              </div>


              <div class="gno-shgn-wrapper" v-if="!isVisibleChart">
                <div class="gno-shgn-block-title">
                  {{trans('pgno.komponovka_shgn')}}
                </div>

                <div class="podbor-gno">
                  <div class="image-data col-3">
                    <div class="shgn-image-text image-text-1">{{trans('pgno.eks_kolonna')}} {{ this.casID }}{{trans('measurements.mm')}}</div>
                    <div class="shgn-image-text image-text-2">{{trans('pgno.nkt')}} {{ this.tubOD }}{{trans('measurements.mm')}}</div>
                    <div class="shgn-image-text image-text-3">{{trans('pgno.shtangi')}} {{ this.shgnS1D }}{{trans('measurements.mm')}} 0-{{ this.shgnS1L }}{{trans('measurements.m')}}</div>
                    <div class="shgn-image-text image-text-4">
                      {{trans('pgno.shtangi')}} {{ this.shgnS2D }}{{trans('measurements.mm')}} {{ this.shgnS1L }}-{{
                        this.shgnS1L * 1 + this.shgnS2L * 1
                      }}{{trans('measurements.m')}}
                    </div>
                    <div class="shgn-image-text image-text-5">
                      {{trans('pgno.shtangi')}} {{ this.shgnS1D }}{{trans('measurements.mm')}}
                      {{ this.shgnS1L * 1 + this.shgnS2L * 1 }}-{{
                        this.shgnS1L * 1 + this.shgnS2L * 1 + this.shgnTNL * 1
                      }}{{trans('measurements.m')}}
                    </div>
                    <div class="shgn-image-text image-text-6">{{trans('pgno.nasos')}} {{ this.shgnPumpType }}{{trans('measurements.mm')}}</div>
                    <div class="shgn-image-text image-text-7">
                      {{trans('pgno.interval_perf')}} <br> {{ this.hPerf }}-{{
                        this.hPerf * 1 + this.hPerfND * 1
                      }}{{trans('measurements.m')}}
                    </div>
                    <div class="shgn-image-text image-text-8">{{trans('pgno.tekushii_zaboi')}} {{ this.curr }}{{trans('measurements.m')}}</div>

                    <img class="podborgnoimg"
                         src="./images/shgn.png"
                         alt="podbor-gno"/>
                  </div>

                      

                  <div class="table-pgno-button gno-shgn-table-section col-9" >
                    
                    <div class="shgn-tables-wrapper">
                      <div class="table-pgno-one">
                        <table class="table-pgno shgn-table">
                          <thead>
                            <tr class="tr-pgno" height="10" style="height: 30pt;">
                              <td class="td-pgno" rowspan="1" no-gutter colspan="2">
                                {{trans('pgno.raschetnii_rezhim')}}
                              </td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="td-pgno" rowspan="1">{{trans('pgno.q_liq')}}</td>
                              <td class="td-pgno" rowspan="1">
                                {{ qlCelValue }}
                              </td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">{{trans('pgno.q_nefti')}}</td>
                              <td class="td-pgno" rowspan="1">{{ qOil }} {{trans('measurements.t/d')}}</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">{{trans('pgno.obvodnenost')}}</td>
                              <td class="td-pgno" rowspan="1">{{ wctInput }}</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">{{trans('pgno.p_zab')}}</td>
                              <td class="td-pgno" rowspan="1">
                                {{ bhpCelValue }}
                              </td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">{{trans('p_pr')}}</td>
                              <td class="td-pgno" rowspan="1">{{ piCelValue }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <div class="table-pgno-two">
                        <table class="table-pgno shgn-table">
                          <thead>
                            <tr class="tr-pgno" height="5px" style="height: 30pt;">
                              <td class="td-pgno" rowspan="1" no-gutter colspan="2">
                                {{trans('pgno.komponovka')}}
                              </td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="td-pgno" rowspan="1">Ø {{trans('pgno.nasosa')}}</td>
                              <td class="td-pgno" rowspan="1">
                                {{ shgnPumpType }} {{trans('measurements.mm')}}
                              </td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">{{trans('pgno.chislo_kachanii')}}</td>
                              <td class="td-pgno" rowspan="1">{{ shgnSPM }} {{trans('measurements.min-1')}}</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">{{trans('pgno.dlina_hoda')}}</td>
                              <td class="td-pgno" rowspan="1">{{ shgnLen }} {{trans('measurements.m')}}</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">{{trans('pgno.typ_sk')}}</td>
                              <td class="td-pgno" rowspan="1">{{ sk }}</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">Ø {{trans('pgno.nkt')}}</td>
                              <td class="td-pgno" rowspan="1">{{ shgnTubOD }} {{trans('measurements.mm')}}</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">{{trans('pgno.h_spuska')}}</td>
                              <td class="td-pgno" rowspan="1">{{ hPumpValue }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <div class="table-pgno-four">
                        <table class="table-pgno shgn-table">
                          <thead>
                            <tr class="tr-pgno" height="5px" style="height: 30pt;">
                              <td class="td-pgno" rowspan="1">
                                {{trans('pgno.shtangi')}}
                              </td>
                              <td class="td-pgno" rowspan="1">
                                Ø, {{trans('measurements.mm')}}
                              </td>

                              <td class="td-pgno" rowspan="1">
                                {{trans('pgno.dlina')}}, {{trans('measurements.m')}}
                              </td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="td-pgno" rowspan="1">{{trans('pgno.sekcia')}} 1</td>
                              <td class="td-pgno" rowspan="1">{{ shgnS1D }}</td>
                              <td class="td-pgno" rowspan="1">{{ shgnS1L }}</td>
                            </tr>
                            <tr class="tr-pgno">
                              <td class="td-pgno" rowspan="1">{{trans('pgno.sekcia')}} 2</td>
                              <td class="td-pgno" rowspan="1">{{ shgnS2D }}</td>
                              <td class="td-pgno" rowspan="1">{{ shgnS2L }}</td>
                            </tr>
                            <tr>
                              <td class="td-pgno" rowspan="1">{{trans('pgno.tn')}}</td>
                              <td class="td-pgno" rowspan="1">{{ shgnS1D }}</td>
                              <td class="td-pgno" rowspan="1">{{ shgnTNL }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
       
                    </div>

                      <div class="block__centrators">
                        <h6 class="main__title__block_centrators"><b>{{trans('pgno.interval_centrators')}}:</b></h6>
                        <h6 class="title__block__centrators">{{trans('pgno.required')}}: <span v-for="item in centratorsRequiredValue">{{ item }}</span></h6>
                      </div>

                    <button class="button-pdf col-12" @click="createPDF()">
                      {{trans('pgno.sozdanie_otcheta')}}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <modal name="table" :draggable="true" :width="1150" :height="385" :adaptive="true"></modal>

          <div class="no-gutter col-md-12 first-column-params-block">
            <div class="container-fluid d-sm-block">
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row bottom-configuration">
                        <div class="col-6 px-2 curve-settings inflow-configuration-min-width">
                          <div class="bottom-configuration-header">
                            {{trans('pgno.nastroika_krivoy_pritoka')}}
                          </div>
                          <div class="inflow-configuration">
                            <div class="row pl-3">
                              <div class="col-7">
                                <div class="row">
                                  <div class="col-2 px-0 pt-1 ic-min-block1">
                                    <div class="table-border-gno-right py-1 ml-3">
                                      {{trans('pgno.p_pl')}}
                                    </div>
                                  </div>
                                  <div class="col-5  px-1">
                                    <div class="py-1">
                                      <input v-model="pResInput" @change="postCurveData()" onfocus="this.value=''"
                                        type="text" class="square3" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-2 px-0 pt-2 pb-0">
                                <div class="table-border-gno-right ic-ar pt-1">
                                 {{trans('pgno.obvodnenost')}}
                                </div>
                              </div>
                              <div class="col-2 pt-1 pl-2 pr-0">
                                <div class="py-1">
                                  <input v-model="wctInput" @change="postCurveData()" type="text"
                                    onfocus="this.value=''" class="square3" />
                                </div>
                              </div>

                            </div>
                            <div class="table-border-gno-top">
                              <div class="row pl-3">
                                <div class="col-7">
                                  <div class="row">
                                    <div class="col-2 px-0 ic-min-block1">
                                      <div class="table-border-gno-right">
                                        <label for="">
                                          <input v-model="curveSelect" class="checkbox-k-prod" value="pi" type="radio"
                                            name="set" @change="postCurveData()" />
                                          {{trans('pgno.k_prod')}}
                                        </label>

                                      </div>
                                    </div>

                                    <div class="col-5 py-1 px-1">
                                      <input v-model="piInput" :disabled="curveSelect != 'pi'" @change="postCurveData()"
                                        onfocus="this.value=''" type="text" class="square3" />

                                    </div>
                                  </div>
                                </div>
                                <div class="col-2 px-0">
                                  <div class="table-border-gno-right ic-ar pt-1">
                                    {{trans('pgno.gf_s')}}
                                  </div>
                                </div>
                                <div class="col-2  py-1 pl-2 pr-0">
                                  <input v-model="gorInput" @change="postCurveData()" type="text"
                                    onfocus="this.value=''" class="square3" />
                                </div>

                              </div>

                            </div>
                            <div class="table-border-gno-top">
                              <div class="row ic-bottom-row  pl-3">
                                <div class="col-7">
                                  <div class="row">
                                    <div class="col-2 px-0 ic-min-block1">
                                      <div class="table-border-gno-right">
                                        <label for="">
                                          <input v-model="QhydCurveSelect" class="checkbox-q-liquid" value="hdyn"
                                            type="radio" @change="postCurveData()" name="set" />{{trans('pgno.q_liq')}}</label>
                                      </div>
                                    </div>
                                    <div class="col-5 py-1 px-1">
                                      <input :disabled="curveSelect == 'pi'" v-model="qLInput" @change="postCurveData()"
                                        onfocus="this.value=''" type="text" class="square3" />
                                    </div>
                                  </div>
                                </div>
                                <div class="col-5"></div>
                              </div>
                            </div>

                            <div class="table-border-gno-top no-margin row">
                              <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                                <div class="col-6 table-border-gno-right gno-curve-radio-cell pt-1 pb-1">
                                  <label for="" class="text-ellipsis">
                                    <input v-model="curveSelect" value="bhp" :disabled="curveSelect == 'pi'"
                                      class="checkbox-k-prod" type="radio" @change="postCurveData()" name="set2" />
                                   {{trans('pgno.p_zab')}}</label>
                                </div>
                                <div class="col-6 pt-1 pb-1">
                                  <input :disabled="curveSelect != 'bhp'" v-model="bhpInput" @change="postCurveData()"
                                    onfocus="this.value=''" type="text" class="square3" />
                                </div>
                              </div>
                            </div>

                            <div class="table-border-gno-top no-margin row">
                              <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                                <div class="col-6 table-border-gno-right gno-curve-radio-cell pt-1 pb-1">
                                  <label for="" class="text-ellipsis">
                                    <input v-model="curveSelect" value="hdyn" :disabled="curveSelect == 'pi'"
                                      class="checkbox-k-prod" type="radio" @change="postCurveData()" name="set2" />
                                    {{trans('pgno.h_dyn')}}</label>
                                </div>
                                <div class="col-6 table-border-gno-right table-border-gno-right-second pt-1 pb-1">
                                  <input :disabled="curveSelect != 'hdyn'" v-model="hDynInput" @change="postCurveData()"
                                    type="text" onfocus="this.value=''" class="square3" />
                                </div>
                              </div>

                              <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                                <div class="col-6 table-border-gno-right pt-1 pb-1">
                                  <div class="tech-data curve text-ellipsis">
                                    {{trans('pgno.p_zat')}}
                                  </div>
                                </div>
                                <div class="col-6 pt-1 pb-1">
                                  <input :disabled="curveSelect != 'hdyn'" v-model="pAnnularInput"
                                    @change="postCurveData()" type="text" onfocus="this.value=''" class="square3" />
                                </div>
                              </div>
                            </div>

                            <div class="table-border-gno-top no-margin row">
                              <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                                <div class="col-6 table-border-gno-right gno-curve-radio-cell pt-1 pb-1">
                                  <label for="" class="text-ellipsis">
                                    <input v-model="curveSelect" value="pmanom" :disabled="curveSelect == 'pi'"
                                      class="checkbox-k-prod" type="radio" @change="postCurveData()" name="set2" />
                                    {{trans('pgno.p_manom')}}</label>
                                </div>
                                <div class="col-6 table-border-gno-right table-border-gno-right-second pt-1 pb-1">
                                  <input :disabled="curveSelect != 'pmanom'" v-model="pManomInput"
                                    @change="postCurveData()" type="text" onfocus="this.value=''" class="square3" />
                                </div>
                              </div>

                              <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                                <div class="col-6 table-border-gno-right pt-1 pb-1">
                                  <div class="tech-data curve text-ellipsis">
                                    {{trans('pgno.h_sp_manom')}}
                                  </div>
                                </div>
                                <div class="col-6 pt-1 pb-1">
                                  <input :disabled="curveSelect != 'pmanom'" v-model="hPumpManomInput"
                                    @change="postCurveData()" type="text" onfocus="this.value=''" class="square3" />
                                </div>
                              </div>
                            </div>

                            <div class="table-border-gno-top no-margin row">
                              <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                                <div class="col-6 table-border-gno-right gno-curve-radio-cell pt-1 pb-1">
                                  <label for="" class="text-ellipsis">
                                    <input v-model="curveSelect" value="whp" :disabled="curveSelect == 'pi'"
                                      class="checkbox-k-prod" type="radio" @change="postCurveData()" name="set2" />
                                    {{trans('pgno.p_buf')}}</label>
                                </div>
                                <div class="col-6 pt-1 pb-1">
                                  <input :disabled="curveSelect != 'whp'" v-model="whpInput" @change="postCurveData()"
                                    type="text" onfocus="this.value=''" class="square3" />
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="tables-string-gno5 col-12" @click="updateAnalysisMenu()">
                            {{trans('pgno.analis_potenciala_skvazhini')}}
                          </div>
                        </div>
                        <div class="col-6 px-2 choice-params">
                          <div class="bottom-configuration-header">
                            {{trans('pgno.parametry_podbora')}}
                          </div>
                          <div class="select-params">
                            <div class="row">
                              <div style="height: 5px;"></div>
                            </div>
                            <div class="row pt-3" style="height: 50px;">
                              <div class="col-2 pr-0">
                                <div>
                                  <label class="label-for-celevoi">
                                    <input class="checkbox3" value="ШГН" v-model="expChoose" @change="postCurveData()"
                                      :checked="expChoose === 'ШГН'" type="radio" name="gno10" />{{trans('pgno.shgn')}}</label>
                                </div>
                              </div>
                              <div class="col-2 pr-0">
                                <div>
                                  <label class="label-for-celevoi"><input class="checkbox3" value="ЭЦН"
                                      v-model="expChoose" @change="postCurveData()" :checked="expChoose === 'ЭЦН'"
                                      type="radio" name="gno10" />{{trans('pgno.ecn')}}</label>
                                </div>
                              </div>

                               <div class="col-2 pr-0">
                                <div>
                                  <label class="label-for-celevoi">
                                    <input class="checkbox3" value="ФОН"
                                      v-model="expChoose" @change="postCurveData()" :checked="expChoose === 'ФОН'"
                                       type="radio" name="gno10" />{{trans('pgno.fon')}}</label>
                                </div>
                              </div>

                              <div class="table-border-gno col-2">
                                <label class="label-for-celevoi">{{trans('pgno.p_buf')}}</label>
                                <input type="text" v-model="pBuf" onfocus="this.value=''" 
                                  class="input-box-gno podbor" :disabled="expChoose != 'ФОН'"/>
                              </div>

                              <div class="col-2">
                                <label class="label-for-celevoi" >Ø{{trans('pgno.nkt')}}</label>
                                  <select class="input-box-gno podbor" v-model="nkt" @change="postCurveData()">
                                    <option v-for="(nkts, index) in nkt_choose" :value="nkts.for_calc_value" :key="index" >
                                    {{nkts.show_value}}
                                    </option>
                                  </select>
                              </div>

                              <div class="col-2">
                                <label class="label-for-celevoi">{{trans('pgno.h_spuska')}}</label>
                                <input v-model="hPumpValue" @change="postCurveData()" type="text" onfocus="this.value=''" 
                                  class="input-box-gno podbor" />
                              </div>

                              <div class="gear-icon" @click="onChangeParams()">
                                <svg id="gear-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.4556 7.37945L15.7922 6.82498C15.6712 6.45197 15.52 6.08401 15.3436 5.73621L16.1249 4.16858C16.1753 4.06273 16.2055 3.95183 16.2055 3.8359C16.2055 3.63932 16.1249 3.44777 15.9838 3.30664L14.6934 2.01624C14.5522 1.87511 14.3607 1.79446 14.1641 1.79446C14.0482 1.79446 13.9373 1.8247 13.8314 1.87511L12.2638 2.62111C11.916 2.43965 11.548 2.28843 11.175 2.1725L10.6206 0.509101C10.5197 0.201625 10.2375 0 9.91487 0C9.89975 0 9.88967 0 9.87455 0H8.09017C7.76757 0 7.4853 0.201624 7.37945 0.504061L6.83002 2.1725C6.45197 2.28843 6.08905 2.43965 5.73621 2.62111L4.16858 1.87511C4.06777 1.8247 3.95183 1.79446 3.84094 1.79446C3.63932 1.79446 3.45281 1.87511 3.31168 2.01624L2.01624 3.30664C1.88015 3.44777 1.7995 3.63932 1.7995 3.8359C1.7995 3.95183 1.8247 4.06273 1.87511 4.16858L2.62616 5.73621C2.44469 6.08401 2.29348 6.45197 2.17754 6.82498L0.509101 7.37945C0.206665 7.48026 0 7.76253 0 8.08513V9.90983C0 9.91991 0 9.93503 0 9.95015C0 10.2677 0.206665 10.555 0.509101 10.6558L2.17754 11.2103C2.29348 11.5833 2.44469 11.9513 2.62111 12.2991L1.87511 13.8667C1.8247 13.9726 1.7995 14.0835 1.7995 14.1994C1.7995 14.396 1.88015 14.5875 2.01624 14.7286L3.31168 16.019C3.45281 16.1602 3.63932 16.2358 3.84094 16.2358C3.95183 16.2358 4.06777 16.2106 4.16858 16.1602L5.73621 15.3738C6.08905 15.5553 6.45197 15.7065 6.83002 15.8225L7.37945 17.4909C7.4853 17.7933 7.76757 18 8.09017 18H9.91487C9.92495 18 9.94007 18 9.95015 18C10.2728 18 10.555 17.7933 10.6609 17.4909L11.2103 15.8225C11.5884 15.7065 11.9513 15.5553 12.3041 15.3789L13.8717 16.1602C13.9726 16.2106 14.0885 16.2358 14.1994 16.2358C14.401 16.2358 14.5875 16.1602 14.7286 16.019L16.0241 14.7286C16.1602 14.5875 16.2408 14.396 16.2408 14.1994C16.2408 14.0835 16.2156 13.9726 16.1652 13.8667L15.3789 12.2991C15.5603 11.9513 15.7116 11.5833 15.8275 11.2103L17.4909 10.6558C17.7984 10.555 18 10.2677 18 9.95015C18 9.93503 18 9.91991 18 9.90983V8.08513C17.995 7.75749 17.7732 7.46514 17.4556 7.37945ZM9.00252 12.7326C6.94091 12.7326 5.26743 11.0591 5.26743 8.99748C5.26743 6.93587 6.94091 5.26239 9.00252 5.26239C11.0641 5.26239 12.7376 6.93587 12.7376 8.99748C12.7376 11.0591 11.0641 12.7326 9.00252 12.7326Z" fill="white"/>
                                </svg>
                              </div>


                            </div>
                            <div class="row">
                              <div style="height: 20px; padding-left: 15px;">{{trans('pgno.total_separation')}}</div>
                            </div>

                            <div class="row" style="padding-top: 3px;"> 

                              <div class="col-4">
                                <label style="width: 100px;" class="label-for-celevoi">
                                    <input value="calc_value" v-model="sep_meth" @change="postCurveData()" class="checkbox34" checked="true" type="radio" name="gno20" :disabled="expChoose === 'ФОН'"/>
                                    {{trans('pgno.separation_calc')}}
                                </label>
                              </div>
                              <div class="col-8 table-border-gno">
                                <input v-model="nat_sep" @change="postCurveData()" type="checkbox" checked="true" :disabled="sep_meth ==='input_value' || expChoose === 'ФОН'">{{trans('pgno.separation_nat')}}</div>

                            </div>

                            <div class="row">

                              <div class="col-4">
                                <label style="width: 100px;" class="label-for-celevoi">
                                  <input class="checkbox3" v-model="sep_meth" @change="postCurveData()" value="input_value" checked="true" type="radio" name="gno20" :disabled="expChoose === 'ФОН'"/>
                                  <input v-model="sep_value" @change="postCurveData()" type="text" onfocus="this.value=''" class="input-box-gno podbor" 
                                  :disabled="expChoose === 'ФОН' || sep_meth !='input_value'"/></label>
                              </div>

                              <div class="col-8 table-border-gno">
                                <input checked="true" @change="postCurveData()" :disabled="sep_meth ==='input_value' || expChoose === 'ФОН'" 
                              type="checkbox" v-model="mech_sep">{{trans('pgno.separation_mech')}}
                              <input v-model="mech_sep_value" type="text" style="margin-left: 3px; margin-bottom: 0px;" 
                              :disabled="sep_meth ==='input_value' || expChoose === 'ФОН' ||  mech_sep === false" onfocus="this.value=''" class="input-box-gno podbor" /></div>
                            </div>
                              

                            <div class="table-border-gno-top" style="padding-bottom: 0;">
                              <div class="row">
                                <div class="col-4 pr-0">
                                  <div class="table-border-gno-right pt-2 pb-3 podbor-bottom-title-line text-ellipsis">
                                    {{trans('pgno.celevoi_parametr')}}
                                  </div>
                                </div>
                                <div class="col-4 pr-0">
                                  <div class="table-border-gno-right  pt-2 pb-3 podbor-bottom-title-line">
                                    &nbsp;
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-4 pr-0">
                                <div class="table-border-gno-right pdo-bottom-cell">
                                  <label class="label-for-celevoi">
                                    <input v-model="CelButton" class="checkbox3" value="ql" type="radio"
                                      name="gno11" />{{trans('pgno.q_nefti')}}</label>
                                  <input v-model="qlCelValue" @change="postCurveData()" :disabled="CelButton != 'ql'"
                                    onfocus="this.value=''" type="text" class="square3 podbor" />
                                </div>
                              </div>
                              <div class="col-4 pr-0">
                                <div class="table-border-gno-right pdo-bottom-cell">
                                  <label class="label-for-celevoi"><input v-model="CelButton" class="checkbox3"
                                      value="bhp" type="radio" name="gno11" />{{trans('pgno.p_zab')}}</label>

                                  <input v-model="bhpCelValue" @change="postCurveData()" :disabled="CelButton != 'bhp'"
                                    type="text" onfocus="this.value=''" class="square3 podbor" />
                                </div>
                              </div>
                              <div class="col-4 pdo-bottom-cell">
                                <label class="label-for-celevoi">
                                  <input v-model="CelButton" class="checkbox3" value="pin" type="radio" :disabled="expChoose === 'ФОН'"
                                    name="gno11" />{{trans('pgno.p_pr')}}
                                </label>
                                <input v-model="piCelValue" @change="postCurveData()" :disabled="CelButton != 'pin' || expChoose === 'ФОН'"
                                  type="text" onfocus="this.value=''" class="square3 podbor" />
                              </div>
                            </div>
                          </div>

                          <div class="tables-string-gno55 col-12" @click="setExpAnalysisMenu()">
                             {{trans('pgno.analis_effect_sposoba_exp')}}
                          </div>
                        </div>
                        <div class="col-12 px-2 gno-main-green-button">
                          <div class="button-podbor-gno col-12" @click="onPgnoClick()">
                            {{ isVisibleChart ? podborGnoTitle : inflowCurveTitle }}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Конец блока -->
        </div>
      </div>
      <div style="position: absolute; left: -9999px; height: 0; overflow: hidden;">
        <div class="gno-line-chart-clone" ref="gno-chart" v-if="isVisibleChart" style="background-color: #272953;">
                <div>
                  <div style="font-weight: bold; font-size: 20px; margin-left: 16px;  padding-top: 10px;">{{trans('pgno.well')}}: {{field}}-{{wellNumber}}</div>
                  <div style="font-weight: bold; font-size: 20px; margin-left: 16px;  padding-top: 10px;">{{trans('pgno.data_form')}}: {{new Date().toJSON().slice(0,10).replace(/-/g,'/')}}</div>
                </div>
                <inflow-curve></inflow-curve>
              </div>

        <div class="gno-line-chart-well-old-clone" ref="gno-chart-new-old-well" v-if="isVisibleChart" style="background-color: #272953;">
                <div>
                  <div style="font-weight: bold; font-size: 20px; margin-left: 16px;  padding-top: 10px;">{{trans('pgno.analis_potenciala_skvazhini')}}: {{field}}-{{wellNumber}}</div>
                  <div style="font-weight: bold; font-size: 20px; margin-left: 16px;  padding-top: 10px;">{{trans('pgno.data_form')}}: {{new Date().toJSON().slice(0,10).replace(/-/g,'/')}}</div>
                </div>
                <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
              </div>

        <div class="report" ref="gno-page">
          <div class="row">
            <div class="col-10" style="background-color: #20274f; width: 1500px; left: 76px; margin: 0;">
              <div class="logo" style="top: 0px;"></div>
              <div style="left: 90px; color: white; padding-top: 10px; font-size: 20px;">{{trans('pgno.is_Abai_modul_gno')}}</div>
            </div>
          </div>
        <div class="first-report-block row">
          <div class="report-block-title col-5">
            {{trans('pgno.otchet_pgno')}}
          </div>
          <div class="report-block-title col-5">
            {{trans('pgno.well')}} {{wellNumber}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data col-5">
            {{trans('pgno.data_form')}}: {{new Date().toJSON().slice(0,10).replace(/-/g,'/')}}
          </div>
          <div class="report-block-data col-5">
            {{trans('pgno.mestorozhdenie')}}: {{field}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data col-5">
            {{trans('pgno.technolog_kmgi')}}
          </div>
          <div class="report-block-data col-5">
            {{trans('pgno.horizon')}}: {{horizon}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data col-5">

          </div>
          <div class="report-block-data col-5">
            {{trans('pgno.method_of_operation')}}: {{ expMeth }}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-bottom col-5">

          </div>
          <div class="report-block-data-second-bottom col-5">
            {{trans('pgno.org_struktura')}}: {{ ngdu }}
          </div>
        </div>

        <div class="second-report-block row">
          <div class="second-report-block-title-main col-10" style="border-bottom: 2px solid #8c8caf">
            {{trans('pgno.data_for_raschet')}}
          </div>
        </div>

        <div class="first-report-block row">
          <div class="second-report-block-title col-5">
            {{trans('pgno.construction')}}
          </div>
          <div class="second-report-block-title col-5">
            PVT
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.naruznii_diametr_ex_col')}}: {{casOD}} {{trans('measurements.mm')}}
          </div>
          <div class="report-block-data-second-top col-5">
             {{trans('pgno.p_nas')}}: {{PBubblePoint}} {{trans('measurements.atm')}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.vnutrenii_diametr_ex_col')}}: {{casID}}
          </div>
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.gaz_faktor')}}: {{gorInput}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.glubina_perf')}}: {{hPerf}} {{trans('measurements.m')}}
          </div>
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.temp_plasta')}}: {{tRes}} {{trans('measurements.celsius')}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.udlinenie_perf')}}: {{udl}} {{trans('measurements.m')}}
          </div>
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.vyazkost_nefti')}}: {{viscOilRc}} {{trans('measurements.spz')}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.tekushii_zaboi')}}: {{curr}} {{trans('measurements.m')}}
          </div>
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.vyazkost_vody')}}: {{viscWaterRc}} {{trans('measurements.g/sm3')}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">

          </div>
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.plotnost_nefti')}}: {{densOil}} {{trans('measurements.g/sm3')}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-bottom-2 col-5">

          </div>
          <div class="report-block-data-second-bottom-2 col-5">
            {{trans('pgno.plotnost_vody')}}: {{densWater}} {{trans('measurements.g/sm3')}}
          </div>
        </div>

        <div class="second-report-block row">
          <div class="second-report-block-title-main-2 col-10" style="border-bottom: 2px solid #8c8caf">
            {{trans('pgno.technologicheskii_rezhim')}}:
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.q_liq')}}: {{qL}} {{trans('measurements.m3/day')}}
          </div>
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.p_zab')}}: {{bhp}} {{trans('measurements.atm')}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.obvodnenost')}}: {{wct}} {{trans('measurements.percent')}}
          </div>
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.q_nefti')}}: {{qO}} {{trans('measurements.t/d')}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.h_dyn')}}: {{hDyn}} {{trans('measurements.m')}}
          </div>
          <div class="report-block-data-second-top col-5">
            {{trans('pgno.p_zat')}}: {{pAnnular}} {{trans('measurements.atm')}}
          </div>
        </div>

        <div class="first-report-block-data row">
          <div class="report-block-data-third-bottom col-5">
            {{trans('pgno.gf')}}: {{gor}} {{trans('measurements.m3/t')}}
          </div>
          <div class="report-block-data-third-bottom col-5">
            {{trans('pgno.p_pl')}}: {{pRes}} {{trans('measurements.atm')}}
          </div>
        </div>

        <div class="gno-chart-clone col-10">
          <inflow-curve></inflow-curve>
        </div>

        <div class="title-page-2 col-10">
          <h2>{{trans('pgno.result_podbora_gno')}}</h2>
        </div>

        <div class="block-results row">
          <div class="col-12">
            <div class="block-results row">
              <div class="image-data-clone col-4">

                <div class="shgn-image-text image-text-1">{{trans('pgno.eks_kolonna')}} {{ this.casID }}{{trans('measurements.mm')}}</div>
                    <div class="shgn-image-text image-text-2">{{trans('pgno.nkt')}} {{ this.tubOD }}{{trans('measurements.mm')}}</div>
                    <div class="shgn-image-text image-text-3">{{trans('pgno.shtangi')}} {{ this.shgnS1D }}{{trans('measurements.mm')}} 0-{{ this.shgnS1L }}{{trans('measurements.m')}}</div>
                    <div class="shgn-image-text image-text-4">
                      {{trans('pgno.shtangi')}} {{ this.shgnS2D }}{{trans('measurements.mm')}} {{ this.shgnS1L }}-{{
                        this.shgnS1L * 1 + this.shgnS2L * 1
                      }}{{trans('measurements.m')}}
                    </div>
                    <div class="shgn-image-text image-text-5">
                      {{trans('pgno.shtangi')}} {{ this.shgnS1D }}{{trans('measurements.mm')}}
                      {{ this.shgnS1L * 1 + this.shgnS2L * 1 }}-{{
                        this.shgnS1L * 1 + this.shgnS2L * 1 + this.shgnTNL * 1
                      }}{{trans('measurements.m')}}
                    </div>
                    <div class="shgn-image-text image-text-6">{{trans('pgno.nasos')}} {{ this.shgnPumpType }}{{trans('measurements.mm')}}</div>
                    <div class="shgn-image-text image-text-7">
                      {{trans('pgno.interval_perf')}} <br> {{ this.hPerf }}-{{
                        this.hPerf * 1 + this.hPerfND * 1
                      }}{{trans('measurements.m')}}
                    </div>
                    <div class="shgn-image-text image-text-8">{{trans('pgno.tekushii_zaboi')}} {{ this.curr }}{{trans('measurements.m')}}</div>
                
                <img class="podborgnoimg"
                         src="./images/shgn.png"
                         alt="podbor-gno"/>

              </div>

              <div class="block-gno-data col-6">
                <div class="row">
                  <div class="col-12">
                    <div class="col-12"
                      style="margin-left: -15px; background-color: #656a8a; width: 513px; max-width: 1000px; font-size: 20px; color: white; height: 50px; padding-top: 10px; font-weight: bold;">
                      {{trans('pgno.raschetnii_rezhim')}}:
                    </div>

                    <div class="row">
                      <div class="col-6"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                        {{trans('pgno.q_liq')}}: {{qLInput}}
                      </div>
                      <div class="col-6"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">
                        {{trans('pgno.q_nefti')}}: {{qO}}
                      </div>

                      <div class="col-6"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                        {{trans('pgno.obvodnenost')}}: {{wctInput}}
                      </div>
                      <div class="col-6"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">
                        {{trans('pgno.p_zab')}}: {{bhpInput}}
                      </div>

                      <div class="col-6"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                        {{trans('pgno.p_pr')}}: {{piCelValue}}
                      </div>
                      <div class="col-6"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">

                      </div>

                    </div>
                  </div>

                  <div class="col-12">
                    <div class="col-12"
                      style="margin-left: -15px; background-color: #656a8a; width: 513px; max-width: 1000px; font-size: 20px; color: white; height: 50px; padding-top: 10px; font-weight: bold;">
                      {{trans('pgno.komponovka_shgn')}}
                    </div>
                    <div class="col-12"
                      style="margin-left: -15px; background-color: #c1c3d0; width: 513px; max-width: 1000px; font-size: 20px; color: black; height: 50px; padding-top: 10px;">
                      {{trans('pgno.diametr_nasosa')}}:
                    </div>
                    <div class="row">
                      <div class="col-6"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                        {{trans('pgno.h_spuska')}}: {{hPumpManomInput}}
                      </div>
                      <div class="col-6"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">
                        {{trans('pgno.typ_sk')}}: {{sk}}
                      </div>

                      <div class="col-6"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf;">
                        {{trans('pgno.dlina_hoda')}}: {{strokeLenDev}} {{trans('measurements.m')}}
                      </div>
                      <div class="col-6"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-right: 2px solid #8c8caf;">
                        {{trans('pgno.chislo_kachanii')}}: {{spmDev}} {{trans('measurements.1/min')}}
                      </div>

                    </div>

                    <div class="col-12"
                      style="margin-left: -15px; background-color: #c1c3d0; width: 513px; max-width: 1000px; font-size: 20px; color: black; height: 50px; padding-top: 10px; font-weight: bold;">
                      {{trans('pgno.kolonna_shtang')}}:
                    </div>
                    <div class="row">
                      <div class="col-4"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                        {{trans('pgno.sekcia')}} 1
                      </div>
                      <div class="col-4"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                        {{trans('measurements.diameter')}}: {{shgnS1D}} {{trans('measurements.mm')}}
                      </div>

                      <div class="col-4"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; height: 29px;">
                        {{trans('measurements.dlina')}}: {{shgnS1L}} {{trans('measurements.m')}}
                      </div>

                      <div class="col-4"
                        style="background-color: white; color: black;  border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                        {{trans('pgno.sekcia')}} 2
                      </div>
                      <div class="col-4"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                        {{trans('measurements.diameter')}}: {{shgnS2D}} {{trans('measurements.mm')}}
                      </div>

                      <div class="col-4"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; height: 29px;">
                        {{trans('measurements.dlina')}}: {{shgnS2L}} {{trans('measurements.m')}}
                      </div>

                      <div class="col-4"
                        style="background-color: white; color: black; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                        {{trans('pgno.tn')}}
                      </div>
                      <div class="col-4"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; border-left: 2px solid #8c8caf; height: 29px;">
                        {{trans('measurements.diameter')}}: {{shgnS1D}} {{trans('measurements.mm')}}
                      </div>

                      <div class="col-4"
                        style="background-color: white; color: black; border-right: 2px solid #8c8caf; border-bottom: 2px solid #8c8caf; height: 29px;">
                        {{trans('measurements.dlina')}}: {{shgnTNL}} {{trans('measurements.m')}}
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      
    </div>
    <notifications position="top"></notifications>
    <full-page-loader v-show="isLoading" />
  </div>
</template>

<script src="./Table.js"></script>

<style scoped>
.gear-icon {
  right: 12px;
  top: 35px;
  position: absolute;
}

@keyframes gear-icon {
  50% { left: 0;}
  90% { left: 300px;}
}
  
.checkbox-devices {
  width: 845px;
  height: 45px;
}

.download-button-excel {
  position: absolute;
  margin-left: 175px;
  margin-top: 0px;
}

.download-button-excel-1 {
  position: absolute;
  margin-left: 175px;
  margin-top: 5px;
}

.block__centrators {
  background-color:#272953;
  align-items: center;
  border-radius:6px;
  border:2px solid #454d7d;
  display:inline-block;
  cursor:pointer;
  color:#ffffff;
  font-family:Arial;
  font-size:14px;
  padding:1px 15px;
  text-decoration:none;
  text-shadow:0px 1px 0px #144079;
  width: 100%;
  word-spacing: 4px;
}

.select-download-button {
outline: none;
text-align: center;
width: 114px;
height: 24px;
font-size: 14px;
color: white;
border: 0.4px solid #222452;
box-sizing: border-box;
border-radius: 4px;
-moz-appearance: none;
-webkit-appearance: none;
appearance: none;
background: #323370 url("data:image/svg+xml;utf8,<svg viewBox='0 0 140 140' width='14' height='14' xmlns='http://www.w3.org/2000/svg'><g><path d='m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z' fill='white'/></g></svg>") no-repeat;
background-position: right 5px top 50%;
}

.download-curve-button {
position: relative;
text-align: center;
width: 114px;
height: 24px;
font-size: 14px;
color: white;
border: 0.4px solid #222452;
box-sizing: border-box;
border-radius: 4px;
background: #323370;
outline: none;
left: 20px;
top: 8px;
}

.select-gno2 {
outline: none;
width: 95px;
height: 24px;
color: white;
border: 0.4px solid #222452;
box-sizing: border-box;
-moz-appearance: none;
-webkit-appearance: none;
margin-top: -2px;
margin-right: 1px;
appearance: none;
background: #494aa5 url("data:image/svg+xml;utf8,<svg viewBox='0 0 140 140' width='14' height='14' xmlns='http://www.w3.org/2000/svg'><g><path d='m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z' fill='white'/></g></svg>") no-repeat;
background-position: right 5px top 50%;
}

.title__block__centrators {
  margin-bottom: 2px; 
}

.main__title__block_centrators {
  text-align: center;
  margin-bottom: 0;
}


.input-box-gno {
    background: #494AA5;
    border: 1px solid #272953;
    outline: none;
    width: 100%;
    height: 22px;
    color: white;
    box-sizing: border-box;
    border-radius: 2px;
    line-height: 25px !important;
    padding-right: 5px;
    padding-left: 5px;
}

.input-box-gno:focus {
    background: #5657c7;
}

.input-box-gno:disabled {
    color: #928f8f;
    background: #353e70;
}

.input-box-gno.podbor {
    width: 57px;
    margin-bottom: 10px;
}

.button-podbor-gno {
    float: left;
    font-size: 16px;
    font-weight: bold;
    position: relative;
    padding: 15px 15px;
    height: 44px;
    background: rgba(19, 176, 98, 0.8);
    border-radius: 8px;
    text-align: center;
    margin-bottom: 0;
    line-height: 18px;
    cursor: pointer;
}

.button-podbor-gno:active {
    background-color: #144079;
    box-shadow: 0 2px #666;
    transform: translateY(0.02px);
    filter: blur(0.3px);
}

.button-podbor-gno:hover {
    background-color: #484749;
}

.table-pgno-four {
  height: 100px;
}

.table-pgno-two {
  height: 200px;
}

.table-pgno-one {
  height: 200px;
}

.table__centrators {
  border: 1px solid #1C6EA4;
  background-color: #2c335d;
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}

.table__centrators .table__cell {
  border: 1px solid #454d7d;
  padding: 3px 0px;
}

.table__centrators .table__body .table__cell {
  font-size: 13px;
}

.table__centrators .table__row:nth-child(even) {
  background: #2c335d;
}

.title__centrator {
  text-align: center;
}

.table__centrators{ display: table; }
.table__row { display: table-row; }
.table__cell { display: table-cell;}
.table__body { display: table-row-group;}
</style>
