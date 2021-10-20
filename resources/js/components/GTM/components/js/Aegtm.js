import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import orgStructure from '../../mock-data/org_structure.json'
import {paegtmMapState, globalloadingMutations, paegtmMapGetters} from "@store/helpers";
import VueApexCharts from "vue-apexcharts";
import filterSelect from '../../mixin/selectFilter'

export default {
    components: {
        vSelect,
        apexchart: VueApexCharts,
    },
    mixins: [filterSelect],
    data: function () {
        return {
            comparisonIndicators: [],
            gtmIndicators: [],
            accumOilProdLabels: [],
            accumOilProdFactData: [],
            accumOilProdPlanData: [],
            gtmTypesList: [
                { id: "vns", name: this.trans('paegtm.gtm_vns') },
                { id: "grp", name: this.trans('paegtm.gtm_grp') },
                { id: "pvlg", name: this.trans('paegtm.gtm_pvlg') },
                { id: "pvr", name: this.trans('paegtm.gtm_pvr') },
                { id: "rir", name: this.trans('paegtm.gtm_rir') },
            ],
            dzos: orgStructure,
            loaded: false,
            barChartData: [{
                name: this.trans('paegtm.fact'),
                data: [4.5, 18, 32.3, 45, 58.9, 67, 75.8, 90, 105.6, 117.5, 125.2, 136, 4.5, 18, 32.3, 45, 58.9, 67, 75.8, 90, 105.6, 117.5, 125.2, 136, 4.5, 18, 32.3, 45, 58.9, 67, 75.8, 90, 105.6, 117.5, 125.2, 136],
            }, {
                name: this.trans('paegtm.plan') ,
                data:  [28.1, 32, 46.2, 60, 74.7, 75, 91, 98, 107.8, 131, 134.4, 138, 28.1, 32, 46.2, 60, 74.7, 75, 91, 98, 107.8, 131, 134.4, 138, 28.1, 32, 46.2, 60, 74.7, 75, 91, 98, 107.8, 131, 134.4, 138],
            },],
            donutChartData: [45,60],
            lineChartOptions: {
                chart: {
                    type: 'line',
                    height: 350,
                    foreColor: '#fff',
                },
                markers: {
                    size: 5,
                    colors: undefined,
                    strokeColors: '#fff',
                    strokeWidth: 2,
                    discrete: [],
                    shape: "circle",
                    radius: 2,
                },
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
                },

            },
            lineSeriesChart: [
                {
                    name: this.trans('paegtm.plan'),
                    data: this.accumOilProdPlanData,
                },
                {
                    name: this.trans('paegtm.fact'),
                    data: this.accumOilProdFactData,
                }
            ],
            barChartOptions: {
                chart: {
                    type: 'bar',
                    height: 350,
                    foreColor: '#fff',
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '100%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Jet_2596', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_4937',
                        'Jet_2596', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_4937',
                        'Jet_2596', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_4937',
                        'Jet_2596', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303'],
                },
                fill: {
                    opacity: 1
                },
            },
            donutChartOptions: {
                chart: {
                    type: 'donut',
                    foreColor: '#fff',
                },
                plotOptions: {
                    donut: {
                        size: '1%'
                    }
                },
                labels:[
                    this.trans('paegtm.successful'),
                    this.trans('paegtm.unsuccessful')
                ],
                colors: ['#4caf50', '#ef5350'],
                stroke: {
                    show: false,
                }
            },
            dzo: null,
            oilFileds: [],
            horizonts: [],
            objects: [],
            gtmTypes : [],

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
        ]),
        ...paegtmMapGetters([
            'dzoId',
            'dzoName',
        ]),
        accumOilProdData: function () {
            return [
                {
                    label: this.trans('paegtm.fact'),
                    borderColor: "#F27E31",
                    backgroundColor: '#F27E31',
                    data: this.accumOilProdFactData,
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: this.trans('paegtm.plan'),
                    borderColor: "#82BAFF",
                    backgroundColor: '#82BAFF',
                    data: this.accumOilProdPlanData,
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                }
            ]
        },
        selectAllGtms: {
            get: function () {
                return this.gtmTypesList ? this.gtmTypes.length == this.gtmTypesList.length : false;
            },
            set: function (value) {
                let selected = [];

                if (value) {
                    this.gtmTypesList.forEach(function (gtm) {
                        selected.push(gtm.id);
                    });
                }

                this.gtmTypes = selected;
            }
        }
    },
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        getData() {
            this.SET_LOADING(true);
            this.axios.get(
                this.localeUrl('/paegtm/accum_oil_prod_data'),
                {params: {dateStart: this.dateStart, dateEnd: this.dateEnd}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    let accumOilProdFactData = [];
                    let accumOilProdPlanData = [];
                    this.accumOilProdLabels = [];
                    data.forEach((item) => {
                        this.accumOilProdLabels.push(item.date)
                        accumOilProdFactData.push(Math.round(item.accumOilProdFactData))
                        accumOilProdPlanData.push(Math.round(item.accumOilProdPlanData))
                    });
                    this.accumOilProdFactData = accumOilProdFactData;
                    this.accumOilProdPlanData = accumOilProdPlanData;
                }
                this.loaded = true;
            });
            this.axios.get(
                this.localeUrl('/paegtm/comparison_indicators_data'),
                {params: {dateStart: this.dateStart, dateEnd: this.dateEnd}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    this.comparisonIndicators = [];
                    data.forEach((item) => {
                        this.comparisonIndicators.push([
                            item.gtm_kind,
                            '-',
                            item.wellsCount,
                            Math.round(item.avgDebitPlan * 100) / 100,
                            Math.round(item.avgDebitFact * 100) / 100,
                            Math.round(item.plan_add_prod_12m),
                            Math.round(item.add_prod_12m),
                        ])
                    });
                }
            });
            this.axios.get(
                this.localeUrl('/paegtm/aegtm/get-comparison-table-data'),
                {params: {dzoName: this.dzoName, dateStart: this.dateStart, dateEnd: this.dateEnd}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    console.log(data);
                    if (typeof data == 'undefined' || !data.length) {
                        this.setNotify("Отсутствуют данные по плановым и фактическим показателям. Попробуйте изменить параметры фильтра.", "Ошибка", "danger")
                    }

                    this.gtmIndicators = [];
                    data.forEach((item) => {
                        this.gtmIndicators.push([
                            item.gtm,
                            item.plan,
                            item.fact,
                            '-',
                            '-',
                            '-',
                            '-',
                        ])
                    });
                }
            });
            this.SET_LOADING(false);
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
    },
    mounted() {
        this.dzosForFilter = this.dzos;
    },
}