import {EventBus} from "../../event-bus.js";
import moment from "moment";

import {dzoMapState, dzoMapActions} from '@store/helpers';


import сompaniesDzo from './dataManagers/dzoCompanies';
import helpers from './dataManagers/helpers';
import oilRates from './widgets/oilRates';
import usdRates from './widgets/usdRates';
import mainStatisticsTable from './widgets/mainStatisticsTable';
import rates from './dataManagers/rates';
import oilProductionFilters from './dataManagers/oilProductionFilters';
import mainTableChart from './widgets/mainTableChart.js';
import secondaryParams from './dataManagers/secondaryParams';
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
import backendProductionParams from './productionParams/index';
import dzoCompaniesNameMapping from "./dzo_companies_consolidated_name_mapping.json";

Vue.component('fonds-daily-chart', require('./charts/fondsDailyChart.vue').default);
Vue.component('otm-drilling-daily-chart', require('./charts/otmDrillingDailyChart.vue').default);



export default {
    props: ['userId'],
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
            productionData: []
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
    },
    mixins: [
        сompaniesDzo,
        helpers,
        oilRates,
        usdRates,
        mainStatisticsTable,
        rates,
        oilProductionFilters,
        mainTableChart,
        secondaryParams,
        productionDetails,
        chemistryDetails,
        wellsWorkoverDetails,
        managers,
        drillingDetails,
        wellsDetails,
        productionFondDetails,
        injectionFondDetails,
        emergency,
        backendProductionParams
    ],
    async mounted() {
        this.SET_LOADING(true);
        this.oneDzoSelected = this.getDzoTicker();
        if (this.oneDzoSelected !== null) {
            this.isOneDzoSelected = true;
            this.assignOneCompanyToSelectedDzo(this.oneDzoSelected);
        }
        this.backendProductionParams = await this.backendGetProductionParamsByCategory();
        this.backendUpdateSummaryFact('oilCondensateProduction','oilCondensateDelivery');
        this.backendProductionTableData = this.backendProductionParams.tableData.current[this.backendSelectedCategory];
        this.productionData = _.cloneDeep(this.backendProductionTableData);
        this.selectedDzoCompanies = this.getAllDzoCompanies();
        this.updateDzoMenu();
        localStorage.setItem("selectedPeriod", "undefined");
        this.getCurrencyNow(new Date().toLocaleDateString());
        this.updatePrices(this.period);
        this.productionFondDetails = await this.getFondByMonth(this.productionFondPeriodStart,this.productionFondPeriodEnd,'production');
        this.productionFondHistory = await this.getFondByMonth(this.productionFondHistoryPeriodStart,this.productionFondHistoryPeriodEnd,'production');
        this.injectionFondDetails = await this.getFondByMonth(this.injectionFondPeriodStart,this.injectionFondPeriodEnd,'injection');
        this.injectionFondHistory = await this.getFondByMonth(this.injectionFondHistoryPeriodStart,this.injectionFondHistoryPeriodEnd,'injection');
        this.chemistryDetails = await this.getChemistryByMonth();
        this.wellsWorkoverDetails = await this.getWellsWorkoverByMonth();
        this.drillingDetails = await this.getDrillingByMonth();
        this.emergencyHistory = await this.getEmergencyByMonth();
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
        this.backendPeriodRange = this.backendPeriodEnd.diff(this.backendPeriodStart, 'days');
        this.backendHistoricalPeriodStart = this.backendPeriodStart.clone().subtract(1,'days');
    },
};
