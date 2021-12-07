<template>
    <div>
        <div class="row m-0 pl-1 pt-1">
            <div class="gtm-dark col-lg-10 p-2 mb-2">

                <div class="block-header block-header pt-1 pb-3">
                    {{ trans('paegtm.distribution_of_unsuccessful_gtm_title') }}
                </div>

                <table class="table table-striped text-center text-white distribution-table mb-2">
                    <thead>
                    <tr>
                        <th class="align-middle" rowspan="2">№</th>
                        <th class="align-middle" rowspan="2">ДЗО</th>
                        <th class="align-middle" rowspan="2">ДЗО (сокр.)</th>
                        <th class="align-middle" rowspan="2">№ Скв</th>
                        <th class="align-middle" rowspan="2">м/р</th>
                        <th class="align-middle" colspan="4">Параметры до ГТМ</th>
                        <th class="align-middle" rowspan="2">Вид ГТМ</th>
                        <th class="align-middle" rowspan="2">Дата проведения ГТМ</th>
                        <th class="align-middle" colspan="3">Планируемые параметры ГТМ</th>
                        <th class="align-middle" colspan="4">Параметры после ГТМ</th>
                        <th class="align-middle" colspan="2">Отклонение план/факт</th>
                        <th class="align-middle" rowspan="2">Фактор неуспешности</th>
                        <th class="align-middle" rowspan="2">Причина недостижения</th>
                    </tr>
                    <tr>
                        <th class="align-middle" rowspan="2">Индекс пласта до ГТМ</th>
                        <th class="align-middle" rowspan="2">Qж, м3/сут</th>
                        <th class="align-middle" rowspan="2">Qн, т/сут</th>
                        <th class="align-middle" rowspan="2">обв., %</th>

                        <th class="align-middle" rowspan="2">Qж, м3/сут</th>
                        <th class="align-middle" rowspan="2">Qн, т/сут</th>
                        <th class="align-middle" rowspan="2">обв., %</th>

                        <th class="align-middle" rowspan="2">Индекс пласта после ГТМ</th>
                        <th class="align-middle" rowspan="2">Qж, м3/сут</th>
                        <th class="align-middle" rowspan="2">Qн, т/сут</th>
                        <th class="align-middle" rowspan="2">обв., %</th>

                        <th class="align-middle" rowspan="2">Qж, м3/сут</th>
                        <th class="align-middle" rowspan="2">Qн, т/сут</th>
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
                            <div class="block-header pb-0 pl-2 text-center">
                                {{ trans('paegtm.distribution_of_unsuccessful_gtm') }}
                            </div>
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
                            <div class="block-header pb-0 pl-2 text-center">
                                {{ trans('paegtm.liquid_failure') }}
                            </div>
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
                            <div class="block-header pb-0 pl-2 text-center">
                                {{ trans('paegtm.failure_water_cut_achieve') }}
                            </div>
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

<script src="./js/AegtmUnsuccesssfulDistribution.js"></script>