import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import {paegtmMapActions, paegtmMapGetters, paegtmMapState, globalloadingMutations} from '@store/helpers';
import orgStructure from '../../mock-data/org_structure.json'
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
            mainTableData: [],
            gtmTypesList: [
                {id: "vns", name: this.trans('paegtm.gtm_vns')},
                {id: "grp", name: this.trans('paegtm.gtm_grp')},
                {id: "pvlg", name: this.trans('paegtm.gtm_pvlg')},
                {id: "pvr", name: this.trans('paegtm.gtm_pvr')},
                {id: "rir", name: this.trans('paegtm.gtm_rir')},
            ],
            dzos: orgStructure,
            loaded: false,
            series: [46, 55],
            series1: [44, 55, 41, 17],
            series2: [11, 34, 79, 23],
            donutChart1: {
                chart: {
                    type: 'donut',
                    foreColor: '#fff',
                },
                labels: ['По жидкости', 'По обводненности'],
                colors: ['#3f51b5', '#f0ad81', '#82baff', '#ef5350'],
                stroke: {
                    show: false,
                }
            },
            donutChart2: {
                chart: {
                    type: 'donut',
                    foreColor: '#fff',
                },
                labels: ['Рпл', 'Skin', 'KH/mb', 'Рзаб'],
                colors: ['#3f51b5', '#f0ad81', '#82baff', '#ef5350'],
                stroke: {
                    show: false,
                }
            },
            donutChart3: {
                chart: {
                    type: 'donut',
                    foreColor: '#fff',
                },
                labels: [
                    this.trans('paegtm.development_of_reserves'),
                    this.trans('paegtm.influence_of_ppd'),
                    this.trans('paegtm.neck'),
                    this.trans('paegtm.zkts'),
                ],
                colors: ['#3f51b4', '#ef5350', '#82baff', '#f0ad81'],
                stroke: {
                    show: false,
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
                        return false;
                    }

                    this.mainTableData = data
                }
            }).finally(() => this.SET_LOADING(false));
        },
        getData() {
            this.SET_LOADING(true);
            this.getGtmFactorsData();
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
    },
    created() {
        this.SET_LOADING(false);
    },
    mounted() {
        this.dzosForFilter = this.dzos;
        this.gtmTypes = this.selectedGtm;
    },
}
