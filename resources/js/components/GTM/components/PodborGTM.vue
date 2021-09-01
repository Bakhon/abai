<template>
  <div>
    <div class="row mx-0 mt-lg-2 gtm">
      <div class="gtm-dark col-lg-10 p-0" @click="closeTree()">
        <div class="row col-12 p-0 m-0">
          <div class="col-6 d-none d-lg-block p-0 pl-1">
            <div class="h-100">
              <div class="block-header pb-0 pl-2 pt-1">
                {{ trans("paegtm.wells-candidates") }}
              </div>
              <div class="p-1 pl-2">
                <table class="table text-center text-white podbor-middle-table">
                  <thead>
                  <tr>
                    <th class="align-middle" rowspan="2">{{ trans("paegtm.borehole_number") }}</th>
                    <th class="align-middle" rowspan="2">{{ trans("paegtm.gtmType") }}</th>
                    <th colspan="3">{{ trans("paegtm.forecast_indicators") }}</th>
                  </tr>
                  <tr>
                    <th>{{ trans("paegtm.q_liq") }}</th>
                    <th>{{ trans("paegtm.q_oil") }}</th>
                    <th>{{ trans("paegtm.water_cut") }} %</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="candidate in candidates">
                    <td>{{ candidate[0] }}</td>
                    <td>{{ candidate[1] }}</td>
                    <td>{{ candidate[2] }}</td>
                    <td>{{ candidate[3] }}</td>
                    <td>{{ candidate[4] }}</td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-6 d-none d-lg-block p-0">
            <div class="h-100">
              <div class="block-header pb-0 pl-2 pt-1">
                {{ trans("paegtm.current_qualifiers_map") }}
              </div>
              <div class="p-3">
                <img src="/img/GTM/map.svg" class="gtm-map-img">
              </div>
            </div>
          </div>
        </div>
        <div class="row col-12 p-0 m-0 pb-2">
          <div class="col-6 d-none d-lg-block p-0 pl-1">
            <div class="h-100">
              <div class="block-header pb-0 pl-2 pt-1">
                {{ trans("paegtm.well") }} 4931
              </div>
              <div class="p-1 pl-2 mh-370">
                <apexchart
                    :height="360"
                    :options="lineChartOptions"
                    :series="lineChartSeries"
                ></apexchart>
              </div>
            </div>
          </div>
          <div class="col-6 d-none d-lg-block p-0">
            <div class="h-100 pb-2">
              <div class="block-header pb-0 pl-2">
                {{ trans("paegtm.factor_analysis") }}, {{ trans("measurements.thousand_tons") }}
              </div>
              <div class="p-1 pl-2">
                <img class="demo-img" src="/img/GTM/podbo_demo_graph.svg" height="350">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-2 p-0 pl-2 pr-1">
        <div class="block-header gtm-dark p-2">
          <div class="block-header p-2">
            {{ trans("paegtm.period") }}
          </div>
          <gtm-date-picker></gtm-date-picker>
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

        <div class="gtm-dark mt-2">
          <div class="block-header p-2 text-center calc-button" @click="postTreeData($event)">
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
</style>