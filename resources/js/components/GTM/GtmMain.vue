<template>
  <div>
    <cat-loader/>
    <div class="row m-0 p-0 pl-1 pr-1">
      <div class="col-9 gtm-dark p-1 mt-1">
        <gtm-main-indicator
            v-bind:data="this.mainIndicatorData"
        ></gtm-main-indicator>
      </div>
      <div class="col-3 p-0 pl-2 mt-1">
        <div class="gtm-dark h-100 pl-2 p-1">
          <gtm-main-indicator
              v-bind:data="this.additionalIndicatorData"
          ></gtm-main-indicator>
        </div>
      </div>
    </div>
    <div class="row m-0 p-1 pt-2">
      <div class="gtm-dark col-9 p-0 gtm-main-table">
        <div class="position-absolute p-0 pl-2 pt-2 w-100 d-flex justify-content-start">
          <div @click="showMainMap = !showMainMap" class="d-flex cursor-pointer switch-map-button dr-fw-700">
            <img class="align-middle mr-1" :src="mainBlockButtonIcon" alt="" width="18">
            <div class="align-middle">{{ mainBlockButtonText }}</div>
          </div>
        </div>
        <div v-if="!showMainMap" class="h-100">
          <table class="table table-striped text-center text-white podbor-middle-table h-100">
            <thead>
            <tr>
              <th class="align-middle" rowspan="2">{{ trans('paegtm.dzo') }}</th>
              <th class="align-middle" colspan="3">{{ trans('paegtm.additional_production_of_vns') }}</th>
              <th class="align-middle" colspan="3">{{ trans('paegtm.additional_production_of_gtm') }}</th>
              <th class="align-middle" colspan="3">{{ trans('paegtm.basic_loot') }}</th>
              <th class="align-middle" colspan="3">{{ trans('paegtm.total_production') }}</th>
            </tr>
            <tr>
              <th>{{ trans('paegtm.plan').toLowerCase() }}</th>
              <th>{{ trans('paegtm.fact').toLowerCase() }}</th>
              <th>+/-</th>
              <th>{{ trans('paegtm.plan').toLowerCase() }}</th>
              <th>{{ trans('paegtm.fact').toLowerCase() }}</th>
              <th>+/-</th>
              <th>{{ trans('paegtm.plan').toLowerCase() }}</th>
              <th>{{ trans('paegtm.fact').toLowerCase() }}</th>
              <th>+/-</th>
              <th>{{ trans('paegtm.plan').toLowerCase() }}</th>
              <th>{{ trans('paegtm.fact').toLowerCase() }}</th>
              <th>+/-</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="mainTableItem in mainTableData"
                @click="selectDzo(mainTableItem)"
                v-bind:class="{ active: mainTableItem.selected }"
            >
              <td class="align-middle">
                {{ mainTableItem.name_ru }}
                <i class="fas fa-external-link-alt text-blue"></i>
              </td>
              <td class="align-middle">{{ mainTableItem.vns_additional_oil_prod_plan.toFixed(1) }}</td>
              <td class="align-middle">{{ mainTableItem.vns_additional_oil_prod_fact.toFixed(1) }}</td>
              <td class="align-middle">{{ mainTableItem.vns_additional_oil_prod_difference.toFixed(1) }}</td>
              <td class="align-middle">{{ mainTableItem.gtm_additional_oil_prod_plan.toFixed(1) }}</td>
              <td class="align-middle">{{ mainTableItem.gtm_additional_oil_prod_fact.toFixed(1) }}</td>
              <td class="align-middle">{{ mainTableItem.gtm_additional_oil_prod_difference.toFixed(1) }}</td>
              <td class="align-middle">{{ mainTableItem.base_oil_prod_plan.toFixed(1) }}</td>
              <td class="align-middle">{{ mainTableItem.base_oil_prod_fact.toFixed(1) }}</td>
              <td class="align-middle">{{ mainTableItem.base_oil_prod_difference.toFixed(1) }}</td>
              <td class="align-middle">{{ mainTableItem.oil_prod_plan.toFixed(1) }}</td>
              <td class="align-middle">{{ mainTableItem.oil_prod_fact.toFixed(1) }}</td>
              <td class="align-middle">{{ mainTableItem.oil_prod_difference.toFixed(1) }}</td>
            </tr>
            </tbody>
          </table>
        </div>
        <div v-if="showMainMap">
          <div class="text-center">
            <img src="/img/GTM/main_map.svg" class="gtm-main-map-img">
          </div>
        </div>
      </div>
      <div class="col-3 p-0 pl-2">
        <div class="mb-2">
          <gtm-date-picker @dateChanged="getData" :showSettings="false" :showPeriodTitle="true"></gtm-date-picker>
        </div>
        <div class="gtm-dark h-360">
          <table class="table text-center text-white podbor-middle-table h-100 mb-0">
            <thead>
            <tr>
              <th class="align-middle" rowspan="2">{{ trans('paegtm.gtmType') }}</th>
              <th colspan="2">{{ trans('paegtm.countThLong') }}</th>
              <th class="align-middle" rowspan="2">{{ trans('paegtm.headway.tech') }}</th>
              <th class="align-middle" rowspan="2">{{ trans('paegtm.headway.econom') }}</th>
            </tr>
            <tr>
              <th>{{ trans('paegtm.plan').toLowerCase() }}</th>
              <th>{{ trans('paegtm.fact').toLowerCase() }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="comparisonIndicatorsItem in comparisonIndicators">
              <td v-for="value in comparisonIndicatorsItem" class="align-middle">{{ value }}</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="row m-0 p-1 pt-2">
      <div class="col-6 pr-0 pl-0 z-index-1">
        <div class="svg-icon-chart-1 z-index-2" @click="showModal('chart1')">
          <img src="/img/maximize-chart.svg" alt="">
        </div>
        <apexchart type="line" height="200" :options="chartOptions" :series="chartData.series_1"></apexchart>
      </div>
      <div class="col-6 pr-0 pl-2 z-index-1">
        <div class="svg-icon-chart-2 z-index-2" @click="showModal('chart2')">
          <img src="/img/maximize-chart.svg" alt="">
        </div>
        <apexchart type="line" height="200" :options="chartOptions2" :series="chartData.series_2"></apexchart>
      </div>
      <div>
        <modal class="modal-bign-wrapper" name="chart1" draggable=".modal-bign-header" :width="1050" :height="500"
               style="background: transparent;" :adaptive="true">
          <div class="modal-bign modal-bign-container">
            <div class="modal-bign-header">
              <button type="button" class="modal-bign-button" @click="closeModal('chart1')">
                {{ trans('pgno.zakrit') }}
              </button>
            </div>
            <apexchart type="line" height="400" width="1000" style="color: black" :options="chartOptions"
                       :series="chartData.series_1"></apexchart>
          </div>
        </modal>
        <modal class="modal-bign-wrapper" name="chart2" draggable=".modal-bign-header" :width="1050" :height="500"
               style="background: transparent; color: black" :adaptive="true">
          <div class="modal-bign modal-bign-container">
            <div class="modal-bign-header">
              <button type="button" class="modal-bign-button" @click="closeModal('chart2')">
                {{ trans('pgno.zakrit') }}
              </button>
            </div>
            <apexchart type="line" height="400" width="1000" style="color: black" chart="chart" :options="chartOptions2"
                       :series="chartData.series_2"></apexchart>
          </div>
        </modal>
      </div>
    </div>
  </div>
</template>

<script src="./js/GtmMain.js"></script>

