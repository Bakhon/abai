<template>
  <div>
    <div class="block-shadow" v-if="showShadow" @click="closeTree()"></div>
    <div class="row mx-0 mt-lg-2 gtm main-block-gtm">
      <div class="col-lg-9 lg-border-block">
        <div class="row col-12 p-0 m-0">
          <div :class="!isMinimize ? 'col-6 d-none d-lg-block p-0' : 'maximize-block d-none d-lg-block p-0'">
            <div class="gtm-dark h-100">
              <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
                <div>
                  {{ this.trans("paegtm.wells-candidates") }}
                </div>
                <div class="d-flex">
                  <div class="pr-3 pb-1">
                    <img src="/img/GTM/download.svg" alt="">
                  </div>
                  <div class="pr-3 pb-1">
                    <img src="/img/GTM/full-screen.svg" alt="">
                  </div>
                </div>
              </div>
              <div class="p-0 pl-0 table-pgtm">
                <div v-if="!clickableTable.data">
                  <div class="border-block-out">
                    <div class="border-block-in">
                      <div class="p-3 empty-data-title">
                        {{ this.trans("paegtm.calc-empty-well") }}
                      </div>
                    </div>
                  </div>
                </div>
                <div v-else>
                  <div class="border-block-out">
                    <div class="border-block-in">
                      <table class="table text-center text-white podbor-middle-table">
                        <thead class="thead" :class="isMinimize">
                        <tr>
                          <th class="th" v-for="(row, idx) in clickableTable.header" :key="idx"
                              :colspan="Array.isArray(row) ? row.length : ''"
                              :rowspan="Array.isArray(row) ? '' : 2"
                          >
                            {{ idx }}
                          </th>
                        </tr>
                        <tr>
                          <template v-for="(row) in clickableTable.header">
                            <template v-if="Array.isArray(row)">
                              <th class="th" v-for="r in row">
                                {{ r }}
                              </th>
                            </template>
                          </template>
                        </tr>
                        </thead>
                        <tbody>
                        <tr  v-for="(c, idx) in clickableTable.data" @click="onClickWell(c[0])" :key="idx">
                          <th>{{ idx * 1 + 1 }}</th>
                          <th class="bg-body" v-for="row in c">{{ row }}</th>
                        </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div v-if="isMinimize" class="pl-1 d-block" @click="onMinimizeChart()">
            <div class="pb-1">
              <img src="/img/GTM/minimize.svg" alt="">
            </div>
            <div class="pb-1 gtm-dark minimized-block">
              <div class="minimized-title">
                {{ this.trans("paegtm.current_qualifiers_map") }}
              </div>
            </div>
          </div>

          <div v-else class="col-6 d-none d-lg-block p-0 pl-1">
            <div class="gtm-dark h-100">
              <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
                <div>
                  {{ this.trans("paegtm.current_qualifiers_map") }}
                </div>
                <div class="d-flex">
                  <div class="pr-3">
                    <img src="/img/GTM/download.svg" alt="">
                  </div>
                  <div class="pr-3">
                    <img src="/img/GTM/full-screen.svg" alt="">
                  </div>
                  <div class="pr-3 pb-1" @click="onMinimizeChart()">
                    <img src="/img/GTM/maximize.svg" alt="">
                  </div>
                </div>
              </div>
              <div class="border-block-out">
                <div class="border-block-in">
                  <div class="p-3">
                    <img src="/img/GTM/map.svg" class="gtm-map-img img-fluid">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row col-12 p-0 m-0 pt-1">
          <div v-if="lineChartSeries === null" class="col-6 d-none d-lg-block p-0">
            <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
              <div>
                {{ this.trans("paegtm.well") }}
              </div>
              <div class="d-flex">
                <div class="pr-3 pb-1">
                  <img src="/img/GTM/download.svg" alt="">
                </div>
                <div class="pr-3 pb-1">
                  <img src="/img/GTM/full-screen.svg" alt="">
                </div>
              </div>
            </div>
            <div class="border-block-out">
              <div class="border-block-in">
                <div class="p-3 gtm-dark empty-data-title">
                  {{ this.trans("paegtm.empty-well-chart") }}
                </div>
              </div>
            </div>
          </div>

          <div v-else class="col-6 d-none d-lg-block p-0 pt-1">
            <div class="gtm-dark h-100">
              <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
                <div>
                  {{ this.trans("paegtm.well") }} {{ wellNumber }}
                </div>

                <div class="d-flex">
                  <div class="pr-3 pb-1">
                    <img src="/img/GTM/download.svg" alt="">
                  </div>
                  <div class="pr-3">
                    <img src="/img/GTM/maximize.svg" alt="">
                  </div>
                </div>
              </div>
              <div class="border-block-out">
                <div class="border-block-in">
                  <apexchart
                      :height="365"
                      :options="lineChartOptions"
                      :series="lineChartSeries"
                  ></apexchart>
                </div>
              </div>
            </div>
          </div>

          <div v-if="waterFallChartSeries === null" class="col-6 d-none d-lg-block p-0 pl-1">
            <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
              <div>
                {{ this.trans("paegtm.factor_analyse") }}
              </div>
              <div class="d-flex">
                <div class="pr-3 pb-1">
                  <img src="/img/GTM/download.svg" alt="">
                </div>
                <div class="pr-3 pb-1">
                  <img src="/img/GTM/full-screen.svg" alt="">
                </div>
              </div>
            </div>
            <div class="border-block-out">
              <div class="border-block-in">
                <div class="p-3 gtm-dark empty-data-title">
                  {{ this.trans("paegtm.empty-well-chart") }}
                </div>
              </div>
            </div>
          </div>

          <div v-else class="col-6 d-none d-lg-block p-0 pt-1 pl-1">
            <div class="gtm-dark h-100">
              <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
                <div>
                  {{ this.trans("paegtm.factor_analyse") }}
                </div>

                <div class="d-flex">
                  <div class="pr-3 pb-1">
                    <img src="/img/GTM/download.svg" alt="">
                  </div>
                  <div class="pr-3">
                    <img src="/img/GTM/full-screen.svg" alt="">
                  </div>
                </div>
              </div>
              <div class="border-block-out">
                <div class="border-block-in">
                  <apexchart
                      :height="365"
                      :options="waterFallChartOptions"
                      :series="waterFallChartSeries"
                  ></apexchart>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
      <div class="col-lg-3 p-0 pl-2 pr-1 right-block">
        <div class="gtm-dark p-2">
          <div class="block-header pb-2 pt-1 d-flex">
            <div>
              {{ this.trans("paegtm.period") }}
            </div>
            <div v-if="isHidden" class="period-block">
              <div class="pl-1" style="font-weight: normal">
                <input class="mt-7px pl-1" type="checkbox" value="" v-model="dataRangeInfo.is_days_group">
                <label class="pl-1">Шаг</label>
                <input class="period-settings-input" type="number" v-model="dataRangeInfo.days" @input="onChangeDays($event)"/>
              </div>
            </div>

          </div>
          <div class="d-flex gap-10">
            <gtm-tree-date-picker class="flex-1"></gtm-tree-date-picker>
            <div class="d-flex calendar-filter-block show-block"  @click="onHideDays">
              <img class="gear-icon-svg" src="/img/GTM/gear.svg" alt="">
            </div>
          </div>
        </div>

        <div class="block-header gtm-dark">
          <div class="gtm-dark gtm-filter mt-2">
            <div class="gtm-select-block pb-12px pt-12px p-i-12px">
              <select class="select-well">
                <option class="select-well-option" value="" disabled selected>{{ this.trans('paegtm.select_dzo') }}</option>
              </select>
            </div>

            <div class="gtm-select-block pb-12px p-i-12px">
              <select class="select-well">
                <option class="select-well-option" value="" disabled selected>{{ this.trans('paegtm.select_oil_field') }}</option>
              </select>
            </div>

            <div class="gtm-select-block pb-12px  p-i-12px">
              <select class="select-well">
                <option class="select-well-option" value="" disabled selected>{{ this.trans('paegtm.select_object') }}</option>
              </select>
            </div>

            <div class="gtm-select-block pb-12px p-i-12px">
              <select class="select-well">
                <option class="select-well-option" value="" disabled selected>{{ this.trans('paegtm.select_structure') }}</option>
              </select>
            </div>

            <div class="gtm-select-block pb-12px p-i-12px">
              <select class="select-well">
                <option class="select-well-option" value="" disabled selected>{{ this.trans('paegtm.select_gu') }}</option>
              </select>
            </div>
          </div>
        </div>

        <div class="gtm-dark p-2 calc-button text-center" @click="onPostTreeData(treeData)">
          {{ trans("paegtm.calc") }}
        </div>

        <div class="gtm-dark p-2 gtm-tree">
          <div class="block-header p-2 d-flex">

            <div class="title-block-tree" @click="showBlock = 1">
              <img class="pr-10px" src="../img/potencial-icon.svg" alt="">
              {{ trans("paegtm.potentialSearch") }}
            </div>

            <img class="menu-item-arrow tabs-arrow m-2 my-auto" :src="showBlock === 1 ? menuArrowUp : menuArrowDown"
                 width="12" height="12" alt="">

          </div>
          <div class="table-border-gtm-top p-0" :class="{ 'display-none': showBlock === 2 }" @mouseover.native="onHoverTree()">
            <div class="position-absolute tree-setting-block d-flex">
              <keep-alive>
                <component v-bind:is="treeSettingComponent" class="gtm-dark table-border-gtm h-100"></component>
              </keep-alive>
              <keep-alive>
                <component v-bind:is="treeChildrenComponent" class="gtm-dark table-border-gtm ml-2 h-100"
                           @node-click="nodeClick"></component>
              </keep-alive>
            </div>
            <div class="gtm-dark">
              <gtm-tree
                  v-for="treeDataChild in treeData"
                  :treeData="treeDataChild"
                  :key="treeDataChild.name"
                  @node-click="nodeClick"
              ></gtm-tree>
            </div>
          </div>

        </div>
        <div class="gtm-dark p-2">
          <div class="block-header p-2 d-flex">
            <div @click="showBlock = 2">
              {{ trans("paegtm.nearWells") }}
            </div>
            <img class="menu-item-arrow tabs-arrow m-2 my-auto" :src="showBlock === 2 ? menuArrowUp : menuArrowDown"
                 width="12" height="12" alt="">
          </div>

          <div class="table-border-gtm-top p-0" :class="{ 'display-none': showBlock === 1 }">
            <div class="gtm-dark row m-0 p-2">
              <div class="col-1 text-right mt-1 mb-1 p-0">
                <img src="../img/lens.svg">
              </div>
              <div class="col-11 row p-0">
                <input class="search-input w-75" type="text" placeholder="Поиск по скважине">
                <button class="search-button pl-2 pr-2">{{ trans("paegtm.search") }}</button>
              </div>
              <div class="gtm-dark text-white h-221 pl-2">
                {{ trans("paegtm.all_wells") }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script src="./js/PodborGTM.js"></script>
<style scoped>
.h-221 {
  min-height: 221px;
}

.main-block-gtm {
  height: 100%;
  align-items: stretch;
}

.right-block {
  height: 100%;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.period-settings-input {
  width: 60px;
  height: 24px;
  background: rgba(31, 33, 66, 0.8);
  border: 1px solid #454FA1;
  border-radius: 4px;
  color: white;
  outline: none;
  padding-left: 5px;
}

.period-block {
  background-color: #41488b;
  border: 2px solid #545580;
  border-radius: 5px;
  color: white;
  width: 120px;
  height: 30px;
  font-size: 13px;
}

.lg-border-block {
  padding: 4px;
  border: 6px solid #272953;
}

.empty-data-title {
  color: white;
  text-align: center;
  font-size: 16px;
  padding-top: 20px;
}

.period-settings-input[type=number]::-webkit-inner-spin-button {
  opacity: 1;
  background-color: #323370;
}
.period-settings-input[type="number"]::-webkit-inner-spin-button,
.period-settings-input[type="number"]::-webkit-outer-spin-button {
  margin: 0;
  color: #0E9A00;
}

.border-color {
  background-color: #323370
}

.border-block-out {
  border: 8px solid #363B68;
}

.border-block-in {
  border: 8px solid #1A214A;
}

.table-pgtm {
  height: 400px;
  overflow: auto;
}

.p-3 {
  height: 384px !important;
}

.bg-body {
  background-color: #20274f;
  font-weight: normal;
}

.minimized-block {
  position: relative;
  height: 408px;
}

.minimized-title {
  transform: rotate(90deg);
  color: white;
  position: absolute;
  width: 205px;
  right: -93px;
  bottom: 176px;
}

.gap-10 {
  gap: 10px;
}

::-webkit-scrollbar {
  height: 10px;
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #272953;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}

.gtm-filter .v-select {
  margin-bottom: 15px;
}

.maximize-block {
  flex: 1;
}

.calc-button {
  background: #3366FF;
  border-radius: 8px;
  cursor: pointer;
  color: white;
  line-height: 2.5em;
  font-size: 17px;
}

.calc-button:active {
  background-color: #144079;
  box-shadow: 0 2px #666;
  transform: translateY(0.02px);
  filter: blur(0.3px);
}

.calc-button:hover {
  background-color: #484749;
}

.table {
  overflow-y: auto;
  height: 110px;
}

.table .thead .th {
  font-size: 11.5px;
  font-weight: normal;
}

.table {
  border-collapse: collapse;
  width: 100%;
}

.th {
  padding: 8px 15px;
  border: 2px solid #529432;
}

thead tr:nth-child(1) .th {
  position: sticky;
  top: -1px;
}

thead tr:nth-child(2) .th {
  position: sticky;
  top: 26px;
}

tr:last-child td {
  border-bottom: 1px solid #454d7d !important;
}

tr:nth-child(odd) td {
  background: rgba(69, 77, 125, 0.32) !important;
}

tr:nth-child(even) td {
  background: #272953 !important;
}

.gear-icon-svg:hover {
  content: "";
  opacity: 100;
  -webkit-animation: gear-icon-svg 3s infinite both;
  animation: gear-icon-svg 3s infinite both;
}

@-webkit-keyframes gear-icon-svg {
  0% {
    -webkit-transform: scale(1) rotateZ(0);
    transform: scale(1) rotateZ(0);
  }
  50% {
    -webkit-transform: scale(1) rotateZ(180deg);
    transform: scale(1) rotateZ(180deg);
  }
  100% {
    -webkit-transform: scale(1) rotateZ(360deg);
    transform: scale(1) rotateZ(360deg);
  }
}

@keyframes gear-icon-svg {
  0% {
    -webkit-transform: scale(1) rotateZ(0);
    transform: scale(1) rotateZ(0);
  }
  50% {
    -webkit-transform: scale(1) rotateZ(180deg);
    transform: scale(1) rotateZ(180deg);
  }
  100% {
    -webkit-transform: scale(1) rotateZ(360deg);
    transform: scale(1) rotateZ(360deg);
  }
}

.select-well {
  width: 100%;
  height: 43.87px;
  border-radius: 4px;
  background-color: #333975;
  outline: none;
  border: none;
  color: white;
  font-style: normal;
  font-weight: bold;
  font-size: 14px;
  line-height: 17px;
}

.select-well option {
  background-color: #333975;
  outline: none;
  border: none;
  color: white;
}

.select-well-option {
  height: 43.87px;
  background: #323370;
}

.pb-12px {
  padding-bottom: 12px;
}

.pt-12px {
  padding-top: 12px;
}

.p-i-12px {
  padding-inline: 12px;
}

.gtm-select-block select {
  outline: none;
}

.gtm-dark {
  display: block;
}

.gtm-tree {
  z-index: 1;
}

.block-shadow {
  width: 100%;
  height: 95%;
  background-color: #000000;
  position: absolute;
  transition: opacity 0.6s;
  z-index: 1;
  opacity: 0.5;
}

</style>