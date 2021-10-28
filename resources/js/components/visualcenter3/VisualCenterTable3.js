import {EventBus} from "../../event-bus.js";
import moment from "moment";

import {dzoMapState, dzoMapActions} from '@store/helpers';


import сompaniesDzo from './dataManagers/dzoCompanies';
import helpers from './dataManagers/helpers';
import oilRates from './widgets/oilRates';
import usdRates from './widgets/usdRates';
import mainStatisticsTable from './widgets/mainStatisticsTable';
import rates from './dataManagers/rates';
import mainTableChart from './widgets/mainTableChart.js';
import productionDetails from './widgets/productionDetails';
import chemistryDetails from './widgets/chemistryDetails';
import wellsWorkoverDetails from './widgets/wellsWorkoverDetails';
import managers from './widgets/managers';
import drillingDetails from './widgets/otmDrillingDetails';
import productionFondDetails from './widgets/productionFondDetails';
import wellsDetails from './dataManagers/wellsDetails';
import injectionFondDetails from './widgets/injectionFondDetails';
import emergency from './widgets/emergency';
import {globalloadingMutations} from '@store/helpers';
import Vue from "vue";
import productionParams from './productionParams/index';
import dzoCompaniesNameMapping from "./dzo_companies_consolidated_name_mapping.json";
import DatePicker from "v-calendar/lib/components/date-picker.umd";

Vue.component('fonds-daily-chart', require('./charts/fondsDailyChart.vue').default);
Vue.component('otm-drilling-daily-chart', require('./charts/otmDrillingDailyChart.vue').default);
Vue.component('modal-reasons', require('./widgets/modalReasonExplanations.vue').default);



export default {
    props: ['userId','oilDynamicRoute'],
    components: {
        "date-picker": DatePicker
    },
    data: function () {
        return {
            dzoMapping : {
                "КОА" : {                 
                   id: 110                   
                },
                "КТМ" : {                    
                    id: 107
                },
                "КБМ" : {                    
                    id: 106
                },
                "КГМ" : {
                    id: 108
                },
                "ММГ" : {
                    id: 109
                },
                "ОМГ" : {
                    id: 112
                },
                "УО" : {
                    id: 111
                },
                "ЭМГ" : {
                    id: 113
                },
                "АГ" : {
                    id: 0
                },
            },
            oneDzoSelected: null,
            isOneDzoSelected: false,
            oilChartHeadName: this.trans('visualcenter.getoildynamic'),
            index: "",
            NameDzoFull: {
                'ОМГ': this.trans("visualcenter.omg"),
                'ЭМГ': this.trans("visualcenter.emg"),
                'КБМ': this.trans("visualcenter.kbm"),
                'КГМ': this.trans("visualcenter.kgm"),
                'ТШ': this.trans("visualcenter.tsho"),
                'ТШО': this.trans("visualcenter.tsho"),
                'ММГ': this.trans("visualcenter.mmg"),
                'КТМ': this.trans("visualcenter.ktm"),
                'КОА': this.trans("visualcenter.koa"),
                'ПКИ': this.trans("visualcenter.pki"),
                'АМГ': this.trans("visualcenter.ag"),
                'АГ': this.trans("visualcenter.ag"),
                'КПО': this.trans("visualcenter.kpo"),
                'НКО': this.trans("visualcenter.nko"),
                'ТП': this.trans("visualcenter.tp"),
                'УО': this.trans("visualcenter.uo"),
                'ПКК': this.trans("visualcenter.pkk"),
                'КГМКМГ': this.trans("visualcenter.kgm"),
                'ПККР': this.trans("visualcenter.pkk"),
            },
            chartHeadName: this.trans("visualcenter.oilCondensateProductionChartName"),
            chartSecondaryName: this.trans('visualcenter.oilCondensateProduction'),
            metricName: this.trans("visualcenter.chemistryMetricTon"),
            injectionWellsOptions: [
                {ticker: 'all', name: this.trans("visualcenter.allCompany")},
                {ticker: 'ОМГ', name: this.trans("visualcenter.omg")},
                {ticker: 'ММГ', name: this.trans("visualcenter.mmg")},
                {ticker: 'КГМ', name: this.trans("visualcenter.kgm")},
                {ticker: 'КОА', name: this.trans("visualcenter.koa")},
                {ticker: 'КТМ', name: this.trans("visualcenter.ktm")},
                {ticker: 'КБМ', name: this.trans("visualcenter.kbm")},
                {ticker: 'ЭМГ', name: this.trans("visualcenter.emg")},
            ],
            dzoNameMapping: _.cloneDeep(dzoCompaniesNameMapping.dzoNameMapping),
            dzoNameMappingWithoutKMG: _.cloneDeep(dzoCompaniesNameMapping.dzoNameMappingWithoutKMG),
            dzoNameMappingNormal: _.cloneDeep(dzoCompaniesNameMapping.normalNames),
            timeSelect: "",
            productionData: [],
            reasonExplanations: {},
            troubleCompanies: ['ОМГК','КГМКМГ','ТП','ПККР'],
            dzoWithOpekRestriction: ['ОМГ','ММГ','ЭМГ','КБМ'],
            additionalCompanies: ['ОМГК','АГ'],
            missedCompanies: [],
            yearlyData: {
                'oilCondensateProduction': [{"id":"1.1.","name":"ОМГ","fact":4369671,"plan":4551362,"opek":4369465,"condensatePlan":3796.54838693,"condensateFact":3821,"condensateOpek":3796.54838693,"decreaseReasonExplanations":["Отклонение связано с ПП РК об ограничении добычи нефти на отдельных месторождениях в рамках ОПЕК+"],"yearlyPlan":5564864},{"id":"","name":"ОМГК","fact":3830,"plan":3785,"opek":3785,"condensatePlan":3796.54838693,"condensateFact":3821,"condensateOpek":3796.54838693,"decreaseReasonExplanations":[],"yearlyPlan":4623},{"id":"1.2.","name":"ММГ","fact":2403992,"plan":2480615,"opek":2408048,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":["Отклонение связано с ПП РК об ограничении добычи нефти на отдельных месторождениях в рамках ОПЕК+"],"yearlyPlan":3025226},{"id":"1.3.","name":"ЭМГ","fact":2042744,"plan":2203024,"opek":2042191,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":["Отклонение связано с ПП РК об ограничении добычи нефти на отдельных месторождениях в рамках ОПЕК+"],"yearlyPlan":2695000},{"id":"1.4.","name":"КБМ","fact":856370,"plan":875979,"opek":856824,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":["Отклонение связано с ПП РК об ограничении добычи нефти на отдельных месторождениях в рамках ОПЕК+"],"yearlyPlan":1069546.5},{"id":"1.5.","name":"КГМ","fact":604127,"plan":603965,"opek":603965,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":726452.905811625},{"id":"1.6.","name":"КТМ","fact":352993,"plan":349070,"opek":349070,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":429477.33876008},{"id":"1.7.","name":"КОА","fact":244422,"plan":247207,"opek":243610,"condensatePlan":-1,"condensateFact":7966,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":301627.5},{"id":"1.8.","name":"УО","fact":39925,"plan":43963,"opek":43963,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":71539},{"id":"1.9.","name":"ТШО","fact":4206579,"plan":4574243,"opek":4212572,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":5657481.5754245},{"id":"1.10.","name":"НКО","fact":1061144,"plan":1112266,"opek":1024644,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":1388860.1785518574},{"id":"1.11.","name":"КПО","fact":829096,"plan":866090,"opek":866090,"condensatePlan":-1,"condensateFact":1392540,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":1070491.57},{"id":"1.12.","name":"ПКИ","fact":498199,"plan":479825,"opek":479825,"monthlyPlan":0,"yearlyPlan":579094.2030851259,"decreaseReasonExplanations":[]},{"id":"","name":"ПККР","fact":255364,"plan":236866,"opek":236866,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":286445.56800554314},{"id":"","name":"КГМКМГ","fact":199362,"plan":199309,"opek":199309,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":239729.45891783625},{"id":"","name":"ТП","fact":43472,"plan":43650,"opek":43650,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":52919.17616174641},{"id":"1.13.","name":"АГ","fact":11149,"plan":12124,"opek":12124,"condensatePlan":12168.096773930001,"condensateFact":11556.22,"condensateOpek":12168.096773930001,"decreaseReasonExplanations":[],"yearlyPlan":15062.24828294}],
                'oilCondensateProductionWithoutKMG': [{"id":"2.1.","name":"ОМГ","fact":4369671,"plan":4551362,"opek":4369465,"condensatePlan":3796.54838693,"condensateFact":3821,"condensateOpek":3796.54838693,"decreaseReasonExplanations":["Отклонение связано с ПП РК об ограничении добычи нефти на отдельных месторождениях в рамках ОПЕК+"],"yearlyPlan":5564864},{"id":"","name":"ОМГК","fact":3830,"plan":3785,"opek":3785,"condensatePlan":3796.54838693,"condensateFact":3821,"condensateOpek":3796.54838693,"decreaseReasonExplanations":[],"yearlyPlan":4623},{"id":"2.2.","name":"ММГ","fact":4807984,"plan":4961230,"opek":4816095,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":["Отклонение связано с ПП РК об ограничении добычи нефти на отдельных месторождениях в рамках ОПЕК+"],"yearlyPlan":6050452},{"id":"2.3.","name":"ЭМГ","fact":2042744,"plan":2203024,"opek":2042191,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":["Отклонение связано с ПП РК об ограничении добычи нефти на отдельных месторождениях в рамках ОПЕК+"],"yearlyPlan":2695000},{"id":"2.4.","name":"КБМ","fact":1712739,"plan":1751958,"opek":1713647,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":["Отклонение связано с ПП РК об ограничении добычи нефти на отдельных месторождениях в рамках ОПЕК+"],"yearlyPlan":2139093},{"id":"2.5.","name":"КГМ","fact":1208254,"plan":1207930,"opek":1207931,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":1452905.81162325},{"id":"2.6.","name":"КТМ","fact":352993,"plan":349070,"opek":349070,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":429477.33876008},{"id":"2.7.","name":"КОА","fact":488843,"plan":494414,"opek":487220,"condensatePlan":-1,"condensateFact":7966,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":603255},{"id":"2.8.","name":"УО","fact":39925,"plan":43963,"opek":43963,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":71539},{"id":"2.9.","name":"ТШО","fact":21032894,"plan":22871217,"opek":21062861,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":28287407.8771225},{"id":"2.10.","name":"КПО","fact":8290963,"plan":8660900,"opek":8660900,"condensatePlan":-1,"condensateFact":1392540,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":10704915.7},{"id":"2.11.","name":"НКО","fact":12818777,"plan":13436338,"opek":12377851,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":16777632.5704743},{"id":"2.12.","name":"ТП","fact":263469,"plan":264548,"opek":264548,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":320722.27976816},{"id":"2.13.","name":"ПККР","fact":773831,"plan":717777,"opek":717777,"condensatePlan":-1,"condensateFact":0,"condensateOpek":-1,"decreaseReasonExplanations":[],"yearlyPlan":868016.87274407},{"id":"2.13.","name":"АГ","fact":11149,"plan":12124,"opek":12124,"condensatePlan":12168.096773930001,"condensateFact":11556.22,"condensateOpek":12168.096773930001,"decreaseReasonExplanations":[],"yearlyPlan":15062.24828294}]
            }
        };
    },
    methods: {
        ...dzoMapActions([
            'getYearlyPlan'
        ]),
        ...globalloadingMutations([
            'SET_LOADING'
        ]),

        getDzoTicker() {
            let dzoTicker = null;
            let self = this;
            _.forEach(Object.keys(this.dzoMapping), function(key) {
               if (parseInt(self.dzoMapping[key].id) === parseInt(self.userId)) {                
                   dzoTicker = key;
               }
            });
            return dzoTicker;
        },

        disableTargetCompanyFilter() {
            this.$refs.targetPlan.classList.remove('show');
            this.isFilterTargetPlanActive = false;
            this.buttonTargetPlan = "";
        },

        disableRegions() {
            _.forEach(this.dzoRegionsMapping, (item) => {
                _.set(item, 'isActive', false);
            });
        },

        changeAssets(type) {
            this.disableRegions();
            this.dzoCompaniesAssets['isAllAssets'] = false;
            this.dzoCompaniesAssets[type] = !this.dzoCompaniesAssets[type];
            this.disableDzoCompaniesVisibility();
            let selectedTypes = [];
            _.forEach(this.dzoCompaniesAssets, (asset,key) => {
                if (asset && typeof asset === "boolean") {
                    selectedTypes.push(key);
                    this.switchCompanies('type',key);
                }
            });
            this.switchCompaniesVisibility(selectedTypes,'type');
        },

        switchCompaniesVisibility(types,type) {
            if (types.length === 0) {
                this.dzoCompaniesAssets['isAllAssets'] = true;
                return this.selectAllDzoCompanies();
            }
            this.selectedDzoCompanies = _.cloneDeep(this.dzoCompanies).filter(company => types.includes(company[type])).map(company => company.ticker);
            this.productionData = this.getFilteredTableData();
            this.productionChartData = this.getSummaryForChart();
            this.exportDzoCompaniesSummaryForChart(this.productionChartData);
        },


        getReasonExplanations() {
            let reasons = {};
            this.productionTableData = this.getProductionDataByOpekRestriction();
            _.forEach(this.productionTableData, (item) => {
                if (item.decreaseReasonExplanations && item.decreaseReasonExplanations.length > 0) {
                    reasons[item.name] = item.decreaseReasonExplanations;
                }
            });
            return reasons;
        },

        switchCompanies(type,name) {
            _.map(this.dzoCompanies, function(company) {
                if (company[type] === name) {
                    company.selected = !company.selected;
                }
            });
        },

        changeRegions(region) {
            this.disableAssets();
            this.dzoRegionsMapping[region].isActive = !this.dzoRegionsMapping[region].isActive;
            this.disableDzoCompaniesVisibility();
            let selectedRegions = [];
            _.forEach(this.dzoRegionsMapping, (region,key) => {
                if (region.isActive) {
                    selectedRegions.push(key);
                    this.switchCompanies('region',key);
                }
            });
            this.switchCompaniesVisibility(selectedRegions,'region');
        },

        disableAssets() {
            _.forEach(this.dzoCompaniesAssets, (asset,key) => {
                if (typeof asset === 'boolean') {
                    this.dzoCompaniesAssets[key] = false;
                }
            });
        },

        getProductionDataByOpekRestriction() {
            let updatedByOpek = _.cloneDeep(this.productionTableData);
            _.forEach(updatedByOpek, (item) => {
                if (item.decreaseReasonExplanations && this.dzoWithOpekRestriction.includes(item.name)) {
                    item.decreaseReasonExplanations.push(this.trans('visualcenter.opekExplanationReason'));
                }
            });
            return updatedByOpek;
        },

        isTroubleCompany(dzoName) {
            if ((this.mainMenu.oilCondensateDeliveryWithoutKMG || this.mainMenu.oilCondensateProductionWithoutKMG) && ['ТП','ПККР'].includes(dzoName)) {
                return false;
            }
            return this.troubleCategories.includes(this.selectedCategory) && this.troubleCompanies.includes(dzoName);
        },
        getAdditionalName(dzoName) {
            return this.trans('visualcenter.condensate');
        },
        async updateFondsByPreviousDay() {
            if (this.productionFondDetails.length === 0) {
                this.productionFondPeriodStart = moment(this.productionFondPeriodStart,'DD.MM.YYYY').subtract(1, 'days').startOf('day').format('DD.MM.YYYY');
                this.productionFondPeriodEnd = moment(this.productionFondPeriodStart,'DD.MM.YYYY').clone().endOf('day').format('DD.MM.YYYY');
                this.productionFondHistoryPeriodStart = moment(this.productionFondHistoryPeriodStart,'DD.MM.YYYY').subtract(1, 'days').startOf('day').format('DD.MM.YYYY');
                this.productionFondHistoryPeriodEnd = moment(this.productionFondHistoryPeriodEnd,'DD.MM.YYYY').subtract(1, 'days').startOf('day').format('DD.MM.YYYY');
                this.productionFondDetails = await this.getFondByMonth(this.productionFondPeriodStart,this.productionFondPeriodEnd,'production');
                this.productionFondHistory = await this.getFondByMonth(this.productionFondHistoryPeriodStart,this.productionFondHistoryPeriodEnd,'production');
            }
            if (this.injectionFondDetails.length === 0) {
                this.injectionFondPeriodStart = moment(this.injectionFondPeriodStart,'DD.MM.YYYY').subtract(1, 'days').startOf('day').format('DD.MM.YYYY');
                this.injectionFondPeriodEnd = moment(this.injectionFondPeriodStart,'DD.MM.YYYY').clone().endOf('day').format('DD.MM.YYYY');
                this.injectionFondHistoryPeriodStart = moment(this.injectionFondHistoryPeriodStart,'DD.MM.YYYY').subtract(1, 'days').startOf('day').format('DD.MM.YYYY');
                this.injectionFondHistoryPeriodEnd = moment(this.injectionFondHistoryPeriodEnd,'DD.MM.YYYY').subtract(1, 'days').startOf('day').format('DD.MM.YYYY');
                this.injectionFondDetails = await this.getFondByMonth(this.injectionFondPeriodStart,this.injectionFondPeriodEnd,'injection');
                this.injectionFondHistory = await this.getFondByMonth(this.injectionFondHistoryPeriodStart,this.injectionFondHistoryPeriodEnd,'injection');
            }
        },
        async getMissedCompanies() {
            let uri = this.localeUrl("/get-missed-companies");
            const response = await axios.get(uri);
            if (response.status !== 200) {
                return [];
            }
            return response.data;
        }
    },
    mixins: [
        сompaniesDzo,
        helpers,
        oilRates,
        usdRates,
        mainStatisticsTable,
        rates,
        mainTableChart,
        productionDetails,
        chemistryDetails,
        wellsWorkoverDetails,
        managers,
        drillingDetails,
        wellsDetails,
        productionFondDetails,
        injectionFondDetails,
        emergency,
        productionParams
    ],
    async mounted() {
        this.SET_LOADING(true);
        this.oneDzoSelected = this.getDzoTicker();
        this.missedCompanies = await this.getMissedCompanies();
        if (this.oneDzoSelected !== null) {
            this.isOneDzoSelected = true;
            this.assignOneCompanyToSelectedDzo(this.oneDzoSelected);
        }
        this.productionParams = await this.getProductionParamsByCategory();
        this.updateSummaryFact('oilCondensateProduction','oilCondensateDelivery');
        this.productionTableData = this.productionParams.tableData.current[this.selectedCategory];
        this.reasonExplanations = this.getReasonExplanations();
        this.productionData = _.cloneDeep(this.productionTableData);
        this.selectedDzoCompanies = this.getAllDzoCompanies();
        this.updateDzoMenu();
        localStorage.setItem("selectedPeriod", "undefined");
        this.getCurrencyNow(new Date().toLocaleDateString());
        this.updatePrices(this.period);
        if (moment().date() < 11) {
            this.wellsWorkoverPeriodStartMonth = moment(this.wellsWorkoverPeriodStartMonth,'MMMM YYYY').subtract(1,'months').format('MMMM YYYY');
            this.wellsWorkoverPeriodEndMonth = moment(this.wellsWorkoverPeriodEndMonth,'MMMM YYYY').subtract(1,'months').format('MMMM YYYY');
            this.chemistryPeriodStartMonth = moment(this.chemistryPeriodStartMonth,'MMMM YYYY').subtract(1,'months').format('MMMM YYYY');
            this.chemistryPeriodEndMonth = moment(this.chemistryPeriodEndMonth,'MMMM YYYY').subtract(1,'months').format('MMMM YYYY');
        }
        this.productionFondDetails = await this.getFondByMonth(this.productionFondPeriodStart,this.productionFondPeriodEnd,'production');
        this.productionFondHistory = await this.getFondByMonth(this.productionFondHistoryPeriodStart,this.productionFondHistoryPeriodEnd,'production');
        this.injectionFondDetails = await this.getFondByMonth(this.injectionFondPeriodStart,this.injectionFondPeriodEnd,'injection');
        this.injectionFondHistory = await this.getFondByMonth(this.injectionFondHistoryPeriodStart,this.injectionFondHistoryPeriodEnd,'injection');
        if (this.productionFondDetails.length === 0 && this.injectionFondDetails.length === 0) {
            await this.updateFondsByPreviousDay();
        }
        this.chemistryDetails = await this.getChemistryByMonth();
        this.wellsWorkoverDetails = await this.getWellsWorkoverByMonth();
        this.drillingDetails = await this.getDrillingByMonth();
        this.emergencyHistory = await this.getEmergencyByMonth();
        this.fillEmergencyByType();
        this.dzoMonthlyPlans = await this.getDzoMonthlyPlans();
        this.dzoCompanies = _.cloneDeep(this.dzoCompaniesTemplate);
        this.dzoCompaniesAssets = _.cloneDeep(this.dzoCompaniesAssetsInitial);

        this.updateChemistryWidget();
        this.updateWellsWorkoverWidget();
        this.updateDrillingWidget();
        await this.updateProductionFondWidget();
        this.SET_LOADING(true);
        await this.updateInjectionFondWidget();
        this.SET_LOADING(false);
    },
    created() {
        this.periodRange = this.periodEnd.diff(this.periodStart, 'days');
        this.historicalPeriodStart = this.periodStart.clone().subtract(1,'days');
    },
};
