import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import {paegtmMapActions, paegtmMapGetters, paegtmMapState, globalloadingMutations} from '@store/helpers';
import orgStructure from '../../mock-data/org_structure.json'
import VueApexCharts from "vue-apexcharts";
import filterSelect from '../../mixin/selectFilter'
import fileDownload from "js-file-download";
import moment from "moment";

export default {
    components: {
        vSelect,
        apexchart: VueApexCharts,
    },
    mixins: [filterSelect],
    data: function () {
        return {
            mainTableData: [],
            gtmTypesList: [
                {id: "vns", name: this.trans('paegtm.gtm_vns')},
                {id: "grp", name: this.trans('paegtm.gtm_grp')},
                {id: "pvlg", name: this.trans('paegtm.gtm_pvlg')},
                {id: "pvr", name: this.trans('paegtm.gtm_pvr')},
                {id: "rir", name: this.trans('paegtm.gtm_rir')},
                {id: "vns_grp", name: this.trans('paegtm.gtm_vns_grp')},
            ],
            dzos: orgStructure,
            loaded: false,
            series: [],
            series1: [],
            series2: [],
            donutChart1: {
                chart: {
                    type: 'donut',
                    foreColor: '#fff',
                },
                labels: [],
                colors: ['#3f51b5', '#f0ad81', '#82baff', '#ef5350'],
                stroke: {
                    show: false,
                },
                dataLabels: {
                    textAnchor: 'middle',
                    distributed: false,
                    style: {
                        fontSize: '14px',
                    },
                }
            },
            donutChart2: {
                chart: {
                    type: 'donut',
                    foreColor: '#fff',
                },
                labels: [],
                colors: ['#3f51b5', '#f0ad81', '#82baff', '#ef5350'],
                stroke: {
                    show: false,
                },
                dataLabels: {
                    textAnchor: 'middle',
                    distributed: false,
                    style: {
                        fontSize: '14px',
                    },
                }
            },
            donutChart3: {
                chart: {
                    type: 'donut',
                    foreColor: '#fff',
                },
                labels: [],
                colors: ['#3f51b4', '#ef5350', '#82baff', '#f0ad81'],
                stroke: {
                    show: false,
                },
                dataLabels: {
                    textAnchor: 'middle',
                    distributed: false,
                    style: {
                        fontSize: '14px',
                    },
                }
            },

            dzo: null,
            oilFileds: [],
            horizonts: [],
            objects: [],
            gtmTypes: [],

            dzosForFilter: [],
            oilFieldsForFilter: [],
            horizontsForFilter: [],
            objectsForFilter: [],
        };
    },
    computed: {
        ...paegtmMapState([
            'dateStart',
            'dateEnd',
            'dzoName',
            'selectedGtm'
        ]),
        selectAllGtms: {
            get: function () {
                return this.gtmTypesList ? this.gtmTypes.length == this.gtmTypesList.length : false;
            },
            set: function (value) {
                let selected = [];

                if (value) {
                    this.gtmTypesList.forEach(function (gtm) {
                        selected.push(gtm.name);
                    });
                }

                this.gtmTypes = selected;
                this.selectGtm();
            }
        }
    },
    methods: {
        ...paegtmMapActions([
            'changeDateStart',
            'changeDateEnd',
            'changeDzoId',
            'changeDzoName',
            'changeSelectedGtm'
        ]),
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        getGtmFactorsData() {
            this.axios.get(
                this.localeUrl('/paegtm/aegtm/get-gtm-factors-data'),
                {params: {dzoName: this.dzoName, dateStart: this.dateStart, dateEnd: this.dateEnd, selectedGtm: this.selectedGtm}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    if (typeof data != 'object' || !data.length) {
                        this.setNotify(this.trans('paegtm.aegtm_factors_no_data'), this.trans('app.error'), "danger")
                    }

                    this.mainTableData = data
                }
            }).catch(err => {
                this.setNotify(this.trans('paegtm.no_gtm_factors_data'), this.trans('app.error'), "danger")
            }).finally(() => this.SET_LOADING(false));
        },
        getGtmFactorsChartData() {
            this.axios.get(
                this.localeUrl('/paegtm/aegtm/get-gtm-factors-chart-data'),
                {params: {dzoName: this.dzoName, dateStart: this.dateStart, dateEnd: this.dateEnd, selectedGtm: this.selectedGtm}}
            ).then((response) => {
                let data = response.data;

                if (data) {
                    if (typeof data != 'object') {
                        this.setNotify(this.trans('paegtm.aegtm_factors_no_data'), this.trans('app.error'), "danger")
                    }

                    this.series = data.unsuccessful_distribution_gtm_data.data;
                    this.series1 = data.liq_data.data;
                    this.series2 = data.wct_data.data;

                    if(typeof this.$refs.unsuccessfulDistributionDonutChart !== 'undefined') {
                        this.$refs.unsuccessfulDistributionDonutChart.updateOptions({ labels: data.unsuccessful_distribution_gtm_data.labels });
                    }

                    if(typeof this.$refs.liqDonutChart !== 'undefined') {
                        this.$refs.liqDonutChart.updateOptions({ labels: data.liq_data.labels });
                    }

                    if(typeof this.$refs.wctDonutChart !== 'undefined') {
                        this.$refs.wctDonutChart.updateOptions({ labels: data.wct_data.labels });
                    }
                }
            }).catch(err => {
                    this.setNotify(this.trans('paegtm.no_gtm_factors_chart_data'), this.trans('app.error'), "danger")
            }).finally(() => this.SET_LOADING(false));
        },
        getGtmFactorsAnalysisCount() {
            this.axios.get(
                this.localeUrl('/paegtm/aegtm/get-gtms-factor-analysis-count'),
                {params: {dzoName: this.dzoName, dateStart: this.dateStart, dateEnd: this.dateEnd, selectedGtm: this.selectedGtm}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    this.totalGtmsCount = data.total_gtms_count
                    this.successfulGtmsCount = data.successful_gtms_count
                    this.unsuccessfulGtmsCount = data.unsuccessful_gtms_count
                    this.successfulGtmsPercent = data.successful_gtms_percent
                }
            }).catch(err => {
                this.setNotify(this.trans('paegtm.empty_responce'), this.trans('app.error'), "danger")
            }).finally(() => this.SET_LOADING(false));
        },
        getData() {
            this.SET_LOADING(true);
            this.getGtmFactorsData();
            this.getGtmFactorsChartData();
            this.getGtmFactorsAnalysisCount();

            if(typeof this.$refs.successfulFactorsIndicatorRef !== 'undefined') {
                this.$refs.successfulFactorsIndicatorRef.onFilterChanged();
            }
        },
        selectGtm() {
            this.changeSelectedGtm(this.gtmTypes);
            this.getData();
        },
        setNotify(message, title, type) {
            this.$bvToast.toast(message, {
                title: title,
                variant: type,
                solid: true,
                toaster: "b-toaster-top-center",
                autoHideDelay: 8000,
            });
        },
        downloadExcel() {
            this.SET_LOADING(true);
            let filename = this.trans('paegtm.gtm_factor_analysis') + this.formatDate(this.dateStart) + "-" + this.formatDate(this.dateEnd) + ".xlsx";

                this.axios
                    .post(
                        this.localeUrl('/paegtm/aegtm/export-gtm-factors-analysis'),
                        { dzoName: this.dzoName, dateStart: this.dateStart, dateEnd: this.dateEnd, selectedGtm: this.selectedGtm },
                        { responseType: "blob" }
                    )
                    .then((response) => {
                        fileDownload(response.data,filename);
                    })
                    .catch((error) => {
                        this.setNotify(this.trans('paegtm.empty_responce'), this.trans('app.error'), "danger")
                    }).finally(() => this.SET_LOADING(false));
        },
        downloadPdf(){
            this.setNotify(this.trans('paegtm.download_factor_analysis_in_pdf_not_suported'), this.trans('app.error'), "danger")
        },
        formatDate(date) {
            if (date) {
                return moment(date).format('YYYY.MM.DD')
            }
            return null
        }
    },
    created() {
        this.SET_LOADING(false);
    },
    mounted() {
        this.dzosForFilter = this.dzos;
        this.gtmTypes = this.selectedGtm;
    },
}
