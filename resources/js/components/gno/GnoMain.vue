<template>
  <div class="gno-page-wrapper">
    <div v-if="!isServiceOnline">
      <img src="/img/404.svg" alt=""/>
    </div>
    <div v-else>
      <div class="row gno-page-container">
        <div class="pr-0 pl-0 col-lg-3 order-md-2">
          <div class="col-md-12 second-column-container">
            <!-- Выбор скважины start -->
            <div class="choose-well-block col-12">
              <div class="choosing-well-title col-9">{{ trans('pgno.choose_well') }}</div>
              <div v-bind:title="trans('pgno.refresh')" class="choosing-well-edit col-1"
                   @click="getWellData(wellNumber)" style="cursor: pointer;">
                <img src="/img/gno/update.svg" alt="">
              </div>
              <div class="choosing-well-edit col-1" @click="editPage" style="cursor: pointer;">
                <img src="/img/gno/edit.svg" alt="">
              </div>

              <div class="choosing-well-data  col-7">{{ trans('pgno.mestorozhdenie') }}</div>
              <div class="choosing-well-data left-border-line right-block-data col-5 pl-1 pr-1 pt-0 pb-1">
                <select class="select-well" v-model="field">
                  <option v-for="org in this.organizations" :value="org.short_name" :key="org.id">
                    {{ org.full_name }}
                  </option>
                </select>
              </div>
              <div class="choosing-well-data top-border-line  col-7">
                {{ trans('pgno.well') }} №
              </div>
              <div class="choosing-well-data left-border-line top-border-line right-block-data  col-5 pl-1 pr-1 pt-0 pb-1">
                <input v-model="wellNumber" onfocus="this.value=''" type="text" @change="getWellData(wellNumber)"
                       class="well-number-input pl-1"/>
              </div>
              <div class="choosing-well-data top-border-line  col-7">
                <div class="row">
                  <div class="col-9">{{ trans('pgno.new_well') }}</div>
                  <div class="col-3 pr-1">
                    <input :checked="well.newWell" v-model="well.newWell" class="new-well-grp-checkbox" type="checkbox"/>
                  </div>
                </div>
              </div>
              <div class="choosing-well-data left-border-line top-border-line right-block-data  col-5">
                <div class="row">
                  <div class="col-9">{{ trans('pgno.grp') }}</div>
                  <div class="col-3 pr-1">
                    <input class="new-well-grp-checkbox" v-model="analysisSettings.hasGrp" :disabled="!well.newWell" type="checkbox"/>
                  </div>
                </div>

              </div>

              <div class="choosing-well-data top-border-line  col-7">{{ trans('pgno.horizon') }}</div>
              <div class="choosing-well-data left-border-line top-border-line right-block-data  col-5"
                   v-if="!isEditing">
                {{ horizon }}
              </div>
              <select v-if="isEditing"
                      class="devices-data left-border-line right-block-data no-gutter col-5 select-edit"
                      v-model="horizon">
                <option v-for="hor in this.horizons" :value="hor.hor_value" :key="hor.id">
                  {{ hor.hor_name }}
                </option>
              </select>
              <div class="choosing-well-data top-border-line  col-7">
                {{ trans('pgno.method_of_operation') }}
              </div>
              <div class="choosing-well-data left-border-line top-border-line right-block-data  col-5">
                {{ well.expMeth }}
              </div>

              <div class="choosing-well-data top-border-line  col-7">
                {{ well.tseh }}
              </div>
              <div class="choosing-well-data top-border-line right-block-data  col-5">
                {{ well.gu }}
              </div>

              <div class="choosing-well-data col-7">
                {{ well.ngdu }}
              </div>
              <div class="choosing-well-data right-block-data  col-5">
                {{ ao }}
              </div>
            </div>
            <!-- Выбор скважины end -->

            <!-- Конструкция start-->
            <div class="construction-block">
              <div class="construction no-gutter col-12"><b>{{ trans('pgno.construction') }}</b></div>
              <div class="construction-data no-gutter col-7">{{ trans('pgno.naruznii_diametr_ex_col') }}</div>
              <div v-if="!isEditing" class="construction-data left-border-line right-block-data no-gutter col-5">
                {{ well.casOd }} {{ trans('measurements.mm') }}
              </div>
              <input v-if="isEditing" v-model="well.casOd"
                     class="construction-data left-border-line right-block-data no-gutter col-5 editable-input"
                     type="text"/>

              <div class="construction-data top-border-line no-gutter col-7">
                {{ trans('pgno.vnutrenii_diametr_ex_col') }}
              </div>
              <div v-if="!isEditing"
                   class="construction-data left-border-line top-border-line right-block-data no-gutter col-5">
                {{ well.casId }} {{ trans('measurements.mm') }}
              </div>
              <input v-if="isEditing" v-model="well.casId"
                     class="construction-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                     type="text"/>

              <div class="construction-data hperf top-border-line no-gutter col-7">
                {{ trans('pgno.glubina_perf') }}
                <div class="perforation-intervals">
                  {{ trans('pgno.interval_perf') }}: <b v-for="item in well.hPerfRange">{{ item }}</b>
                </div>
              </div>
              <div v-if="!isEditing"
                   class="construction-data left-border-line top-border-line right-block-data no-gutter col-5">
                {{ well.hUpPerfVd }} {{ trans('measurements.m') }}
              </div>
              <input v-if="isEditing" v-model="well.hUpPerfVd"
                     class="construction-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                     type="text"/>

              <div class="construction-data top-border-line no-gutter col-7">
                {{ trans('pgno.udlinenie_perf') }}
              </div>
              <div v-if="!isEditing"
                   class="construction-data left-border-line top-border-line right-block-data no-gutter col-5">
                {{ well.hVdpUdl }} {{ trans('measurements.m') }}
              </div>
              <input v-if="isEditing" v-model="well.hVdpUdl"
                     class="construction-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                     type="text"/>

              <div class="construction-data top-border-line no-gutter col-7">
                {{ trans('pgno.tekushii_zaboi') }}
              </div>
              <div v-if="!isEditing"
                   class="construction-data left-border-line top-border-line right-block-data no-gutter col-5">
                {{ well.currBh }} {{ trans('measurements.m') }}
              </div>
              <input v-if="isEditing" v-model="well.currBh"
                     class="construction-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                     type="text"/>
            </div>
            <!-- Конструкция end -->

            <!-- Кнопка инклонометрии start -->
            <div class="inclinometry-button" @click="openInclinometryModal()">{{ trans('pgno.inclinometria') }}</div>
            <!-- Кнопка инклонометрии end-->

            <div class="spoiler"
                 :class="{ 'opened': activeRightTabName === 'devices' }">
              <input class="hidden-checkbox"
                     type="checkbox"
                     tabindex="-1"
                     :checked="activeRightTabName === 'devices'"
                     @change="setActiveRightTabName($event, 'devices')"/>
              <div class="right-side-box">
                <div class="right-title-block no-gutter col-12">
                  <div class="devices-title"><b>{{ trans('pgno.devices') }}</b></div>
                </div>
                <span class="closer">
                 <img src="/img/gno/top-arrow.svg" alt="">
                </span>
                <span class="open">
                  <img src="/img/gno/bottom-arrow.svg" alt="">
                </span>

                <div class="right-block-details" v-show="activeRightTabName === 'devices'">
                  <div class="devices-data no-gutter col-7">
                    {{ trans('pgno.stanok_kachalka') }}
                  </div>
                  <div v-if="!isEditing" class="devices-data left-border-line right-block-data no-gutter col-5">
                    {{ skType }}
                  </div>
                  <select v-if="isEditing"
                          class="devices-data left-border-line right-block-data no-gutter col-5 select-edit"
                          v-model="skType" @change="isSkError = false">
                    <option v-for="sk in this.skTypes" :value="sk.sk_value" :key="sk.id">
                      {{ sk.sk_name }}
                    </option>
                  </select>

                  <div class="hide-block" v-show="well.expMeth == 'ШГН'">
                    <div class="devices-data top-border-line no-gutter col-7">
                      {{ trans('pgno.dlina_hoda') }}
                    </div>
                    <div v-if="!isEditing"
                         class="devices-data left-border-line top-border-line right-block-data no-gutter col-5">
                      {{ well.strokeLen }} {{ trans('measurements.m') }}
                    </div>
                    <input v-if="isEditing" v-model="well.strokeLen"
                           class="devices-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                           type="text"/>
                  </div>

                  <div v-if="well.expMeth == 'ШГН'">
                    <div class="devices-data top-border-line no-gutter col-7">
                      {{ trans('pgno.pumpRateShgn') }}
                    </div>
                    <div v-if="!isEditing"
                         class="devices-data left-border-line top-border-line right-block-data no-gutter col-5">
                      {{ well.spm }} {{ trans('measurements.1/min') }}
                    </div>
                    <input v-if="isEditing" v-model="well.spm"
                           class="devices-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                           type="text"/>

                    <div class="devices-data top-border-line no-gutter col-7">
                      {{ trans('pgno.pumpTypeShgn') }}
                    </div>
                    <div v-if="!isEditing"
                         class="devices-data left-border-line top-border-line right-block-data no-gutter col-5">
                      {{ well.pumpType }} {{ trans('measurements.mm') }}
                    </div>
                    <input v-if="isEditing" v-model="well.pumpType"
                           class="devices-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                           type="text"/>
                  </div>

                  <div v-if="well.expMeth == 'ЭЦН'">
                    <div class="devices-data top-border-line no-gutter col-7">
                      {{ trans('pgno.pumpTypeEcn') }}
                    </div>
                    <div v-if="!isEditing"
                         class="devices-data left-border-line top-border-line right-block-data no-gutter col-5">
                      {{ devBlockRatedFeed }} {{ trans('measurements.gc') }}
                    </div>
                    <input v-if="isEditing" v-model="spmDev"
                           class="devices-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                           type="text"/>

                    <div class="devices-data top-border-line no-gutter col-7">
                      {{ trans('pgno.pumpTypeEcn') }}
                    </div>
                    <div v-if="!isEditing"
                         class="devices-data left-border-line top-border-line right-block-data no-gutter col-5">
                      {{ devBlockFrequency }} {{ trans('measurements.m3/day') }}
                    </div>
                    <input v-if="isEditing" v-model="well.pumpType"
                           class="devices-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                           type="text"/>
                  </div>

                  <div class="devices-data top-border-line no-gutter col-7">
                    {{ trans('pgno.h_spuska') }}
                  </div>
                  <div v-if="!isEditing"
                       class="devices-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.hPumpSet }} {{ trans('measurements.m') }}
                  </div>
                  <input v-if="isEditing" v-model="well.hPumpSet"
                         class="devices-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                         type="text"/>

                  <div class="devices-data top-border-line no-gutter col-7">
                    {{ trans('pgno.naruzhnii_nkt') }}
                  </div>
                  <div v-if="!isEditing"
                       class="devices-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.tubOd }} {{ trans('measurements.mm') }}
                  </div>
                  <input v-if="isEditing" v-model="well.tubOd"
                         class="devices-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                         type="text"/>

                  <div class="devices-data top-border-line no-gutter col-7">
                    {{ trans('pgno.vnutrenii_nkt') }}
                  </div>
                  <div v-if="!isEditing"
                       class="devices-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.tubId }} {{ trans('measurements.mm') }}
                  </div>
                  <input v-if="isEditing" v-model="well.tubId"
                         class="devices-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                         type="text"/>

                  <div class="devices-data top-border-line no-gutter col-7">
                    {{ trans('pgno.data_zapuska') }}
                  </div>
                  <div class="devices-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.stopDate }}
                  </div>
                  <div class="prs-button" @click="openPrsModal()">{{ trans('pgno.istoria_krs_prs') }}</div>
                </div>
              </div>
            </div>

            <div class="spoiler"
                 :class="{ 'opened': activeRightTabName === 'pvt' }">
              <input class="hidden-checkbox"
                     type="checkbox"
                     tabindex="-1"
                     :checked="activeRightTabName === 'pvt'"
                     @change="setActiveRightTabName($event, 'pvt')"/>
              <div class="right-side-box">
                <div class="right-title-block no-gutter col-12">
                  <div class="pvt-title">{{ trans('pgno.pvt') }}</div>
                </div>
                <span class="closer">
                  <img src="/img/gno/top-arrow.svg" alt="">
                </span>

                <span class="open">
                  <img src="/img/gno/bottom-arrow.svg" alt="">
                </span>

                <div class="right-block-details" v-show="activeRightTabName === 'pvt'">
                  <div class="pvt-data no-gutter col-7">{{ trans('pgno.p_nas') }}</div>
                  <div v-if="!isEditing" class="pvt-data left-border-line right-block-data no-gutter col-5">
                    {{ well.PBubblePoint }} {{ trans('measurements.atm') }}
                  </div>
                  <input v-if="isEditing" v-model="well.PBubblePoint"
                         class="pvt-data left-border-line right-block-data no-gutter col-5 editable-input"
                         type="text"/>

                  <div class="pvt-data top-border-line no-gutter col-7">{{ trans('pgno.gf') }}</div>
                  <div v-if="!isEditing"
                       class="pvt-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.gor }} {{ trans('measurements.m3/t') }}
                  </div>
                  <input v-if="isEditing" v-model="well.gor"
                         class="pvt-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                         type="text"/>

                  <div class="pvt-data top-border-line no-gutter col-7">{{ trans('pgno.t_pl') }}</div>
                  <div v-if="!isEditing"
                       class="pvt-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.tRes }} {{ trans('measurements.celsius') }}
                  </div>
                  <input v-if="isEditing" v-model="well.tRes"
                         class="pvt-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                         type="text"/>

                  <div class="pvt-data top-border-line no-gutter col-7">
                    {{ trans('pgno.vyazkost_nefti') }}
                  </div>
                  <div v-if="!isEditing"
                       class="pvt-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.viscOilRc }} {{ trans('measurements.spz') }}
                  </div>
                  <input v-if="isEditing" v-model="well.viscOilRc"
                         class="pvt-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                         type="text"/>

                  <div class="pvt-data top-border-line no-gutter col-7">
                    {{ trans('pgno.vyazkost_vody') }}
                  </div>
                  <div v-if="!isEditing"
                       class="pvt-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.viscWatRc }} {{ trans('measurements.spz') }}
                  </div>
                  <input v-if="isEditing" v-model="well.viscWatRc"
                         class="pvt-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                         type="text"/>

                  <div class="pvt-data top-border-line no-gutter col-7">
                    {{ trans('pgno.plotnost_nefti') }}
                  </div>
                  <div v-if="!isEditing"
                       class="pvt-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.densOil }} {{ trans('measurements.g/sm3') }}
                  </div>
                  <input v-if="isEditing" v-model="well.densOil"
                         class="pvt-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                         type="text" @change="changeValue('dens_oil', densOil)"/>

                  <div class="pvt-data top-border-line no-gutter col-7">
                    {{ trans('pgno.plotnost_vody') }}
                  </div>
                  <div v-if="!isEditing"
                       class="pvt-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.densLiq }} {{ trans('measurements.g/sm3') }}
                  </div>
                  <input v-if="isEditing" v-model="well.densLiq"
                         class="pvt-data left-border-line top-border-line right-block-data no-gutter col-5 editable-input"
                         type="text"/>
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
                <div class="right-title-block no-gutter col-12">

                  <div class="technological-mode-title">{{ trans('pgno.technologicheskii_rezhim') }}
                    {{ techmodeDate }}
                  </div>
                </div>
                <span class="closer">
                   <img src="/img/gno/top-arrow.svg" alt="">
                  </span>
                <span class="open">
                   <img src="/img/gno/bottom-arrow.svg" alt="">
                  </span>
                <div class="right-block-details"
                     v-show="activeRightTabName === 'technological-mode' || (windowWidth <= 1300 && windowWidth > 991)">
                  <div class="tech-data no-gutter col-7">{{ trans('pgno.q_zhidkosti') }}</div>
                  <div class="tech-data left-border-line right-block-data no-gutter col-5">
                    {{ well.qL }} {{ trans('measurements.m3/day') }}
                  </div>

                  <div class="tech-data top-border-line no-gutter col-7">{{ trans('pgno.q_nefti') }}</div>
                  <div class="tech-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.qO }} {{ trans('measurements.t/d') }}
                  </div>

                  <div class="tech-data top-border-line no-gutter col-7">{{ trans('pgno.obvodnenost') }}</div>
                  <div class="tech-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.wct }} {{ trans('measurements.percent') }}
                  </div>

                  <div class="tech-data top-border-line no-gutter col-7">{{ trans('pgno.p_zab') }}</div>
                  <div class="tech-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.bhp }} {{ trans('measurements.atm') }}
                  </div>

                  <div class="tech-data top-border-line no-gutter col-7">{{ trans('pgno.p_pl') }}</div>
                  <div class="tech-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.pRes }} {{ trans('measurements.atm') }}
                  </div>

                  <div class="tech-data top-border-line no-gutter col-7">{{ trans('pgno.h_dyn') }}</div>
                  <div class="tech-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.hDyn }} {{ trans('measurements.m') }}
                  </div>

                  <div class="tech-data top-border-line no-gutter col-7">{{ trans('pgno.p_zat') }}</div>
                  <div class="tech-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.pAnnular }} {{ trans('measurements.atm') }}
                  </div>

                  <div class="tech-data top-border-line no-gutter col-7">{{ trans('pgno.p_buf') }}</div>
                  <div class="tech-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.whp }} {{ trans('measurements.atm') }}
                  </div>

                  <div class="tech-data top-border-line no-gutter col-7">{{ trans('pgno.p_lin') }}</div>
                  <div class="tech-data left-border-line top-border-line right-block-data no-gutter col-5">
                    {{ well.lineP }} {{ trans('measurements.atm') }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="no-gutter col-lg-9 order-md-1 pr-0 pl-0 container-fluid no-gutter">
          <div class="no-gutter col-md-12 first-column-curve-block">
            <div class="background">
              <modal class="modal-bign-wrapper" name="modalIncl" draggable=".modal-bign-header" :width="1300"
                     :height="700"
                     style="background: transparent;" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">{{ trans('pgno.inclinometriaWell', {wellNumber : wellNumber}) }}</div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modalIncl')">
                      {{ trans('pgno.zakrit') }}
                    </button>
                  </div>

                  <div class="Table" align="center" x:publishsource="Excel">
                    <inclinometry @update-hpump="closeInclModal($event)">
                    </inclinometry>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper" name="modalTabs" draggable=".modal-bign-header" :width="1000" :height="800"
                     style="background: transparent;" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">Настройки</div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modalTabs')">
                      {{ trans('pgno.zakrit') }}
                    </button>
                  </div>

                  <div class="Table" align="center" x:publishsource="Excel">
                    <tabs @onPushParams="closeTabsModal()" :calcKpodTrigger="calcKpodTrigger"></tabs>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper" name="modal-prs" draggable=".modal-bign-header" :width="1263" :height="612"
                     style="background: transparent;" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">{{ trans('pgno.istoria_remontov') }} {{ wellNumber }}</div>

                    <button type="button" class="modal-bign-button" @click="closeModal('modal-prs')">
                      {{ trans('pgno.zakrit') }}
                    </button>
                  </div>

                  <div class="Table" align="center" x:publishsource="Excel">
                    <prs-crs :wellNumber="wellNumber" :field="field"></prs-crs>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper" name="analysisMenu" draggable=".modal-bign-header" :width="1080"
                     :height="450" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      {{ trans('pgno.analis_potenciala') }} {{ wellNumber }}
                    </div>

                    <div class="download-button-excel">
                      <div class="dropdown">
                        <button class="download-curve-button" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <img class="bottom-arrow-curve" src="/img/gno/download.svg" alt="">
                          {{ trans('pgno.download') }}
                          <img src="/img/gno/bottom-arrow.svg" alt="">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#" @click="takePhotoOldNewWell()">Photo</a>
                          <a class="dropdown-item" href="#" @click="downloadExcel('analysis')">MS Excel</a>
                        </div>
                      </div>
                    </div>
                    <button type="button" class="modal-bign-button" @click="closeModal('analysisMenu')">
                      {{ trans('pgno.zakrit') }}
                    </button>
                  </div>
                  <pgno-analysis @clicked="closeAnalysisModal"></pgno-analysis>
                </div>
              </modal>

              <modal class="" name="modalNearWells" draggable=".modal-bign-header" :width="1150" :height="450" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      {{ trans('pgno.analis_potenciala') }}
                    </div>
                    <button type="button" class="modal-bign-button" @click="closeModal('modalNearWells')">
                      {{ trans('pgno.zakrit') }}
                    </button>
                  </div>
                  <near-wells-table></near-wells-table>
                </div>
              </modal>


              <modal class="modal-bign-wrapper chart" name="modalExpAnalysis" draggable=".modal-bign-header" :width="1300"
                     :height="550" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <button type="button" class="modal-bign-button" @click="closeModal('modalExpAnalysis')">
                      {{ trans('pgno.zakrit') }}
                    </button>
                  </div>
                  <div class="nno-graph">
                    <economic :data="expAnalysisData"></economic>
                  </div>
                  <div class="nno-modal-button-wrapper">
                    <div class="nno-modal-buttons-container">
                      <div class="nno-icon" @click="openEcoTableModal()">
                        <img src="/img/gno/info.svg" alt="">
                      </div>

                      <button class="button-nno" @click="closeEcoModal()">
                        {{ trans('pgno.sposob_exp_npv') }}
                      </button>
                    </div>
                  </div>
                </div>
              </modal>

              <modal class="modal-bign-wrapper chart" draggable=".modal-bign-header" name="tablePGNO" :width="500" :height="550"
                     :adaptive="true">
                <div class="modal-bign modal-bign-container no-padding">
                  <div class="modal-bign-header with-padding">
                    <div class="modal-bign-title">
                      {{ trans('pgno.informacia') }}
                      <button class="download-curve-button economic-table" @click="downloadEconomicExcel()"
                              type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false">
                        <img src="/img/gno/download.svg" alt="">
                        {{ trans('pgno.download') }}
                      </button>
                    </div>
                    <button type="button" class="modal-bign-button" @click="closeEcoTableModal()">
                      {{ trans('pgno.zakrit') }}
                    </button>
                  </div>
                  <economic-table></economic-table>
                </div>
              </modal>

              <modal name="paramSep" draggable=".modal-bign-header" :width="1150" :height="400" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      {{ trans('pgno.analis_potenciala') }}
                    </div>
                    <button type="button" class="modal-bign-button" @click="closeModal('modalNearWells')">
                      {{ trans('pgno.zakrit') }}
                    </button>
                  </div>
                </div>
              </modal>

              <modal name="sensitiveSettings" draggable=".modal-bign-header" :width="800" :height="266" :adaptive="true">
                <div class="modal-bign modal-bign-container no-overflow">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      {{ trans('pgno.sensitivity_analysis') }}
                    </div>
                    <button type="button" class="modal-bign-button" @click="closeModal('sensitiveSettings')">
                      {{ trans('pgno.zakrit') }}
                    </button>
                  </div>
                  <pgno-sensitive-settings @clicked="openSensitiveResult"></pgno-sensitive-settings>
                </div>
              </modal>

              <modal class="modal-bign-wrapper" name="sensitiveResult" draggable=".modal-bign-header" :width="1300"
                     :height="500"
                     style="background: transparent;" :adaptive="true">
                <div class="modal-bign modal-bign-container">
                  <div class="modal-bign-header">
                    <div class="modal-bign-title">
                      {{ trans('pgno.sensitivity_analysis_result')}} {{wellNumber}}
                    </div>

                    <button type="button" class="modal-bign-button" @click="closeModal('sensitiveResult')">
                      {{ trans('pgno.zakrit') }}
                    </button>
                  </div>
                  <pgno-sensitive-result></pgno-sensitive-result>
                </div>
            </modal>


              <div class="gno-line-chart" v-if="isVisibleChart">
                <div class="flex pt-2">

                  <div class="gno-curve-table-title pl-4 pr-4 fg-0">
                    {{trans('pgno.krivaya_pritoka')}}
                  </div>

                  <div class="download-button-excel-1 fg-4 pl-0 pt-1 pr-4">
                    <button class="download-curve-button-plot" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                      <img src="/img/gno/download.svg" alt="">
                      {{ trans('pgno.download') }}
                      <img class="icon-inflow-curve" src="/img/gno/bottom-arrow.svg" alt="">
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#" @click="takePhoto()">Photo</a>
                      <a class="dropdown-item" href="#" @click="downloadExcel('main')">MS Excel</a>
                    </div>
                  </div>
                </div>
                  <div class="w-100">
                    <inflow-curve :updateCurveTrigger="updateCurveTrigger"></inflow-curve>
                  </div>
              </div>


              <div class="shgn-composition-wrapper" v-if="!isVisibleChart">
                <div class="gno-shgn-block-title">
                  {{ trans('pgno.komponovka_shgn') }}
                </div>
                <div class="download-button-excel-gno">
                  <div class="dropdown">
                    <button class="download-curve-button" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                      <img src="/img/gno/download.svg" alt="">
                      {{ trans('pgno.download') }}
                      <img src="/img/gno/bottom-arrow.svg" alt="">
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#" @click="downloadExcel('gno')">MS Excel</a>
                    </div>
                  </div>
                </div>
                <div class="composition-shgn-block">
                  <div class="image-rods-data col-3 pl-0 pr-0">
                    <div class="d-flex block-shgn mr-3 w-170">
                      <div class="flex-grow-1">
                        {{ trans('pgno.eks_kolonna') }} {{well.casOd}} {{ trans('measurements.mm') }}
                      </div>
                      <div class="flex-grow-1">
                        {{ trans('pgno.nkt') }} {{shgnTubOD}} {{ trans('measurements.mm') }}
                      </div>
                      <div class="flex-grow-1">
                        {{ trans('pgno.shtangi') }} {{construction['Секция 1'][0]}}{{ trans('measurements.mm') }} 0-{{construction['Секция 1'][1]}} {{ trans('measurements.m') }}
                      </div>
                      <div class="flex-grow-1" v-if="shgnSettings.stupColumns === '2'">
                        {{ trans('pgno.shtangi') }} 
                        {{construction['Секция 2'][0]}} {{ trans('measurements.mm') }} 
                        {{construction['Секция 1'][1]}}-{{Number(construction['Секция 1'][1]) + Number(construction['Секция 2'][1])}} {{ trans('measurements.m') }}
                      </div>
                      <div class="flex-grow-1" v-if="shgnSettings.heavyDown === true">
                        {{ trans('pgno.tn') }} {{construction['ТН'][0]}} {{ trans('measurements.mm') }}
                        {{Number(construction['Секция 1'][1]) + Number(construction['Секция 2'][1])}}-{{curveSettings.hPumpValue}} {{ trans('measurements.m') }}
                      </div>
                      <div class="flex-grow-1">
                        {{ trans('pgno.nasos') }} {{shgnPumpType}} {{ trans('measurements.mm') }}
                      </div>
                      <div class="flex-grow-1">
                        {{ trans('pgno.h_spuska') }} {{curveSettings.hPumpValue}} {{ trans('measurements.m') }}
                      </div>
                      <div class="flex-grow-1" v-if="curveSettings.mechanicalSeparation">
                        {{ trans('pgno.yagp') }}
                      </div>
                      <div class="flex-grow-1" v-if="shgnSettings.komponovka.includes('yakor')">
                        {{ trans('pgno.yakor_truboderzhatel') }}
                      </div>
                      <template v-if="shgnSettings.komponovka.includes('hvostovik') || shgnSettings.komponovka.includes('paker')">
                        <div class="flex-grow-1">
                          {{ trans('pgno.hvostovik') }}
                        </div>
                        <div class="flex-grow-1" v-if="shgnSettings.komponovka.includes('paker')">
                          {{ trans('pgno.paker_no_tail') }}
                        </div>
                      </template>


                      <div class="flex-grow-1">
                        {{ trans('pgno.interval_perf') }} <br> {{well.hUpPerfVd}} - {{Number(well.hUpPerfVd) + Number(well.hPerf)}} {{ trans('measurements.mm') }}
                      </div>
                      <div class="flex-grow-1">
                        {{ trans('pgno.tekushii_zaboi') }} {{well.currBh}} {{ trans('measurements.m') }}
                      </div>
                    </div>

                    <div class="d-flex">
                      <shgn-img></shgn-img>
                    </div>
                  </div>


                  <div class="table-pgno-button gno-shgn-table-section col-9">
                    <div class="shgn-tables-wrapper">
                      <div class="shgn-table-pgno-one shgn-table-item">
                        <table class="shgn-table-small">
                          <tr style="color: white;">
                            <th class="shgn-table-th" rowspan="1" colspan="2">{{ trans('pgno.raschetnii_rezhim') }}</th>
                          </tr>
                          <tr>
                            <td class="shgn-table-td">{{ trans('pgno.q_liq') }}</td>
                            <td class="shgn-table-td">{{ curveSettings.qlTargetValue }} {{trans('measurements.m3/day')}}</td>
                          </tr>
                          <tr class="highlight-tr">
                            <td class="shgn-table-td">{{ trans('pgno.q_nefti') }}</td>
                            <td class="shgn-table-td">{{ qoilShgnTable }} {{ trans('measurements.t/d') }}</td>
                          </tr>
                          <tr>
                            <td class="shgn-table-td">{{ trans('pgno.obvodnenost') }}</td>
                            <td class="shgn-table-td">{{ curveSettings.wctInput }} %</td>
                          </tr>
                          <tr class="highlight-tr">
                            <td class="shgn-table-td">{{ trans('pgno.p_zab') }}</td>
                            <td class="shgn-table-td">{{ curveSettings.bhpTargetValue }} {{trans('measurements.atm')}}</td>
                          </tr>
                          <tr>
                            <td class="shgn-table-td">{{ trans('pgno.p_pr') }}</td>
                            <td class="shgn-table-td">{{ curveSettings.pintakeTargetValue }} {{trans('measurements.atm')}}</td>
                          </tr>
                          <tr class="highlight-tr">
                            <td class="shgn-table-td">{{ trans('measurements.percent') }}
                              {{ trans('pgno.gas_in_pump') }}
                            </td>
                            <td class="shgn-table-td">{{ points.freegasCelValue.toFixed(1) }}</td>
                          </tr>
                        </table>
                      </div>

                      <div class="shgn-table-pgno-two shgn-table-item">
                        <table class="shgn-table-small">
                          <tr style="color: white;">
                            <th class="shgn-table-th" rowspan="1" colspan="2">{{ trans('pgno.komponovka') }}</th>
                          </tr>
                          <tr>
                            <td class="shgn-table-td">Ø {{ trans('pgno.nasosa') }}</td>
                            <td class="shgn-table-td">{{ shgnPumpType }} {{ trans('measurements.mm') }}</td>
                          </tr>
                          <tr class="highlight-tr">
                            <td class="shgn-table-td">{{ trans('pgno.chislo_kachanii') }}</td>
                            <td class="shgn-table-td">{{ shgnSPM }} {{ trans('measurements.min-1') }}</td>
                          </tr>
                          <tr>
                            <td class="shgn-table-td">{{ trans('pgno.dlina_hoda') }}</td>
                            <td class="shgn-table-td">{{ shgnLen }} {{ trans('measurements.m') }}</td>
                          </tr>
                          <tr class="highlight-tr">
                            <td class="shgn-table-td">Ø {{ trans('pgno.nkt') }}</td>
                            <td class="shgn-table-td">{{ shgnTubOD }} {{ trans('measurements.mm') }}</td>
                          </tr>
                          <tr>
                            <td class="shgn-table-td">{{ trans('pgno.h_spuska') }}</td>
                            <td class="shgn-table-td">{{ curveSettings.hPumpValue }} {{ trans('measurements.m') }}</td>
                          </tr>
                          <tr class="highlight-tr">
                            <td class="shgn-table-td">{{ kPodText }}</td>
                            <td class="shgn-table-td">{{ kPod }}</td>
                          </tr>
                        </table>
                      </div>


                      <div class="shgn-table-pgno-four shgn-table-item">
                        <table class="shgn-table-small">
                          <tr style="color: white;">
                            <td class="shgn-table-td bg-td">{{ trans('pgno.sk') }}</td>
                            <td class="shgn-table-td bg-td">{{ trans('pgno.p_max') }}, {{ trans('measurements.kN') }}
                            </td>
                            <td class="shgn-table-td bg-td">{{ trans('pgno.mkr') }}, {{ trans('measurements.kN') }}</td>
                            <td class="shgn-table-td bg-td">{{ trans('pgno.power_consumption_short') }},
                              {{ trans('measurements.kv') }}
                            </td>
                            <td class="shgn-table-td bg-td">{{ trans('pgno.daily_consumption') }},
                              {{ trans('measurements.kvh') }}
                            </td>
                            <td class="shgn-table-td bg-td">{{ trans('pgno.ure') }},
                              {{ trans('measurements.kvh/m3') }}
                            </td>
                          </tr>
                          <tr>
                            <td class="shgn-table-td">{{ skType }}</td>
                            <td class="shgn-table-td">{{ skPmax }}</td>
                            <td class="shgn-table-td">{{ skMn2 }}</td>
                            <td class="shgn-table-td">{{ pElectricity }}</td>
                            <td class="shgn-table-td">{{ wDay }}</td>
                            <td class="shgn-table-td">{{ ure }}</td>
                          </tr>
                        </table>
                      </div>

                      <div class="shgn-table-pgno-three shgn-table-item">
                        <table class="shgn-table-large">
                          <tr style="color: white;">
                            <th class="shgn-table-th fixed-table-td">{{ trans('pgno.kolonna_shtang') }}</th>
                            <th class="shgn-table-th large-th">{{ trans('pgno.mark_steel') }}</th>
                            <th class="shgn-table-th fixed-table-td">Ø, {{ trans('measurements.mm') }}</th>
                            <th class="shgn-table-th fixed-table-td">{{ trans('pgno.dlina') }},
                              {{ trans('measurements.m') }}
                            </th>
                            <th class="shgn-table-th fixed-table-td">{{ trans('pgno.stem') }},
                              {{ trans('measurements.unit') }}
                            </th>
                            <th class="shgn-table-th fixed-table-td">
                              {{ trans('pgno.zagruzka') }},{{ trans('measurements.percent') }}
                            </th>
                            <th class="shgn-table-th fixed-table-td">{{ trans('pgno.p_max') }},
                              {{ trans('measurements.kN') }}
                            </th>
                            <th class="shgn-table-th fixed-table-td">
                              {{ trans('pgno.p_min') }},{{ trans('measurements.kN') }}
                            </th>
                          </tr>
                          <tr v-for="(row_index, row) in construction">
                            <td class="shgn-table-td fixed-table-td">{{ row }}</td>
                            <td class="shgn-table-td large__th">{{ steel }}</td>
                            <td class="shgn-table-td fixed-table-td">{{ row_index[0] }}</td>
                            <td class="shgn-table-td fixed-table-td">{{ row_index[1] }}</td>
                            <td class="shgn-table-td fixed-table-td">{{ row_index[2] }}</td>
                            <td class="shgn-table-td fixed-table-td">{{ row_index[3] }}</td>
                            <td class="shgn-table-td fixed-table-td">{{ row_index[4] }}</td>
                            <td class="shgn-table-td fixed-table-td">{{ row_index[5] }}</td>
                          </tr>
                        </table>
                      </div>
                    </div>

                    <div class="сentralizers-block">
                      <h6 class="main-title-centralizers"><b>{{ trans('pgno.interval_centrators') }}:</b></h6>
                      <h6 class="centralizers-title">{{ centratorsType }}:
                        <b v-for="item in centratorsRequiredValue">{{ item }}</b></h6>
                    </div>
                    <button class="button-pdf col-12" >
                      {{ trans('pgno.sozdanie_otcheta') }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="no-gutter col-md-12 first-column-params-block container">
            <div class="col-md-12">
              <div class="inflow-curve-wrapper">
                <!--Начало Настроек кривой притока-->
                <div class="col-6 px-2 curve-settings inflow-configuration-min-width">
                  <div class="bottom-configuration-header">
                    {{ trans('pgno.nastroika_krivoy_pritoka') }}
                  </div>
                  <div class="inflow-configuration">
                    <div class="row pl-3">
                      <div class="col-7">
                        <div class="row">
                          <div class="col-2 px-0 pt-1 min-w-block">
                            <div class="right-border-line py-1 label-pl">
                              {{ trans('pgno.p_pl') }}
                            </div>
                          </div>
                          <div class="input-inflow-configuration">
                            <div class="py-1">
                              <input v-model="curveSettings.pResInput" @change="postCurveData()"
                                     onfocus="this.value=''"
                                     type="text" class="curve-settings-input"/>
                            </div>
                          </div>
                          <div class="label-measurements-1">{{trans('measurements.atm')}}</div>

                        </div>
                      </div>
                      <div class="col-2 px-0 pt-2 pb-0">
                        <div class="right-border-line ic-ar pt-1">
                          {{ trans('pgno.obvodnenost') }}
                        </div>
                      </div>
                      <div class="input-inflow-configuration">
                        <div class="py-1">
                          <input v-model="curveSettings.wctInput" @change="postCurveData()" type="text"
                                 onfocus="this.value=''" class="curve-settings-input"/>
                        </div>
                      </div>
                      <div class="label-measurements-1">%</div>
                    </div>
                    <div class="top-border-line">
                      <div class="row pl-3">
                        <div class="col-7">
                          <div class="row">
                            <div class="col-2 px-0 min-w-block">
                              <div class="right-border-line py-1">
                                <label>
                                  <input v-model="curveSelect"
                                         class="curve-select-option" value="pi"
                                         type="radio"
                                         name="set" @change="postCurveData()"/>
                                  {{ trans('pgno.k_prod') }}
                                </label>
                              </div>
                            </div>
                            <div class="input-inflow-configuration">
                              <input v-model="curveSettings.piInput"
                                     :disabled="curveSelect != 'pi'" @change="postCurveData()"
                                     onfocus="this.value=''" type="text" class="curve-settings-input"/>
                            </div>
                            <div class="label-measurements">{{trans('measurements.m3/d/atm')}}</div>
                          </div>
                        </div>
                        <div class="col-2 px-0">
                          <div class="right-border-line ic-ar pt-1">
                            {{ trans('pgno.gf_s') }}
                          </div>
                        </div>
                        <div class="input-inflow-configuration">
                          <input v-model="curveSettings.gorInput" @change="postCurveData()" type="text"
                                 onfocus="this.value=''" class="curve-settings-input"/>
                        </div>
                        <div class="label-measurements">{{trans('measurements.m3/t')}}</div>
                      </div>

                    </div>
                    <div class="top-border-line">
                      <div class="row ic-bottom-row  pl-3">
                        <div class="col-7">
                          <div class="row">
                            <div class="col-2 px-0 min-w-block">
                              <div class="right-border-line py-1">
                                <label>
                                  <input v-model="curveQselect"
                                         class="curve-select-option"
                                         value="hdyn"
                                         type="radio" @change="postCurveData()"
                                         name="set"/>
                                  {{ trans('pgno.q_liq') }}</label>
                              </div>
                            </div>
                            <div class="input-inflow-configuration">
                              <input :disabled="curveSelect == 'pi'"
                                     v-model="curveSettings.qLInput" @change="postCurveData()"
                                     onfocus="this.value=''" type="text" class="curve-settings-input"/>
                            </div>
                            <div class="label-measurements">{{trans('measurements.m3/day')}}</div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="top-border-line no-margin row">
                      <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                        <div class="col-5 right-border-line gno-curve-radio-cell pt-1 pb-1">
                          <label for="" class="text-ellipsis">
                            <input v-model="curveSelect" value="bhp"
                                   :disabled="curveSelect == 'pi'"
                                   class="curve-select-option" type="radio" @change="postCurveData()" name="set2"/>
                            {{ trans('pgno.p_zab') }}</label>
                        </div>
                        <div class="input-inflow-configuration">
                          <input :disabled="curveSelect != 'bhp'" v-model="curveSettings.bhpInput"
                                 @change="postCurveData()"
                                 onfocus="this.value=''" type="text" class="curve-settings-input"/>
                        </div>
                        <div class="label-measurements">{{trans('measurements.atm')}}</div>
                      </div>
                    </div>

                    <div class="top-border-line no-margin row">
                      <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                        <div class="col-5 right-border-line gno-curve-radio-cell pt-1 pb-1">
                          <label>
                            <input v-model="curveSelect"
                                   value="hdyn"
                                   type="radio"
                                   :disabled="curveSelect == 'pi'"
                                   class="curve-select-option"
                                   @change="postCurveData()" name="set2"/>
                            {{ trans('pgno.h_dyn') }}</label>
                        </div>
                        <div class="input-inflow-configuration">
                          <input :disabled="curveSelect != 'hdyn'"
                                 v-model="curveSettings.hDynInput" @change="postCurveData()"
                                 type="text" onfocus="this.value=''" class="curve-settings-input"/>
                        </div>
                        <div class="label-measurements">{{trans('measurements.m')}}</div>
                      </div>

                      <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                        <div class="col-6 right-border-line left-border-line pt-1 pb-1">
                          <div class="table-border-gno-left ml-n15px label-pl">
                            {{ trans('pgno.p_zat') }}
                          </div>
                        </div>
                        <div class="input-inflow-configuration">
                          <input :disabled="curveSelect != 'hdyn'"
                                 v-model="curveSettings.pAnnularInput"
                                 @change="postCurveData()" type="text"
                                 onfocus="this.value=''" class="curve-settings-input"/>
                        </div>
                        <div class="label-measurements">{{trans('measurements.atm')}}</div>
                      </div>
                    </div>

                    <div class="top-border-line no-margin row">
                      <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                        <div class="col-5 right-border-line pt-1 pb-1">
                          <label class="text-ellipsis">
                            <input v-model="curveSelect" value="pmanom"
                                   :disabled="curveSelect == 'pi'"
                                   class="curve-select-option" type="radio"
                                   @change="postCurveData()" name="set2"/>
                            {{ trans('pgno.p_manom') }}</label>
                        </div>
                        <div class="input-inflow-configuration">
                          <input :disabled="curveSelect != 'pmanom'"
                                 v-model="curveSettings.pManomInput"
                                 @change="postCurveData()" type="text"
                                 onfocus="this.value=''" class="curve-settings-input"/>
                        </div>
                        <div class="label-measurements">{{trans('measurements.atm')}}</div>
                      </div>

                      <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                        <div class="col-6 right-border-line left-border-line pt-1 pb-1">
                          <div class="tech-data curve text-ellipsis">
                            {{ trans('pgno.h_sp_manom') }}
                          </div>
                        </div>
                        <div class="input-inflow-configuration">
                          <input :disabled="curveSelect != 'pmanom'"
                                 v-model="curveSettings.hPumpManomInput"
                                 @change="postCurveData()" type="text"
                                 onfocus="this.value=''" class="curve-settings-input"/>
                        </div>
                        <div class="label-measurements">{{trans('measurements.m')}}</div>
                      </div>
                    </div>

                    <div class="top-border-line no-margin row">
                      <div class="col-sm-6 col-xs-12 no-margin no-padding row">
                        <div class="col-5 right-border-line gno-curve-radio-cell pt-1 pb-1">
                          <label for="" class="text-ellipsis">
                            <input v-model="curveSelect" value="whp"
                                   :disabled="curveSelect == 'pi'"
                                   class="curve-select-option" type="radio"
                                   @change="postCurveData()" name="set2"/>
                            {{ trans('pgno.p_buf') }}</label>
                        </div>
                        <div class="input-inflow-configuration">
                          <input :disabled="curveSelect != 'whp'" v-model="curveSettings.whpInput"
                                 @change="postCurveData()"
                                 type="text" onfocus="this.value=''" class="curve-settings-input"/>
                        </div>
                        <div class="label-measurements">{{trans('measurements.atm')}}</div>

                      </div>
                    </div>
                  </div>

                  <div class="potential-analysis-button col-12" @click="openAnalysisModal()">
                    {{ trans('pgno.analis_potenciala_skvazhini') }}
                  </div>
                </div>
                <!--Конец настроек кривой притока-->

                <!--Начало Параметров побора-->
                <div class="col-6 px-2 choice-params">
                  <div class="bottom-configuration-header">
                    {{ trans('pgno.parametry_podbora') }}
                  </div>
                  <div class="select-params">
                    <!--selection pararms begin -->
                    <div class="selection-params row pt-0">
                          <div class="col-2">
                            <label class="fs-16 mb-0 pt-2">
                              <input class="curve-select-option" value="ШГН"
                                     v-model="curveSettings.expChoosen" @change="postCurveData()"
                                     :checked="curveSettings.expChoosen === 'ШГН'" type="radio"
                                     name="gno10"/>{{ trans('pgno.shgn') }}
                            </label>
                          </div>
                          <div class="col-2">
                            <label class="fs-16 mb-0 pt-2">
                              <input class="curve-select-option" value="ЭЦН"
                                     v-model="curveSettings.expChoosen" @change="postCurveData()"
                                     :checked="curveSettings.expChoosen === 'ЭЦН'" type="radio"
                                     name="gno10"/>{{ trans('pgno.ecn') }}</label>
                          </div>
                          <div class="col-2">
                            <label class="fs-16 mb-0 pt-2">
                            <input class="curve-select-option" value="ФОН"
                                   v-model="curveSettings.expChoosen" @change="postCurveData()"
                                   :checked="curveSettings.expChoosen === 'ФОН'" type="radio"
                                   name="gno10"/>{{ trans('pgno.fon') }}</label>
                          </div>
                          <div class="col-2">
                            <label class="pt-10px">{{ trans('pgno.p_buf') }}</label>
                          </div>
                          <div class="col-2">
                            <label class="pt-10px">Ø{{ trans('pgno.nkt') }}</label>
                          </div>
                          <div class="col-2">
                            <label class="pt-10px">{{ trans('pgno.h_spuska') }}</label>
                          </div>
                      <div class="gear-icon" @click="openTabsModal()">
                        <img class="gear-icon-svg" src="/img/gno/gear-icon.svg" alt="">
                      </div>
                    </div>

                    <div class="selection-params row pt-0">
                      <div class="col-6">
                        <div class="title-sep" style="padding-top: 5px;">
                          {{ trans('pgno.total_separation') }}
                        </div>
                      </div>
                      <div class="col-2 pl-0 pr-0">
                        <input type="text" v-model="curveSettings.pBuff" onfocus="this.value=''" @change="postCurveData()"
                               class="input-selection-options pl-1"/> {{trans('measurements.atm')}}
                      </div>
                      <div class="col-2 pl-0 pr-0">
                        <select class="input-selection-options w-62" v-model="curveSettings.nkt"
                                @change="postCurveData()">
                          <option v-for="(nkts, index) in nkt_choose" :value="nkts.for_calc_value" :key="index">
                            {{ nkts.show_value }}
                          </option>
                        </select> {{trans('measurements.mm')}}
                      </div>
                      <div class="col-2 pl-0 pr-0">
                        <input v-model="curveSettings.hPumpValue" @change="postCurveData()" type="text"
                               onfocus="this.value=''"
                               class="input-selection-options pl-1"/> {{trans('measurements.m')}}
                      </div>
                    </div>
                    <!--selection params end-->

                    <div class="row">
                      <div class="col-4 pt-1">
                        <label class="curve-selection-label">
                          <input value="calc_value" v-model="curveSettings.separationMethod"
                                 @change="postCurveData()" class="checkbox34" checked="true" type="radio"
                                 name="gno20" :disabled="curveSettings.expChoosen === 'ФОН'"/>
                          {{ trans('pgno.separation_calc') }}
                        </label>
                      </div>
                      <div class="col-8 left-border-line pl-5px">
                        <input class="mr-5px" v-model="curveSettings.naturalSeparation" @change="postCurveData()"
                               type="checkbox" checked="true"
                               :disabled="curveSettings.separationMethod ==='input_value' || curveSettings.expChoosen === 'ФОН'">{{
                          trans('pgno.separation_nat')
                        }}
                      </div>

                    </div>

                    <div class="row">

                      <div class="col-4 pt-1">
                        <label>
                          <input class="checkbox3" v-model="curveSettings.separationMethod"
                                 @change="postCurveData()" value="input_value" checked="true" type="radio"
                                 name="gno20" :disabled="curveSettings.expChoosen === 'ФОН'"/>
                          <input v-model="curveSettings.es" @change="postCurveData()" type="text"
                                 onfocus="this.value=''" class="sep-input"
                                 :disabled="curveSettings.expChoosen === 'ФОН' ||
                                 curveSettings.separationMethod !='input_value'"/>
                        </label>
                        {{trans('measurements.percent')}}
                      </div>

                      <div class="col-8 left-border-line pl-5px">
                        <input class="mr-5px" checked="true" @change="postCurveData()"
                               :disabled="curveSettings.separationMethod ==='input_value' || curveSettings.expChoosen === 'ФОН'"
                               type="checkbox"
                               v-model="curveSettings.mechanicalSeparation">{{ trans('pgno.separation_mech') }}
                        <input v-model="curveSettings.mechanicalSeparationValue" @change="postCurveData()"
                               type="text" style="margin-left: 3px; margin-bottom: 0px;"
                               :disabled="curveSettings.separationMethod ==='input_value' || curveSettings.expChoosen === 'ФОН' ||  curveSettings.mechanicalSeparation === false"
                               onfocus="this.value=''" class="sep-input"/>
                        {{trans('measurements.percent')}}
                      </div>
                    </div>


                    <div class="top-border-line pb-0" >
                      <div class="row">
                        <div class="col-4 pr-0">
                          <div class="podbor-bottom-title-line ">
                            {{ trans('pgno.celevoi_parametr') }}
                          </div>
                        </div>
                        <div class="col-4 pr-0 left-border-line">
                          <div class="podbor-bottom-title-line">
                            &nbsp;
                          </div>
                        </div>
                        <div class="col-4 pr-0 left-border-line">
                          <div class="podbor-bottom-title-line">
                            &nbsp;
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-4 pr-0">
                        <div class="pdo-bottom-cell pt-3">
                          <label>
                            <input v-model="curveSettings.targetButton" class="curve-select-option" value="ql"
                                   type="radio"
                                   name="gno11"/>{{ trans('pgno.q_liq') }}</label>
                          <input v-model="curveSettings.qlTargetValue" @change="postCurveData()"
                                 :disabled="curveSettings.targetButton != 'ql'"
                                 onfocus="this.value=''" type="text" class="curve-settings-input"/>
                          {{trans('measurements.m3/day')}}
                        </div>
                      </div>
                      <div class="left-border-line col-4 pr-0 pt-3">
                        <div class="pdo-bottom-cell">
                          <label>
                            <input v-model="curveSettings.targetButton" class="curve-select-option"
                                   value="bhp" type="radio" name="gno11"/>{{ trans('pgno.p_zab') }}
                          </label>

                          <input v-model="curveSettings.bhpTargetValue" @change="postCurveData()"
                                 :disabled="curveSettings.targetButton != 'bhp'"
                                 type="text" onfocus="this.value=''" class="curve-settings-input"/>
                          {{trans('measurements.atm')}}
                        </div>
                      </div>
                      <div class="left-border-line col-4 pdo-bottom-cell pt-3">
                        <label class="curve-selection-label">
                          <input v-model="curveSettings.targetButton" class="curve-select-option" value="pin" type="radio"
                                 :disabled="curveSettings.expChoosen === 'ФОН'"
                                 name="gno11"/>{{ trans('pgno.p_pr') }}
                        </label>
                        <input v-model="curveSettings.pintakeTargetValue" @change="postCurveData()"
                               :disabled="curveSettings.targetButton != 'pin' || curveSettings.expChoosen === 'ФОН'"
                               type="text" onfocus="this.value=''" class="curve-settings-input"/>
                        {{trans('measurements.atm')}}
                      </div>
                    </div>
                  </div>

                  <div class="way-of-operation-button col-12" @click="openEcoModal()">
                    {{ trans('pgno.analis_effect_sposoba_exp') }}
                  </div>
                </div>
                <!--Конец параметров подбора-->
                <div class="col-12 px-2 gno-main-green-button">
                  <div v-if="curveSettings.expChoosen!=='ФОН'" class="podbor-gno-button col-12" @click="onPgnoClick()">
                    {{ isVisibleChart ? podborGnoTitle : inflowCurveTitle }}
                  </div>
                  <div v-if="curveSettings.expChoosen==='ФОН'" class="podbor-gno-button col-12" @click="openSensAnalysisModal()">
                    {{ curveSettings.expChoosen==='ФОН' ? "Анализ чувствительности" : inflowCurveTitle }}
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>
<script src="./GnoMain.js"></script>
