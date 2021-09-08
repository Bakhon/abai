import vSelect from "vue-select";
import 'vue-select/dist/vue-select.css'
import orgStructure from '../../mock-data/org_structure.json'
import filterSelect from '../../mixin/selectFilter'
import VueApexCharts from "vue-apexcharts";

export default {
    components: {
        vSelect,
        apexchart: VueApexCharts,
    },
    mixins: [filterSelect],
    data: function () {
        return {
            barSeriesChart1: [{
                name: this.trans('paegtm.plan'),
                data: [3100, 4600, 1900, 2700, 2200, 3200, 500, 990, 2990, 4200, 840, 2500],
            }, {
                name: this.trans('paegtm.fact_plus_forecast'),
                data: [3200, 4700, 1950, 2800, 2400, 3300, 800, 1100, 3100, 4400, 1000, 2700],
            },],
            barSeriesChart2: [{
                name: this.trans('paegtm.plan'),
                data: [16200, 12500, 14000, 13800, 15700, 16200, 15800, 14100, 14400, 14100, 15500, 19100],
            }, {
                name:this.trans('paegtm.fact_plus_forecast'),
                data: [16000, 14500, 14100, 13900, 15800, 17000, 16100, 14200, 14600, 14200, 16200, 18800],
            },],
            lineSeriesChart: [
                {
                    name: this.trans('paegtm.plan'),
                    data: [100, 800, 900, 1400, 1200, 2100, 2900],
                },
                {
                    name: this.trans('paegtm.fact'),
                    data: [200, 900, 1100, 1600, 1700, 2200, 3100],
                }
    ],
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
        barChartOptions1: {
            chart: {
                type: 'bar',
                    height: 350,
                    foreColor: '#fff',
                    horizontal: false
            },
            dataLabels: {
                enabled: false
            },
            colors: ['#f27e31', '#82baff'],
                xaxis: {
                categories: [
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
        },
        dzo: null,
            gtmTypesList: [
                { id: "vns", name: this.trans('paegtm.gtm_vns') },
                { id: "grp", name: this.trans('paegtm.gtm_grp') },
                { id: "pvlg", name: this.trans('paegtm.gtm_pvlg') },
                { id: "pvr", name: this.trans('paegtm.gtm_pvr') },
                { id: "rir", name: this.trans('paegtm.gtm_rir') },
            ],
            loaded: false,
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

methods: {
        getData: function () {

        },
    },
    computed: {
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
    mounted() {
        this.dzosForFilter = this.dzos;
    },
}