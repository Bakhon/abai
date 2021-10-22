<template>
  <div>
    <div class="row mx-0 mt-lg-2 gtm">
      <div class="col-lg-9 lg-border-block" @mouseover="closeTree()">
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
                <div v-if="!table.main_data.data">
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
                          <th class="th" v-for="(row, idx) in table.main_data.header" :key="idx"
                              :colspan="Array.isArray(row) ? row.length : ''"
                              :rowspan="Array.isArray(row) ? '' : 2"
                          >
                            {{ idx }}
                          </th>
                        </tr>
                        <tr>
                          <template v-for="(row) in table.main_data.header">
                            <template v-if="Array.isArray(row)">
                              <th class="th" v-for="r in row">
                                {{ r }}
                              </th>
                            </template>
                          </template>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="c in table.main_data.data" @click="onClickWell(c[0])">
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
                {{ this.trans("paegtm.factor_analysis") }}
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
                  {{ this.trans("paegtm.factor_analysis") }}, {{ this.trans("measurements.thousand_tons") }}
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
      <div class="col-lg-3 p-0 pl-2 pr-1">
        <div class="gtm-dark p-2">
          <div class="block-header pb-2 pt-1 d-flex">
            <div>
              {{ this.trans("paegtm.period") }}
            </div>
            <div v-if="isHidden" class="period-block">
              <div class="pl-1" style="font-weight: normal">
                <input class="mt-7px pl-1" type="checkbox" value="" v-model="dataRangeInfo.is_days_group">
                <label class="pl-1">Шаг</label>
                <input class="period-settings-input" type="number" v-model="dataRangeInfo.days" @input="onChangeDays1($event)"/>
              </div>
            </div>

          </div>
          <div class="d-flex">
            <div class="d-flex calendar-filter-block fl-1">
              {{ this.dataRangeInfo.begin_date }}
            </div>
            <div style="width: 5px;"></div>
            <div class="d-flex calendar-filter-block fl-1">
              {{ this.dataRangeInfo.end_date }}
            </div>
            <div style="width: 5px;"></div>
            <div class="d-flex calendar-filter-block show-block"  @click="myEvent">
              <img class="gear-icon-svg" src="/img/GTM/gear.svg" alt="">
            </div>

<!--            <div v-if="isHidden" class="asdasd">-->
<!--              <div style="text-align: center">-->
<!--                Выберите {{ trans('paegtm.period') }}-->
<!--              </div>-->
<!--              <div class="pl-1">-->
<!--                <input class="mt-7px pl-1" type="checkbox" value="" v-model="this.dataRange.is_days_group">-->
<!--                <label class="pl-1">Шаг</label>-->
<!--                <input class="period-settings-input" type="text" v-model="this.dataRange.days" :disable="!this.dataRange.is_days_group">-->
<!--              </div>-->
<!--            </div>-->
          </div>

        </div>

        <div class="block-header gtm-dark">
          <div class="gtm-dark gtm-filter mt-2 p-2">
            <v-select
                :options="dzosForFilter"
                label="name"
                :placeholder="this.trans('paegtm.select_dzo')"
            >
            </v-select>
            <v-select
                :options="oilFieldsForFilter"
                label="name"
                :placeholder="this.trans('paegtm.select_oil_field')"
            >
            </v-select>

            <v-select
                :options="objectsForFilter"
                label="name"
                :placeholder="this.trans('paegtm.select_object')"
            >
            </v-select>

            <v-select
                :options="structuresForFilter"
                label="name"
                :placeholder="this.trans('paegtm.select_structure')"
            >
            </v-select>

            <v-select
                :options="gusForFilter"
                label="name"
                :placeholder="this.trans('paegtm.select_gu')"
            >
            </v-select>

          </div>
        </div>

        <div class="gtm-dark mt-2 p-2 calc-button text-center" @click="postTreeData(treeData)">
          {{ trans("paegtm.calc") }}
        </div>

        <div class="gtm-dark mt-2 p-2">
          <div class="block-header p-2 d-flex">

            <div class="title-block-tree" @click="showBlock = 1">
              <img class="pr-10px" src="../img/potencial-icon.svg" alt="">
              {{ trans("paegtm.potentialSearch") }}
            </div>

            <img class="menu-item-arrow tabs-arrow m-2 my-auto" :src="showBlock === 1 ? menuArrowUp : menuArrowDown"
                 width="12" height="12" alt="">

          </div>
          <div class="table-border-gtm-top p-0" :class="{ 'display-none': showBlock === 2 }">
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
                  @event-emit="onClickableValue()"
              ></gtm-tree>
            </div>
          </div>

        </div>
        <div class="gtm-dark mt-2 p-2">
          <div class="block-header p-2 d-flex">
            <div @click="showBlock = 2">
              {{ trans("paegtm.nearWells") }}
            </div>
            <img class="menu-item-arrow tabs-arrow m-2 my-auto" :src="showBlock === 2 ? menuArrowUp : menuArrowDown"
                 width="12" height="12" alt="">
          </div>

          <div class="table-border-gtm-top p-0" :class="{ 'display-none': showBlock === 1 }">
            <div class="gtm-dark mt-2 row m-0 p-2">
              <div class="col-1 text-right mt-1 mb-1 p-0">
                <img src="../img/lens.svg">
              </div>
              <div class="col-11 m-0 mt-1 mb-1 row p-0">
                <input class="search-input w-75" type="text" placeholder="Поиск по скважине">
                <button class="search-button pl-2 pr-2">{{ trans("paegtm.search") }}</button>
              </div>
              <div class="gtm-dark text-white h-233 pl-2">
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
.h-233 {
  min-height: 233px;
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
  /*-webkit-appearance: none;*/
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
  height: 368px;
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

.fl-1 {
  flex: 1
}

</style>