<template>
  <div>
    <div class="block-shadow" v-if="showShadow" @click="closeTree()"></div>
    <div class="row mx-0 mt-lg-2 gtm main-block-gtm">
      <div class="left-block lg-border-block">
        <div class="top-block pb-1">
          <div class="top-block-box" :class="!isMinimize ? 'd-none d-lg-block p-0' : 'maximize-block d-none d-lg-block p-0'">
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
            <div class="border-block-out">
              <div class="border-block-in">
                <table class="table-pgtm text-center text-white podbor-middle-table">
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
                  <tbody class="tbody-candidates">
                  <tr  v-for="(c, idx) in clickableTable.data" @click="onClickWell(c[0], idx)" :key="idx" >
                    <th>{{ idx * 1 + 1 }}</th>
                    <th :class="{ activeTr: idx === activeItem }" class="bg-body" v-for="row in c">{{ row }}</th>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div v-if="isMinimize" class="d-block" @click="onMinimizeChart()">
            <div class="pb-1">
              <img src="/img/GTM/minimize.svg" alt="">
            </div>
            <div class="pb-1 gtm-dark minimized-block">
              <div class="minimized-title">
                {{ this.trans("paegtm.current_qualifiers_map") }}
              </div>
            </div>
          </div>
          <div v-else class="top-block-box d-none d-lg-block p-0">
            <div class="block-header pb-0 pl-2 pt-1 d-flex border-color pl-1 d-block">
              <div>
                {{ this.trans("paegtm.current_qualifiers_map") }}
              </div>
              <div class="d-flex">
                <div class="pr-3 pb-1">
                  <img src="/img/GTM/download.svg" alt="">
                </div>
                <div class="pr-3 pb-1">
                  <img src="/img/GTM/full-screen.svg" alt="">
                </div>
                <div class="pr-3 pb-1" @click="onMinimizeChart()">
                  <img src="/img/GTM/maximize.svg" alt="">
                </div>
              </div>
            </div>
            <div class="border-block-out">
              <div class="border-block-in">
                <img src="/img/GTM/map.svg" class="gtm-map-img img-fluid">
              </div>
            </div>
          </div>

        </div>
        <div class="bottom-block">
          <div class="bottom-block-box">
            <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
              <div>
                {{ this.trans("paegtm.well") }} {{ wellNumber }}
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
              <div v-if="lineChartSeries === null" class="border-block-in">
                <div class="empty-data-title">
                  {{ this.trans("paegtm.empty-well-chart") }}
                </div>
              </div>
              <div v-else class="border-block-in">
                <apexchart
                    :height="340"
                    :options="lineChartOptions"
                    :series="lineChartSeries"
                ></apexchart>
              </div>
            </div>
          </div>
          <div class="bottom-block-box">
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
              <div v-if="waterFallChartSeries === null" class="border-block-in">
                <div class="empty-data-title">
                  {{ this.trans("paegtm.empty-well-chart") }}
                </div>
              </div>
              <div v-else class="border-block-in">
                <apexchart
                    :height="340"
                    :options="waterFallChartOptions"
                    :series="waterFallChartSeries"
                ></apexchart>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="right-block p-0 pl-2 pr-1">
        <div class="gtm-dark p-2">
          <div class="block-header pb-2 pt-1 d-flex">
            <div>
              {{ this.trans("paegtm.period") }}
            </div>
            <div v-if="isHidden" class="period-block">
              <div class="pl-1">
                <input class="mt-7px pl-1" type="checkbox" value="" v-model="dataRangeInfo.is_days_group">
                <label class="pl-1">Шаг</label>
                <input class="period-settings-input" type="number" v-model="dataRangeInfo.days"
                       @input="onChangeDays($event)"/>
              </div>
            </div>

          </div>
          <div class="d-flex gap-10">
            <gtm-tree-date-picker class="flex-1"></gtm-tree-date-picker>
            <div class="d-flex calendar-filter-block show-block" @click="onHideDays">
              <img class="gear-icon-svg" src="/img/GTM/gear.svg" alt="">
            </div>
          </div>
        </div>

        <div class="block-header gtm-dark">
          <div class="gtm-dark gtm-filter mt-2">
            <div class="gtm-select-block pb-12px pt-12px p-i-12px">
              <select class="select-well pl-2">
                <option class="select-well-option" value="" disabled selected>{{
                    this.trans('paegtm.select_dzo')
                  }}
                </option>
              </select>
            </div>

            <div class="gtm-select-block pb-12px p-i-12px">
              <select class="select-well pl-2">
                <option class="select-well-option" value="" disabled selected>{{
                    this.trans('paegtm.select_oil_field')
                  }}
                </option>
              </select>
            </div>

            <div class="gtm-select-block pb-12px  p-i-12px">
              <select class="select-well pl-2">
                <option class="select-well-option" value="" disabled selected>{{
                    this.trans('paegtm.select_object')
                  }}
                </option>
              </select>
            </div>

            <div class="gtm-select-block pb-12px p-i-12px">
              <select class="select-well pl-2">
                <option class="select-well-option" value="" disabled selected>{{
                    this.trans('paegtm.select_structure')
                  }}
                </option>
              </select>
            </div>

            <div class="gtm-select-block pb-12px p-i-12px">
              <select class="select-well pl-2">
                <option class="select-well-option" value="" disabled selected>{{
                    this.trans('paegtm.select_gu')
                  }}
                </option>
              </select>
            </div>
          </div>
        </div>

        <div class="gtm-dark p-2 calc-button text-center" @click="onPostTreeData(treeStore)">
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
          <div class="table-border-gtm-top p-0" :class="{ 'display-none': showBlock === 2 }" @click="onHoverTree()">
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
                  v-for="treeDataChild in treeStore"
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
<style scoped lang="scss" src="../scss/podbor.scss">
</style>