import {EventBus} from "../../event-bus.js";
import moment from "moment";
import Calendar from "v-calendar/lib/components/calendar.umd";
import DatePicker from "v-calendar/lib/components/date-picker.umd";
import {isString} from "lodash";

import mainMenuConfiguration from './main_menu_configuration.json';
import {dzoMapState, dzoMapActions} from '@store/helpers';

import mainMenu from './widgets/mainMenu';
import сompaniesDzo from './dataManagers/dzoCompanies';
import helpers from './dataManagers/helpers';
import otm from './dataManagers/otm';
import chemistry from './dataManagers/chemistry';
import oilRates from './widgets/oilRates';
import usdRates from './widgets/usdRates';
import injectionWells from './widgets/injectionWells';
import productionWells from './widgets/productionWells';
import companyStaff from './widgets/companyStaff';
import mainStatisticsTable from './widgets/mainStatisticsTable';
import wells from './dataManagers/wells';
import rates from './dataManagers/rates';
import dates from './dataManagers/dates';
import oilProductionFilters from './dataManagers/oilProductionFilters';
import mainTableChart from './widgets/mainTableChart.js';
import secondaryParams from './dataManagers/secondaryParams';


Vue.component("calendar", Calendar);
Vue.component("date-picker", DatePicker);
import Vue from "vue";



export default {
    components: {
        Calendar,
        DatePicker
    },
    data: function () {
        return {
            drillingWells: 0,
            otmKrsSkv: 0,
            otmPrsSkv: 0,
            accidentTotal: '',
            noData: '',
            personalFact: '',
            oilChartHeadName: this.trans('visualcenter.getoildynamic'),
            productionFactPercentOneDzo: '',
            productionFactPercentSumm: '',
            quantityRange: '',
            productionFactPersent: '',
            productionPlanPersent: '',
            index: "",
            widthProgress: "90",
            NameDzoFull: {
                0: "Всего добыча нефти с учётом доли участия АО НК КазМунайГаз",
                1: "(конденсат)(100%)",
                2: "в т.ч.:газовый конденсат",
                3: 'АО ПетроКазахстан Инк',
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
            },
            bigTable: [],
            starts: [""],
            series: ["", ""],
            factYearSumm: "",
            planYearSumm: "",
            planMonthSumm: "",
            factMonthSumm: "",
            factDaySumm: "",
            planDaySumm: "",
            timestampToday: "",
            timestampEnd: "",
            isPricesChartLoading: false,
            chartHeadName: this.trans("visualcenter.getoil"),
            chartSecondaryName: this.trans('visualcenter.getoil'),
            planFieldName: "oil_plan",
            factFieldName: "oil_fact",
            metricName: this.trans("visualcenter.chemistryMetricTon"),
            productionParams : {
                oil_plan: 0,
                oil_fact: 0,
                oil_dlv_plan: 0,
                oil_dlv_fact: 0,
                gas_plan: 0,
                gas_fact: 0,
            },
            dailyProgressBars: {
                oilDelivery: 0,
                oil: 0,
                gas: 0,
            },
            productionPercentParams: {
                oil_fact: 0,
                oil_dlv_fact: 0,
                gas_fact: 0
            },
            chemistryDataFactSumm: 0,
        };
    },
    methods: {
        ...dzoMapActions([
            'getYearlyPlan'
        ]),

        async getDzoYearlyPlan() {
            await this.getYearlyPlan();
        },

        getProductionOilandGas(data) {
            let self = this;
            data = this.getFilteredCompaniesList(data);
            let productionDataInPeriodRange = this.getProductionDataInPeriodRange(data,this.timestampToday,this.timestampEnd);
            let productionSummary = this.getProductionSummary(productionDataInPeriodRange);
            this.updateProductionSummary(productionSummary,this.productionParams);
            this.dailyProgressBars.oil = this.getProductionProgressBarData('oil_plan','oil_fact');
            this.dailyProgressBars.oilDelivery = this.getProductionProgressBarData('oil_dlv_plan','oil_dlv_fact');
            this.dailyProgressBars.gas = this.getProductionProgressBarData('gas_plan','gas_fact');
        },
        
        getProductionSummary(data) {
            return _(data)
                .groupBy("dzo")
                .map((dzo, id) => ({
                    dzo: id,
                    oil_plan: _.round(_.sumBy(dzo, 'oil_plan'), 0),
                    oil_fact: _.round(_.sumBy(dzo, 'oil_fact'), 0),
                    oil_dlv_plan: _.round(_.sumBy(dzo, 'oil_dlv_plan'), 0),
                    oil_dlv_fact: _.round(_.sumBy(dzo, 'oil_dlv_fact'), 0),
                    gas_plan: _.round(_.sumBy(dzo, 'gas_plan'), 0),
                    gas_fact: _.round(_.sumBy(dzo, 'gas_fact'), 0),
                }))
                .value();
        },

        updateProductionSummary(data,productionParams) {
            let self = this;
            _.forEach(Object.keys(productionParams), function(itemName) {
                productionParams[itemName] = _.sumBy(data,itemName);
            });
        },

        getProductionOilandGasPercent(data) {
            data = this.getFilteredCompaniesList(data);
            let periodStart = moment(new Date(this.timestampToday), "DD-MM-YYYY").subtract(this.quantityRange, 'days');
            let filteredDataByPeriodRange = this.getProductionDataInPeriodRange(data,periodStart,this.timestampToday);
            this.setPreviousPeriod();
            let productionSummary = this.getProductionSummary(filteredDataByPeriodRange);
            this.updateProductionSummary(productionSummary,this.productionPercentParams);
        },

        updateProductionData(planFieldName, factFieldName, chartHeadName, metricName, chartSecondaryName) {
            this.$store.commit('globalloading/SET_LOADING', true);
            if (this.isMainMenuItemChanged) {
                this.mainMenuButtonElementOptions = _.cloneDeep(mainMenuConfiguration);
            }
            this.isOneDateSelected = this.isOneDatePeriodSelected();
            this.updateNamesParams(planFieldName,factFieldName,chartHeadName,metricName,chartSecondaryName);

            let oilProductionFieldsNames = ['oil_plan','oil_opek_plan'];
            if (oilProductionFieldsNames.includes(this.planFieldName)) {
                this.changeOilProductionFilters();
            } else {
                this.isOpecFilterActive = false;
                this.isKmgParticipationFilterActive = false;
            }
            this.processProductionData(metricName,chartSecondaryName);
        },

        async processProductionData(metricName,chartSecondaryName) {
            let productionData = await this.getProductionDataByPeriod();
            if (productionData && Object.keys(productionData).length > 0) {
                this.processProductionDataByCompanies(productionData,metricName,chartSecondaryName);
            }
            this.$store.commit('globalloading/SET_LOADING', false);
        },

        async getProductionDataByPeriod() {
            let uri = this.localeUrl("/visualcenter3GetData?timestampToday=") + this.timestampToday + "&timestampEnd=" + this.timestampEnd + " ";
            const response = await axios.get(uri);
            if (response.status === 200) {
                return response.data;
            }
            return {};
        },

        processProductionDataByCompanies(productionData,metricName,chartSecondaryName) {
            if (this.company === "all") {
                productionData = this.getProcessedDataForAllCompanies(productionData);
            } else {
                this.processDataForSpecificCompany(productionData, metricName, chartSecondaryName);
            }
            this.setColorToMainMenuButtons();
            this.getProductionOilandGas(productionData);
            this.getProductionOilandGasPercent(productionData);
        },

        processDataForSpecificCompany(data, metricName, chartSecondaryName) {
            let self = this;
            let filteredDataByCompanies = this.getFilteredCompaniesList(data);
            let filteredDataByPeriod = this.getProductionDataInPeriodRange(filteredDataByCompanies,this.timestampToday,this.timestampEnd);
            filteredDataByPeriod = this.getDataOrderedByAsc(filteredDataByPeriod);

            this.getProductionPercentCovid(filteredDataByPeriod);
            this.updateSecondaryParams(data);

            if (this.isOneDateSelected) {
                let filteredDataByOneDay = this.getFilteredDataByOneDay(filteredDataByCompanies);
                this.dzoCompaniesSummaryForChart = this.getProductionForChart(filteredDataByOneDay);
            } else {
                this.dzoCompaniesSummaryForChart = this.getProductionForChart(filteredDataByPeriod);
            }
            this.exportDzoCompaniesSummaryForChart();

            let summaryDataByDzo = this.getSummaryDataByDzo(filteredDataByPeriod);

            if (this.isProductionDataNull(summaryDataByDzo)) {
                this.company = "all";
                this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, metricName, chartSecondaryName);
            }

            this.addOpecToDzoSummary(filteredDataByPeriod, summaryDataByDzo);
            this.tables = summaryDataByDzo;
        },

        getSummaryDataByDzo(data) {
            let self = this;
            return _(data)
                .groupBy("dzo")
                .map((dzo, id) => ({
                    dzo: id,
                    opec: _.sumBy(dzo, 'opec2'),
                    impulses: _.sumBy(dzo, 'impulses'),
                    landing: _.sumBy(dzo, 'landing'),
                    accident: _.sumBy(dzo, 'accident'),
                    restrictions: _.sumBy(dzo, 'restrictions'),
                    otheraccidents: _.sumBy(dzo, 'otheraccidents'),
                    factMonth: _.round(_.sumBy(dzo, self.factFieldName), 0),
                    planMonth: _.round(_.sumBy(dzo, self.planFieldName), 0),
                    dzoMonth: id,
                }))
                .value();
        },

        isProductionDataNull(summaryDataByDzo) {
            return (summaryDataByDzo['0']['factMonth'] + summaryDataByDzo['0']['planMonth']) === 0;
        },

        getProcessedDataForAllCompanies(data) {
            let self = this;
            var dzo = [];
            var factYear = [];
            var planYear = [];

            var dataWithMay = new Array();

            dataWithMay = _.filter(data, function (item) {
                return _.every([
                    _.inRange(
                        item.__time,
                        self.timestampToday,
                        self.timestampEnd
                    ),
                ]);
            });

            dataWithMay = _.orderBy(
                dataWithMay,
                ["__time"],
                ["asc"]
            );
            if (this.isOneDateSelected) {
                let dataWithMay2 = new Array();
                dataWithMay2 = _.filter(data, function (item) {
                    return _.every([
                        _.inRange(
                            item.__time,
                            self.timestampToday - 2 * 86400000,
                            self.timestampToday + 86400000
                        ),
                    ]);
                });

                dataWithMay2 = _.orderBy(
                    dataWithMay2,
                    ["__time"],
                    ["asc"]
                );

                this.dzoCompaniesSummaryForChart = this.getProductionForChart(dataWithMay2);
            } else {
                this.dzoInputData = dataWithMay;
                this.dzoCompaniesSummaryForChart = this.getProductionForChart(dataWithMay);
            }

            let productionPlanAndFactMonth = this.getProductionPlanAndFactForMonth(dataWithMay);
            this.updateWellsWidgetsForAllCompanies(dataWithMay);
            this.injectionWells = this.getSummaryWells(dataWithMay,this.wellStockIdleButtons.isInjectionIdleButtonActive,'injectionFonds');
            this.innerWellsChartData = this.getSummaryInjectionWellsForChart(dataWithMay);
            this.productionWells = this.getSummaryWells(dataWithMay, this.wellStockIdleButtons.isProductionIdleButtonActive,'productionFonds');
            this.innerWells2ChartData = this.getSummaryProductionWellsForChart(dataWithMay);
            this.otmData = this.getOtmData(dataWithMay)
            this.drillingWells=this.otmData[0]['fact'];
            this.otmKrsSkv=this.otmData[2]['fact'];
            this.otmPrsSkv=this.otmData[3]['fact'];
            this.otmChartData = this.getOtmChartData(dataWithMay)
            this.chemistryData = this.getChemistryData(dataWithMay)
            if (this.chemistryData.length != 0) {
                this.chemistryDataFactSumm= _.reduce(
                    this.chemistryData,
                    function (memo, item) {
                        return memo + item.fact;
                    },
                    0
                );
            }
            this.chemistryChartData = this.getChemistryChartData(dataWithMay)

            var dzo2 = [];
            var planMonth = [];
            var factMonth = [];
            var oil_fact = [];
            var oil_plan = [];

            var e = [];
            var f = [];
            var p = [];
            var getMonthBigTable = [];

            let dzoPlansMapping = {};

            _.forEach(dataWithMay, function (item) {
                self.updateDzoPlans(item,dzoPlansMapping);
                e = {dzo2: item.dzo};
                f = {factMonth: Math.ceil(item[self.factFieldName])};
                p = {planMonth: Math.ceil(item[self.planFieldName])};
                oil_fact = {oil_fact: item.oil_fact};
                oil_plan = {oil_plan: item.oil_plan};
                getMonthBigTable.push([e, f, p, oil_fact, oil_plan]);
            });

            let dzoListWithoutOpec = this.getDzoListWithoutOpec(dzoPlansMapping);

            var factMonth = _.reduce(
                factMonth,
                function (memo, item) {
                    return memo + item.productionFact;
                },
                0
            );

            var planMonth = _.reduce(
                planMonth,
                function (memo, item) {
                    return memo + item[self.planFieldName];
                },
                0
            );

            var dataDay = [];


            dataDay = _.filter(data, function (item) {
                return _.every([
                    _.inRange(
                        item.__time,
                        self.timestampEnd - 86400000,
                        self.timestampEnd
                    ),
                ]);
            });

            dataDay = _.orderBy(dataDay, ["dzo"], ["desc"]);


            var dzoDay = [];
            var factDay = [];
            var planDay = [];
            var inj_wells_idle = [];
            var inj_wells_work = [];
            var prod_wells_work = [];
            var prod_wells_idle = [];
            var starts_krs = [];
            var starts_prs = [];
            var starts_drl = [];
            var NameDzoFull = this.NameDzoFull;
            var dzoBriefly = [];
            var dzoPercent = [];
            var productionFactPercent = [];
            var dataDayLast = [];


            _.forEach(dataDay, function (item) {


                dzoBriefly.push({dzoBriefly: item.dzo});
                e = {dzoDay: name};
                f = {factDay: Math.ceil(item[self.factFieldName])};
                p = {planDay: Math.ceil(item[self.planFieldName])};

                dzoDay.push(e);
                factDay.push(f);
                planDay.push(p);
            });

            this.updateWellsWidgetPercentData(data);


            var dzoMonth = [];
            var factMonth = [];
            var planMonth = [];

            if (this.dzoCompaniesAssets['isOperating']) {
                productionPlanAndFactMonth = this.getFilteredData(productionPlanAndFactMonth, 'isNonOperating');
                data = this.getFilteredData(data, 'isNonOperating');
            }

            if (this.dzoCompaniesAssets['isNonOperating']) {
                productionPlanAndFactMonth = this.getFilteredData(productionPlanAndFactMonth, 'isOperating');
                data = this.getFilteredData(data, 'isOperating');
            }

            if (this.dzoCompaniesAssets['isRegion']) {
                productionPlanAndFactMonth = this.getFilteredCompaniesList(productionPlanAndFactMonth);
                data = this.getFilteredCompaniesList(data);
            }

            if (this.isKmgParticipationFilterActive) {
                productionPlanAndFactMonth = this.calculateKmgParticipationFilter(productionPlanAndFactMonth,
                    'dzo','productionFactForChart',
                    'productionPlanForChart');
            }

            let opec = [];
            let impulses = [];
            let landing = [];
            let accident = [];
            let restrictions = [];
            let otheraccidents = [];

            _.forEach(productionPlanAndFactMonth, function (item) {
                factMonth.push({factMonth: item.productionFactForChart});
                planMonth.push({planMonth: item.productionPlanForChart});
                dzoMonth.push({dzoMonth: item.dzo});
                opec.push({opec: item.opec});
                impulses.push({impulses: item.impulses});
                landing.push({landing: item.landing})
                accident.push({accident: item.accident});
                restrictions.push({restrictions: item.restrictions});
                otheraccidents.push({otheraccidents: item.otheraccidents});
            });

            var factYearSumm = _.reduce(
                factYear,
                function (memo, item) {
                    return memo + item.factYear;
                },
                0
            );

            var planYearSumm = _.reduce(
                planYear,
                function (memo, item) {
                    return memo + item.planYear;
                },
                0
            );

            var planMonthSumm = _.reduce(
                planMonth,
                function (memo, item) {
                    return memo + item.planMonth;
                },
                0
            );

            var factMonthSumm = _.reduce(
                factMonth,
                function (memo, item) {
                    return memo + item.factMonth;
                },
                0
            );

            var factDaySumm = _.reduce(
                factDay,
                function (memo, item) {
                    return memo + item.factDay;
                },
                0
            );

            var planDaySumm = _.reduce(
                planDay,
                function (memo, item) {
                    return memo + item.planDay;
                },
                0
            );

            this.factYearSumm = factYearSumm;
            this.planYearSumm = planYearSumm;
            this.planMonthSumm = planMonthSumm;
            this.factMonthSumm = factMonthSumm;
            this.factDaySumm = factDaySumm;
            this.planDaySumm = planDaySumm;


            this.personalFact = _.reduce(
                dataDay,
                function (memo, item) {
                    return memo + item['tb_personal_fact'];
                },
                0
            );

            this.getProductionPercentCovid(data);
            this.covid = _.reduce(
                dataDay,
                function (memo, item) {
                    return memo + item['tb_covid_total'];
                },
                0
            );

            var bigTable = _.zipWith(
                opec,
                impulses,
                landing,
                accident,
                restrictions,
                otheraccidents,
                productionFactPercent,
                dzoPercent,
                dzoMonth,
                dzo,
                dzo2,
                planMonth,
                factMonth,
                (opec,
                 impulses,
                 landing,
                 accident,
                 restrictions,
                 otheraccidents,
                 productionFactPercent,
                 dzoPercent,
                 dzoMonth,
                 dzo,
                 dzo2,
                 planMonth,
                 factMonth,
                ) =>
                    _.defaults(
                        opec,
                        impulses,
                        landing,
                        accident,
                        restrictions,
                        otheraccidents,
                        productionFactPercent,
                        dzoPercent,
                        dzoMonth,
                        dzo,
                        dzo2,
                        planMonth,
                        factMonth,
                    )
            );


            let tmpArrayToSort = [
                'АО "Озенмунайгаз"',
                'АО "Эмбамунайгаз"',
                'АО "Мангистаумунайгаз"',
                'АО "Каражанбасмунай"',
                'ТОО "СП "Казгермунай"',
                'ТОО "Казахтуркмунай"',
                'ТОО "Казахойл Актобе"',
                'ТОО "Урихтау Оперейтинг"',
                'ТОО "Тенгизшевройл"',
                '"Норт Каспиан Оперейтинг Компани н.в."',
                '"Карачаганак Петролеум Оперейтинг б.в."',
                'АО "ПетроКазахстан Кумколь Ресорсиз"',
                'АО "ПетроКазахстан Инк."',
                'АО "Тургай-Петролеум"',
                'ТОО "Амангельды Газ"',
            ]

            bigTable = _.orderBy(
                bigTable,
                ["dzoMonth"],
                ["asc"]
            );

            this.addOpecToDzoSummary(dataWithMay, bigTable);

            bigTable
                .sort((a, b) => {
                    return tmpArrayToSort.indexOf(this.getNameDzoFull(a.dzoMonth)) > tmpArrayToSort.indexOf(this.getNameDzoFull(b.dzoMonth)) ? 1 : -1
                });

            bigTable = bigTable.filter(row => row.factMonth > 0 || row.planMonth > 0);
            if (this.isOpecFilterActive) {
                bigTable = bigTable.filter(item => dzoListWithoutOpec.includes(item.dzoMonth));
            }

            this.bigTable = bigTable;
            this.clearNullAccidentCases();
            this.exportDzoCompaniesSummaryForChart();

            return data;
        },

        addPeriodPlanData(mainTableData, opecDzoName, opecDzoPeriodPlan) {
            _.forEach(mainTableData, function (parentDzo) {
                if (parentDzo.dzoMonth === opecDzoName) {
                    parentDzo.periodPlan = opecDzoPeriodPlan;
                }
            });
        },

        getProductionPlanAndFactForMonth(inputData) {
            let self = this;
            let productionData = _(inputData)
                .groupBy("dzo")
                .map((dzo, id) => ({
                    dzo: id,
                    opec: _.sumBy(dzo, 'opec2'),
                    impulses: _.sumBy(dzo, 'impulses'),
                    landing: _.sumBy(dzo, 'landing'),
                    accident: _.sumBy(dzo, 'accident'),
                    restrictions: _.sumBy(dzo, 'restrictions'),
                    otheraccidents: _.sumBy(dzo, 'otheraccidents'),
                    productionFactForChart: _.round(_.sumBy(dzo, self.factFieldName), 0),
                    productionPlanForChart: _.round(_.sumBy(dzo, self.planFieldName), 0),
                }))
                .value();

            return _.orderBy(
                productionData,
                ["dzo"],
                ["desc"]
            );
        },

        updateDzoPlans(item,dzoPlansMapping) {
            if (!dzoPlansMapping[item.dzo]) {
                dzoPlansMapping[item.dzo] = {
                    plan: 0,
                    opecPlan: 0
                };
            }
            dzoPlansMapping[item.dzo].plan += item['oil_plan'];
            dzoPlansMapping[item.dzo].opecPlan += item['oil_opek_plan'];
        },

        getDzoListWithoutOpec(dzoPlanMapping) {
            let dzoList = [];
            _.forEach(Object.keys(dzoPlanMapping), function(key) {
                if (dzoPlanMapping[key].plan !== dzoPlanMapping[key].opecPlan) {
                    dzoList.push(key);
                }
            });
            return dzoList;
        },
    },
    mixins: [
        mainMenu,
        сompaniesDzo,
        helpers,
        otm,
        chemistry,
        oilRates,
        usdRates,
        injectionWells,
        productionWells,
        companyStaff,
        mainStatisticsTable,
        wells,
        rates,
        dates,
        oilProductionFilters,
        mainTableChart,
        secondaryParams
    ],
    async mounted() {
        this.getOpecDataForYear();
        this.chartHeadName = this.oilChartHeadName;

        if (window.location.host === 'dashboard') {
            this.range = {
                start: moment().startOf('day').subtract(1, "days").format(),
                end: moment().endOf('day').subtract(1, "days").format(),
                formatInput: true,
            };
        } else {
            this.range = {
                start: moment().startOf('day').subtract(1, "days").format(),
                end: moment().endOf('day').subtract(1, "days").format(),
                formatInput: true,
            };
        }
        localStorage.setItem("changeButton", "Yes");
        var nowDate = new Date().toLocaleDateString();
        this.timeSelect = nowDate;
        this.timestampToday = new Date(this.range.start).getTime();
        this.timestampEnd = new Date(this.range.end).getTime();

        this.selectedYear = this.year;

        localStorage.setItem("selectedPeriod", "undefined");
        this.getCurrencyNow(this.timeSelect);
        this.updatePrices(this.period);
        this.dzoMonthlyPlans = await this.getDzoMonthlyPlans();

        this.changeAssets('isAllAssets');
        this.dzoCompaniesAssets = _.cloneDeep(this.dzoCompaniesAssetsInitial);
        this.sortDzoList();
        this.changeDate();
        this.changeMenu2();
        this.getStaff();

        this.buttonDailyTab = "button-tab-highlighted";
        this.getAccidentTotal();
        this.mainMenuButtonElementOptions = _.cloneDeep(mainMenuConfiguration);
        this.getDzoYearlyPlan();
        this.selectedDzoCompanies = this.getAllDzoCompanies();
        this.dailyCurrencyChangeUsd = Math.abs(parseFloat(this.usdRatesData.for_table[1].change));
    },
    watch: {
        bigTable: function () {
            this.dzoCompanySummary = this.bigTable;
            this.calculateDzoCompaniesSummary();
        },
        tables: function() {
            this.dzoCompanySummary = this.tables;
            this.calculateDzoCompaniesSummary();
        },
        dzoCompaniesSummaryForChart: function () {
            if (this.isFilterTargetPlanActive) {
                let self = this;
                _.forEach(this.dzoCompanySummary, function(dzo) {
                     let yearlyData = self.getProductionData(self.dzoInputData,dzo.dzoMonth);
                     dzo.targetPlan = self.getSummaryTargetPlan(yearlyData);
                });
                let summaryTargetPlan = _.sumBy(this.dzoCompanySummary, 'targetPlan');
                this.dzoCompaniesSummary.targetPlan = this.formatDigitToThousand(summaryTargetPlan);
            }
        },
    },
    computed: {
        ...dzoMapState([
            'yearlyPlan'
        ]),
        exactDateSelected() {
            return ((this.factFieldName === 'oil_fact' || this.factFieldName === 'oil_dlv_fact') && this.isOneDateSelected);
        },
    },
};
