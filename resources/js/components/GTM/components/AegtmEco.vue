<template>
  <div>
    <div class="row mx-0 mt-lg-2 gtm pt-1">
      <div class="gtm-dark col-lg-10 p-0">
        <div class="row col-12 p-0 m-0">
          <div class="col-6 d-none d-lg-block p-0 pl-1">
            <div class="h-100">
              <div class="block-header pb-0 pl-2">
                {{ trans('paegtm.revenues_from_additional_oil_production') }}
              </div>
              <div class="p-1 pl-2">
                <apexchart
                    type="bar" :height="350"
                    :series="barSeriesChart1"
                    :options="barChartOptions1"
                ></apexchart>
              </div>
            </div>
          </div>
          <div class="col-6 d-none d-lg-block p-0">
            <div class="h-100">
              <div class="block-header pb-0 pl-2 pt-1">
                {{ trans('paegtm.free_cash_flows') }}
              </div>
              <div class="p-1 pl-2">
                <apexchart type="bar" :height="350"
                           :series="barSeriesChart2"
                           :options="barChartOptions1"
                ></apexchart>
              </div>
            </div>
          </div>
        </div>
        <div class="row col-12 p-0 m-0">
          <div class="col-6 d-none d-lg-block p-0 pl-1">
            <div class="h-100">
              <div class="block-header pb-0 pl-2">
                {{ trans('paegtm.expenses_for_gtm') }}
              </div>
              <div class="p-1 pl-2">
                <apexchart
                    type="bar" :height="350"
                    :series="barSeriesChart2"
                    :options="barChartOptions1"
                ></apexchart>
              </div>
            </div>
          </div>
          <div class="col-6 d-none d-lg-block p-0">
            <div class="h-100">
              <div class="block-header pb-0 pl-2 pt-1">
                {{ trans('paegtm.well_drilling_fro_9_months') }}
              </div>
              <div class="p-1 pl-2 mh-370">
                <apexchart
                    type="line" :height="350"
                    :series="lineSeriesChart"
                    :options="lineChartOptions"
                ></apexchart>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-2 p-0 pl-2 pr-1">
        <div class="gtm-dark gtm-filter p-2 mb-2">
          <v-select
              :options="dzosForFilter"
              label="name"
              :placeholder="this.trans('paegtm.select_dzo')"
              @input="filterSelect('dzo', $event, dzosForFilter)"
              v-model="dzo"
          >
          </v-select>
          <v-select
              :options="oilFieldsForFilter"
              label="name"
              :placeholder="this.trans('paegtm.select_oil_field')"
              @input="filterSelect('oil', $event, oilFieldsForFilter)"
              v-model="oilFileds"
            :disabled="!oilFieldsForFilter.length"
          >
          </v-select>

          <v-select
              :options="horizontsForFilter"
              label="name"
              :placeholder="'Выберите горизонт'"
              @input="filterSelect('horizon', $event, horizontsForFilter)"
              v-model="horizonts"
              :disabled="!horizontsForFilter.length"
          >
          </v-select>

          <v-select
              :options="objectsForFilter"
              label="name"
              :placeholder="this.trans('paegtm.select_object')"
              @input="filterSelect('objects', $event, objectsForFilter)"
              v-model="objects"
              :disabled="!objectsForFilter.length"
          >
          </v-select>
        </div>
        <gtm-date-picker @dateChanged="getData"></gtm-date-picker>
        <div class="gtm-dark mt-2">
          <div class="block-header text-center p-2">
            {{ trans('paegtm.gtmType') }}
          </div>
          <div class="gtm-dark text-white pl-2">
            <div class="form-check">
              <input v-model="selectAllGtms" class="form-check-input" type="checkbox" value="" id="selectAllGtms">
              <label class="form-check-label" for="selectAllGtms">
                {{ trans('paegtm.all_gtm') }}
              </label>
            </div>
            <div v-for="gtm in gtmTypesList" class="form-check">
              <input class="form-check-input"  v-model="gtmTypes" type="checkbox" :value="gtm.id" :id="'gtm_filter_' + gtm.id">
              <label class="form-check-label" :for="'gtm_filter_' + gtm.id">
                {{ gtm.name}}
              </label>
            </div>

          </div>
        </div>
        <div class="gtm-dark mt-2 row m-0">
          <div class="col-1 text-right mt-1 mb-1 p-0">
            <img src="/img/GTM/lens.svg">
          </div>
          <div class="col-11 m-0 mt-1 mb-1 row p-0">
            <input class="search-input w-75" type="text" :placeholder="this.trans('paegtm.search_by_well')">
            <button class="search-button pl-2 pr-2">{{ trans('paegtm.search') }}</button>
          </div>
          <div class="gtm-dark text-white pl-2" style="min-height: 140px;">
            {{ trans('paegtm.all_wells') }}
          </div>
        </div>
        <div class="gtm-dark mt-2 row m-0 mb-2">
          <div class="gtm-indicator-item flex-fill d-inline-block p-2">
            <div class="bigNumber">356 <span class="units">{{ trans('paegtm.successful_events_count') }}</span></div>
            <div class="title">{{ trans('paegtm.gtm_and_vns_count') }}</div>
            <div class="progress gtm-progress mb-0">
              <div
                  class="progress-bar"
                  role="progressbar"
                  style="width: 89%"
              >
              </div>
            </div>
            <div class="d-flex justify-content-between m-0 mt-1">
              <div class="d-inline-block m-0 text-white dr-fw-700">89,25%</div>
              <div class="progressMax d-inline-block m-0">291 167</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script src="./js/AegtmEco.js"></script>