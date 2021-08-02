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
                <div class="position-absolute p-0 pr-2 pt-2 w-100 d-flex justify-content-end">
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
                <img src="/img/GTM/demo_chart_1.png" alt="" class="img-fluid">
            </div>
            <div class="col-6 p-0 pl-2">
                <img src="/img/GTM/demo_chart_2.png" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</template>

<script>
import Vue from "vue";
import {paegtmMapActions, paegtmMapGetters} from '@store/helpers';
import moment from "moment";
Vue.component("gtm-modal", {
  template: "#modal-template"
});

export default {
    data: function () {
        return {
            mainTableData: [],
            comparisonIndicators: [],
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
                {params: {dzoId: this.dzoId, dateStart: this.$store.state.paegtmMap.dateStart, dateEnd: this.$store.state.paegtmMap.dateEnd}}
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
