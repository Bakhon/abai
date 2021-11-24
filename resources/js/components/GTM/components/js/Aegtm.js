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
            accumOilProdPlanData: [],
            accumOilProdFactData: [],
            gtmIndicators: [],
            accumOilProdLabels: [],
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
                dataLabels: {
                    enabled: false,
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
                        fontSize: '12px',
                        fontWeight: 'normal'
                    },
                    offsetY: -7
                },
                legend: {
                    show: true,
                }
            },
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
                this.localeUrl('/paegtm/aegtm/get-accumulated-oil-data'),
                {params: {dzoName: this.dzoName, dateStart: this.dateStart, dateEnd: this.dateEnd}}
            ).then((response) => {
                let data = response.data;

                if (data && data.series) {
                    this.accumOilProdPlanData = data.series;
                    this.accumOilProdFactData = data.series;

                    this.lineChartOptions.labels = data.months;

                    if(typeof this.$refs.accumOilProdChart !== 'undefined') {
                        this.$refs.accumOilProdChart.updateOptions({ labels: data.months });
                    }
                }

                this.loaded = true;
            });
            this.axios.get(
                this.localeUrl('/paegtm/aegtm/get-comparison-table-data'),
                {params: {dzoName: this.dzoName, dateStart: this.dateStart, dateEnd: this.dateEnd}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    if (typeof data != 'object' || !data.length) {
                        this.setNotify(this.trans('paegtm.aegtm_invalid_data'), this.trans('app.error'), "danger")
                        return false;
                    }

                    this.gtmIndicators = [];
                    data.forEach((item) => {
                        this.gtmIndicators.push([
                            item.gtm,
                            item.count_plan,
                            item.count_fact,
                            item.avg_increase_plan,
                            item.avg_increase_fact,
                            item.add_prod_plan,
                            item.add_prod_fact,
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
    created() {}
}