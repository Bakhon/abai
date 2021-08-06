<template>
    <div>
        <div class="row m-0 p-0 pl-1 pr-1">
            <div class="col-9 gtm-dark p-1 mt-1">
                <gtm-main-indicator
                    v-bind:data="[
                        {
                            number: 1458,
                            units: this.trans('paegtm.activities'),
                            title: this.trans('paegtm.number_of_gtm_and_vns'),
                            progressValue: 1458,
                            progressMax: 1441,
                            progressPercents: 1458 / 1441 * 100,
                        },
                        {
                            number: 695,
                            units: this.trans('paegtm.tons'),
                            title: this.trans('paegtm.additional_oil_production_from_vns'),
                            progressValue: 695,
                            progressMax: 713,
                            progressPercents: 695 / 713 * 100,
                        },
                        {
                            number: 766,
                            units: this.trans('paegtm.tons'),
                            title: this.trans('paegtm.additional_oil_production_from_gtm'),
                            progressValue: 766,
                            progressMax: 867,
                            progressPercents: 766 / 867 * 100,
                        },
                        {
                            number: 16998,
                            units: this.trans('paegtm.tons'),
                            title: this.trans('paegtm.basic_oil_production'),
                            progressValue: 16998,
                            progressMax: 16973,
                            progressPercents: 16998 / 16973 * 100,
                        },
                    ]"
                ></gtm-main-indicator>
            </div>
            <div class="col-3 p-0 pl-2 mt-1">
                <div class="gtm-dark h-100 pl-2 p-1">
                    <gtm-main-indicator
                        v-bind:data="[
                        {
                            number: 18475,
                            units: this.trans('paegtm.tons'),
                            title: this.trans('paegtm.oil_production'),
                            progressValue: 18475,
                            progressMax: 18568,
                            progressPercents: 18475 / 18568 * 100,
                        },
                    ]"
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
                                  {{ mainTableItem.name_ru}}
                                  <i class="fas fa-external-link-alt text-blue"></i>
                              </td>
                              <td class="align-middle">{{ mainTableItem.col_1}}</td>
                              <td class="align-middle">{{ mainTableItem.col_2}}</td>
                              <td class="align-middle">{{ mainTableItem.col_3}}</td>
                              <td class="align-middle">{{ mainTableItem.col_4}}</td>
                              <td class="align-middle">{{ mainTableItem.col_5}}</td>
                              <td class="align-middle">{{ mainTableItem.col_6}}</td>
                              <td class="align-middle">{{ mainTableItem.col_7}}</td>
                              <td class="align-middle">{{ mainTableItem.col_8}}</td>
                              <td class="align-middle">{{ mainTableItem.col_9}}</td>
                              <td class="align-middle">{{ mainTableItem.col_10}}</td>
                              <td class="align-middle">{{ mainTableItem.col_11}}</td>
                              <td class="align-middle">{{ mainTableItem.col_12}}</td>
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
                    <gtm-date-picker @dateChanged="getData"></gtm-date-picker>
                </div>
                <div class="gtm-dark h-100">
                    <table class="table text-center text-white podbor-middle-table h-100 mb-0">
                        <thead>
                        <tr>
                            <th class="align-middle" rowspan="2" style="width: 250px;">{{ trans('paegtm.gtmType') }}</th>
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

        <div class="row p-1">
            <div class="col-6 pr-0">
              <apexchart type="line" height="180" :options="chartOptions" :series="series1"></apexchart>
            </div>
            <div class="col-6 pl-2">
              <apexchart type="line" height="180"  :options="chartOptions" :series="series2"></apexchart>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from "vue";
import {paegtmMapActions, paegtmMapGetters} from '@store/helpers';
import moment from "moment";
import VueApexCharts from "vue-apexcharts";

Vue.component("gtm-modal", {
  template: "#modal-template"
});

export default {
  components: {
    "apexchart": VueApexCharts
  },
    data: function () {
      return {
            mainTableData: [],
            comparisonIndicators: [],
        title: {
          text: this.trans('paegtm.dynamicChartOil'),
          align: 'center',
          style: {
            fontSize:  '14px',
            fontWeight:  'bolder',
            offsetY: 10
          },
        },
          series1: [
            {
              name: this.trans('paegtm.planEd'),
              type: 'column',
              data: [1, 2, 6, 11, 19, 27, 35, 40, 49, 57, 65, 74],
            },
            {
              name: this.trans('paegtm.factEd'),
              type: 'column',
              data: [2, 3, 7, 16, 18, 29, 38, 43, 53, 53, 72, 89],
            },
            {
              name: this.trans('paegtm.planOil'),
              type: 'line',
              data: [20, 30, 40, 55, 67, 75, 87, 98, 110, 120, 145, 155],
            },
            {
              name: this.trans('paegtm.factOil'),
              type: 'line',
              data: [10, 25, 35, 47, 53, 62, 77, 81, 92, 103, 120, 130]
            }
          ],
          series2: [
            {
              name: this.trans('paegtm.planEd'),
              type: 'column',
              data: [1, 4, 7, 13, 23, 30, 33, 39, 47, 56, 64, 77],
            },
            {
              name: this.trans('paegtm.factEd'),
              type: 'column',
              data: [3, 5, 8, 14, 17, 24, 33, 47, 52, 65, 69, 76],
            },
            {
              name: this.trans('paegtm.planOil'),
              type: 'line',
              data: [19, 27, 39, 52, 63, 77, 84, 96, 107, 117, 129, 141],
            },
            {
              name: this.trans('paegtm.factOil'),
              type: 'line',
              data: [14, 23, 37, 43, 57, 61, 75, 86, 97, 107, 118, 133]
            }
          ],
          chartOptions: {
            grid: {
              show: true,
              borderColor: '#454d7d',
              strokeDashArray: 0,
              position: 'back',
              xaxis: {
                lines: {
                  show: true
                }
              },
              yaxis: {
                lines: {
                  show: true
                }
              },
              row: {
                colors: undefined,
                opacity: 3
              },
              column: {
                colors: undefined,
                opacity: 3
              },
              padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
              },
            },
            colors: [ '#4f81bd', '#c0504d', '#9bbb59', '#8064a2'],
            chart: {
              background: '#272953',
              type: 'line',
              foreColor: '#fff',
              width: '10%',
            },
            stroke: {
              width: [0, 0, 5, 5]
            },
            title: {
              text: this.trans('paegtm.dynamicEnterOil'),
              align: 'center',
              style: {
                fontSize:  '14px',
                fontWeight:  'bolder',
                offsetY: 10
              },
            },
            markers: {
              size: 4,
              colors: undefined,
              strokeWidth: 0
            },
            dataLabels: {
              enabled: true,
              enabledOnSeries: [0, 1],
              background: {
                enabled: true,
                foreColor: '#fff',
                opacity: 0,
                padding: 0,
                dropShadow: {
                  enabled: false,
                }
              },
              style: {
                fontSize: '11px',
                fontWeight: 'bold'
              }
            },
            labels: [
              this.trans('paegtm.Jan'),
              this.trans('paegtm.Feb'),
              this.trans('paegtm.Mar'),
              this.trans('paegtm.Apr'),
              this.trans('paegtm.May'),
              this.trans('paegtm.Jun'),
              this.trans('paegtm.Jul'),
              this.trans('paegtm.Aug'),
              this.trans('paegtm.Sep'),
              this.trans('paegtm.Oct'),
              this.trans('paegtm.Nov'),
              this.trans('paegtm.Dec')
            ],
          },
            lineChartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        fontSize: 14,
                        fontColor: '#FFF',
                    },
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: '#3C4270',
                        },
                        ticks: {
                            fontColor: '#FFF',
                            fontSize: 10,
                        },
                    }],
                    xAxes: [{
                        gridLines: {
                            fontColor: '#3C4270',
                        },
                        ticks: {
                            fontColor: '#FFF',
                            fontSize: 10,
                        },
                    }],
                }
            },
            isModalHide: true,
            showMainMap: false,
        };
    },
    methods: {
        ...paegtmMapActions([
            'changeDateStart',
            'changeDateEnd',
            'changeDzoId',
        ]),
        showModal() {
            this.isModalHide = false;
        },
        hideModal() {
            this.isModalHide = true;
        },
        getGtmInfo() {
            this.$store.commit('globalloading/SET_LOADING', true);
            this.axios.get(
                this.localeUrl('/paegtm/get-gtms'),
                {params: {dzoId: this.dzoId, dateStart: this.dateStart, dateEnd: this.dateEnd}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    this.comparisonIndicators = data
                }
                this.$store.commit('globalloading/SET_LOADING', false);
            });
        },
        getMainTableData() {
            this.axios.get(
                this.localeUrl('/paegtm/get-main-table-data'),
                {params: {dzoId: this.dzoId}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    this.mainTableData = data
                }
            });
        },
        getData() {
            this.getGtmInfo();
            this.getMainTableData();
        },
        selectDzo(dzo) {

            this.mainTableData.forEach((item) => {
                if (item.id == dzo.id) {
                    dzo.selected = !dzo.selected
                } else {
                    item.selected = false;
                }
            });

            this.changeDzoId(dzo.id);
            this.getData();
        },

    },
    computed: {
        ...paegtmMapGetters([
            'dateStart',
            'dateEnd',
            'dzoId',
        ]),
        mainBlockButtonText: function () {
            return this.showMainMap ? this.trans('paegtm.table') : this.trans('paegtm.map')
        },
        mainBlockButtonIcon: function () {
            return this.showMainMap ? '/img/GTM/icon_main_table_button.svg' : '/img/GTM/icon_main_map_button.svg'
        },
    },
    created() {
        this.$store.commit('globalloading/SET_LOADING', true);
    },
    mounted () {
        this.getData();
        // this.changeDateStart(this.dateStart);
        // this.changeDateEnd(this.dateEnd);
        //this.changeDzoId(this.dzoId);
    }
}
</script>
