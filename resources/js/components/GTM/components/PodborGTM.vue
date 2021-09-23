<script src="js/PodborGTM.js"></script>
<template>
  <div>
    <div class="row mx-0 mt-lg-2 gtm">
      <div class="col-lg-10 lg-border-block" @click="closeTree()">
        <div class="row col-12 p-0 m-0">
          <div class="col-6 d-none d-lg-block p-0">
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
                    <img src="/img/GTM/maximize.svg" alt="">
                  </div>
                </div>
              </div>
              <div class="p-0 pl-0 table-pgtm">
                <div v-if="!table.main_data.data" >
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
                    <thead>
                    <tr>
                      <th v-for="(row, idx) in table.main_data.header" :key="idx"
                          :colspan="Array.isArray(row) ? row.length : ''"
                          :rowspan="Array.isArray(row) ? '' : 2"
                      >
                        {{ idx }}
                      </th>
                    </tr>
                    <tr>
                      <template v-for="(row) in table.main_data.header">
                        <template v-if="Array.isArray(row)">
                          <th v-for="r in row">
                            {{ r }}
                          </th>
                        </template>
                      </template>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="c in table.main_data.data">
                      <th class="bg-body" v-for="row in c" @click="onClickWell(row)">{{ row }}</th>
                    </tr>
                    </tbody>
                  </table>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-6 d-none d-lg-block p-0 pl-1">
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
                    <img src="/img/GTM/maximize.svg" alt="">
                  </div>
                  <div class="pr-3 pb-1" @click="onMinimizeChart">
                    <img src="/img/GTM/maximize-arrow.svg" alt="">
                  </div>
                </div>

              </div>
                <div class="border-block-out">
                  <div class="border-block-in">
                    <div class="p-3">
                      <img src="/img/GTM/map.svg" class="gtm-map-img">
                    </div>
                  </div>
                </div>
                </div>
            </div>
        </div>
        <div class="row col-12 p-0 m-0 pt-1">
          <div v-if="lineChartSeries === null" class="col-6 d-none d-lg-block p-0">
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
              <div  class="block-header pb-0 pl-2 pt-1 d-flex border-color">
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
                <div class="border-block-in" >
                  <apexchart
                      :height="360"
                      :options="lineChartOptions"
                      :series="lineChartSeries"
                  ></apexchart>
                  </div>
              </div>
            </div>
          </div>

          <div v-if="waterFallChartSeries === null" class="col-6 d-none d-lg-block p-0 pl-1">
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
              <div  class="block-header pb-0 pl-2 pt-1 d-flex border-color">
                <div>
                  {{ this.trans("paegtm.factor_analysis") }}, {{ this.trans("measurements.thousand_tons") }}
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
                      :height="360"
                      :options="waterFallChartOptions"
                      :series="waterFallChartSeries"
                  ></apexchart>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
      <div class="col-lg-2 p-0 pl-2 pr-1">
        <div class="block-header gtm-dark p-2">
          <div class="block-header p-2">
            {{ this.trans("paegtm.period") }}
          </div>
          <gtm-date-picker
          :showSettings="true"
          ></gtm-date-picker>
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

        <div class="gtm-dark mt-2 p-2" @click="postTreeData(treeData)">
          <div class="block-header p-2 text-center calc-button" >
            {{ trans("paegtm.calc") }}
          </div>
        </div>

        <div class="gtm-dark mt-2 p-2">
          <div class="block-header p-2 d-flex">

            <div class="title-block-tree" @click="showBlock = 1">
              <img style="padding-right: 10px;" src="../img/potencial-icon.svg" alt="">
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

.border-color {
  background-color: #323370
}

.border-block-out {
  border: 8px solid #363B68
}

.border-block-in {
  border: 8px solid #1A214A
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
}

::-webkit-scrollbar {
  height: 4px;
  width: 4px;
}

::-webkit-scrollbar-track {
  background: #272953;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}
</style>