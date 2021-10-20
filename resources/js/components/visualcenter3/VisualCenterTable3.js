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
    props: ['userId'],
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
            additionalCompanies: ['ОМГК','АГ']
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
