<template>
    <div>
        <div class="row m-0 pl-1 pt-1">
            <div class="gtm-dark col-lg-10 p-2 mb-2">
                <div class="d-flex justify-content-between">
                        <div class="block-header block-header pt-1 pb-3">
                            {{ trans('paegtm.distribution_of_unsuccessful_gtm_title') }}
                        </div>
                        <button class="download-gtm-factor-analysis-table mt-2" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="download-icon" src="/img/gno/download.svg" alt="">
                            {{ trans('paegtm.download') }}  <img class="bottom-arrow-icon" src="/img/gno/bottom-arrow.svg" alt="">
                        </button>
                        <div class="dropdown-menu gtm-dropdown-menu">
                            <a class="dropdown-item" href="#" @click="downloadPdf()">PDF</a>
                            <a class="dropdown-item" href="#" @click="downloadExcel()">MS Excel</a>
                        </div>
                </div>

                <table class="table table-striped text-center text-white distribution-table mb-2">
                    <thead>
                    <tr>
                        <th class="align-middle" rowspan="2">№</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.dzo') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.dzo_short') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.uwi') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.oilfield') }}</th>
                        <th class="align-middle" colspan="4">{{ this.trans('paegtm.params_before_gtm') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.gtmType') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.gtm_date') }}</th>
                        <th class="align-middle" colspan="3">{{ this.trans('paegtm.gtm_plan_params') }}</th>
                        <th class="align-middle" colspan="4">{{ this.trans('paegtm.params_after_gtm') }}</th>
                        <th class="align-middle" colspan="2">{{ this.trans('paegtm.gtm_params_deviation') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.gtm_failure_factor') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.gtm_failure_reason') }}</th>
                    </tr>
                    <tr>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.formation_index_before_gtm') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.q_liq_m3_day') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.q_oil_m3_day') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.wct_percent') }}</th>

                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.q_liq_m3_day') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.q_oil_m3_day') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.wct_percent') }}</th>

                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.formation_index_after_gtm') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.q_liq_m3_day') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.q_oil_m3_day') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.wct_percent') }}</th>

                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.q_liq_m3_day') }}</th>
                        <th class="align-middle" rowspan="2">{{ this.trans('paegtm.q_oil_m3_day') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(mainTableItem, index) in mainTableData">
                        <td class="align-middle">{{ ++index }}</td>
                        <td class="align-middle" width="11%">{{ mainTableItem.org_name }}</td>
                        <td class="align-middle">{{ mainTableItem.org_name_short }}</td>
                        <td class="align-middle">{{ mainTableItem.uwi }}</td>
                        <td class="align-middle">{{ mainTableItem.oilfield }}</td>
                        <td class="align-middle">{{ mainTableItem.formation_index_before_gtm }}</td>
                        <td class="align-middle">{{ mainTableItem.q_l_before_gtm }}</td>
                        <td class="align-middle">{{ mainTableItem.q_o_before_gtm }}</td>
                        <td class="align-middle">{{ mainTableItem.wct_before_gtm }}</td>
                        <td class="align-middle">{{ mainTableItem.gtm }}</td>
                        <td class="align-middle">{{ mainTableItem.gtm_date }}</td>
                        <td class="align-middle">{{ mainTableItem.q_l_plan }}</td>
                        <td class="align-middle">{{ mainTableItem.q_o_plan }}</td>
                        <td class="align-middle">{{ mainTableItem.wct_plan }}</td>
                        <td class="align-middle">{{ mainTableItem.formation_index_after_gtm }}</td>
                        <td class="align-middle">{{ mainTableItem.q_l_after_gtm }}</td>
                        <td class="align-middle">{{ mainTableItem.q_o_after_gtm }}</td>
                        <td class="align-middle">{{ mainTableItem.wct_after_gtm }}</td>
                        <td class="align-middle" :class="{growth : mainTableItem.q_l_deviation > 0,  fall : mainTableItem.q_l_deviation < 0}">{{ mainTableItem.q_l_deviation }}</td>
                        <td class="align-middle" :class="{growth : mainTableItem.q_o_deviation > 0,  fall : mainTableItem.q_o_deviation < 0}">{{ mainTableItem.q_o_deviation }}</td>
                        <td class="align-middle">{{ mainTableItem.failure_factor }}</td>
                        <td class="align-middle">{{ mainTableItem.failure_reason }}</td>
                    </tr>
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-4 d-none d-lg-block pr-0">
                        <div class="chart-wrapper mb-2">
                            <div class="p-1 pl-2">
                              <apexchart
                                  type="donut" :height="280"
                                  :options="donutChart1"
                                  :series="series"
                                  ref="unsuccessfulDistributionDonutChart"
                              ></apexchart>
                            </div>
                        </div>
                    </div>

                    <div class="col-4 d-none d-lg-block pl-1 pr-1">
                        <div class="chart-wrapper mb-2">
                            <div class="p-1 pl-2">
                              <apexchart
                                  type="donut" :height="280"
                                  :options="donutChart2"
                                  :series="series1"
                                  ref="liqDonutChart"
                              ></apexchart>
                            </div>
                        </div>
                    </div>

                    <div class="col-4 d-none d-lg-block pl-0">
                        <div class="chart-wrapper mb-2">
                            <div class="p-1 pl-2 pr-3">
                              <apexchart
                                  type="donut" :height="280"
                                  :options="donutChart3"
                                  :series="series2"
                                  ref="wctDonutChart"
                              ></apexchart>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 p-0 pl-2 pr-1">
                <div class="gtm-dark gtm-filter p-2">
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
                <div class="mt-2">
                    <gtm-date-picker @dateChanged="getData"></gtm-date-picker>
                </div>
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
                            <input class="form-check-input"  v-model="gtmTypes" @change="selectGtm()" type="checkbox" :value="gtm.name" :id="'gtm_filter_' + gtm.id">
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
                    <div class="gtm-dark text-white pl-2" style="min-height: 156px;">
                        {{ trans('paegtm.all_wells') }}
                    </div>
                </div>
                <div class="gtm-dark mt-2 row m-0 mb-2">
                    <successful-factors-indicator ref="successfulFactorsIndicatorRef"></successful-factors-indicator>
                </div>
            </div>
        </div>
    </div>
</template>

<script src="./js/AegtmUnsuccesssfulDistribution.js"></script>