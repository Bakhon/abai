import {EventBus} from "../../event-bus.js";
import moment from "moment";
import Calendar from "v-calendar/lib/components/calendar.umd";
import DatePicker from "v-calendar/lib/components/date-picker.umd";
import {isString} from "lodash";

import mainMenuConfiguration from './main_menu_configuration.json';
import dzoNumberMapping from './dzo_number_mapping.json';
import {dzoMapState, dzoMapActions} from '@store/helpers';

import mainMenu from './widgets/mainMenu';
import сompaniesDzo from './dataManagers/dzoCompanies';
import helpers from './dataManagers/helpers';
import oilRates from './widgets/oilRates';
import usdRates from './widgets/usdRates';
import mainStatisticsTable from './widgets/mainStatisticsTable';
import rates from './dataManagers/rates';
import dates from './dataManagers/dates';
import oilProductionFilters from './dataManagers/oilProductionFilters';
import mainTableChart from './widgets/mainTableChart.js';
import secondaryParams from './dataManagers/secondaryParams';
import consolidateOilCondensate from './dataManagers/consolidateOilCondensate';
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


export default {
    components: {
        Calendar,
        DatePicker
    },
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
            isOneDzoSelected: false,
            oilChartHeadName: this.trans('visualcenter.getoildynamic'),
            quantityRange: '',
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
            bigTable: [],
            starts: [""],
            series: ["", ""],
            timestampToday: "",
            timestampEnd: "",
            isPricesChartLoading: false,
            chartHeadName: this.trans("visualcenter.oilCondensateProductionChartName"),
            chartSecondaryName: this.trans('visualcenter.oilCondensateProduction'),
            planFieldName: "oil_plan",
            factFieldName: "oil_fact",
            metricName: this.trans("visualcenter.chemistryMetricTon"),
            productionParams : {
                gas_plan: 0,
                gas_fact: 0,
            },
            dailyProgressBars: {
                oilDelivery: 0,
                oil: 0,
                gas: 0,
            },
            productionPercentParams: {
                gas_fact: 0
            },
            millisecondsInOneDay: 1000*60*60*24,
            companyTemplate: {
                "opec": null,
                "impulses": null,
                "landing": null,
                "restrictions": null,
                "otheraccidents": null,
                "dzoMonth": null,
                "planMonth": 0,
                "factMonth": 0,
                "periodPlan": 0,
                "opekPlan": 0
            },
            companies: ['ОМГ','ММГ','ЭМГ','КБМ',
                'КГМ','КТМ','КОА','УО','ТШО','НКО',
                'КПО','ПКИ','ПКК','ТП','АГ'
            ],
            waterInjectionButton: "",
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
            dzoNumbers: dzoNumberMapping,
            troubledCompanies: ['ОМГК','ТП','ПККР','КГМКМГ'],
            gasSortingOrder: [
                'ОМГ','ММГ','ЭМГ','КБМ','КГМ','КТМ','КОА','УО',
            ],
            waterSortingOrder: [
                'ОМГ','ММГ','ЭМГ','КБМ','КГМ','КТМ','КОА'
            ],
        };
    },
    methods: {
        ...dzoMapActions([
            'getYearlyPlan'
        ]),
        ...globalloadingMutations([
            'SET_LOADING'
        ]),

        async getDzoYearlyPlan() {
            await this.getYearlyPlan();
        },

        updateProductionOilandGas(data) {
            let self = this;
            let updatedData = this.getFilteredCompaniesList(data);
            let productionDataInPeriodRange = this.getProductionDataInPeriodRange(updatedData,this.timestampToday,this.timestampEnd);
            let productionSummary = this.getProductionSummary(productionDataInPeriodRange);
            this.updateProductionSummary(productionSummary,this.productionParams);
            this.dailyProgressBars.gas = this.getProductionProgressBarData('gas_plan','gas_fact');
        },
        
        getProductionSummary(data) {
            return _(data)
                .groupBy("dzo")
                .map((dzo, id) => ({
                    dzo: id,
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

        updateProductionOilandGasPercent(data) {
            let updatedData = this.getFilteredCompaniesList(data);
            let periodStart = moment(new Date(this.timestampToday), "DD-MM-YYYY").subtract(this.quantityRange, 'days').valueOf();
            let filteredDataByPeriodRange = this.getProductionDataInPeriodRange(updatedData,periodStart,this.timestampToday);
            this.setPreviousPeriod();
            let productionSummary = this.getProductionSummary(filteredDataByPeriodRange);
            this.updateProductionSummary(productionSummary,this.productionPercentParams);
        },

        updateProductionData(planFieldName, factFieldName, chartHeadName, metricName, chartSecondaryName) {
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
            }
            this.processProductionData(metricName,chartSecondaryName);
        },

        async processProductionData(metricName,chartSecondaryName) {
            this.SET_LOADING(true);
            let productionData = await this.getProductionDataByPeriod();
            if (productionData && Object.keys(productionData).length > 0) {
                if (this.isFirstLoading) {
                    await this.calculateInitialCategories(productionData,metricName,chartSecondaryName);
                    this.isFirstLoading = false;
                    this.lastSelectedCategory = '';
                }
                if (this.lastSelectedCategory.length > 0) {
                   await this.calculateInitialCategories(productionData,metricName,chartSecondaryName);
                }
                await this.processProductionDataByCompanies(productionData,metricName,chartSecondaryName);
            }
            this.SET_LOADING(false);
        },

        async calculateInitialCategories(productionData,metricName,chartSecondaryName) {
            let categories = ['oilCondensateProductionButton','oilCondensateDeliveryButton'];
            let index = categories.findIndex(categoryName => categoryName === this.lastSelectedCategory);
            categories.splice(index, 1);
            for (let i in categories) {
                this.selectedView = categories[i];
                this.selectedButtonName = categories[i];
                await this.processProductionDataByCompanies(productionData,metricName,chartSecondaryName);
            }
            this.selectedView = this.lastSelectedCategory;
            this.selectedButtonName = this.lastSelectedCategory;
        },

        async getProductionDataByPeriod() {
            let queryOptions = {'timestampToday': this.timestampToday, 'timestampEnd': this.timestampEnd};
            let uri = this.localeUrl("/visualcenter3GetData");
            if (this.isProductionDetailsActive) {
                queryOptions = {'timestampToday': new Date(this.timestampToday), 'timestampEnd': new Date(this.timestampEnd)}
                uri = this.localeUrl("/get-production-details");
            }

            const response = await axios.get(uri,{params:queryOptions});
            if (response.status === 200) {
                let todayProduction = _.filter(response.data, function (item) {
                    return _.every([
                        _.inRange(
                            moment(item.date),
                            moment().subtract(1,'days').startOf('day'),
                            moment().subtract(1,'days').endOf('day')
                        ),
                    ]);
                });
                let companies = _.map(todayProduction, 'dzo_name');
                let difference = _.differenceWith(this.companies, companies, _.isEqual);
                if (difference.length > 0) {
                    this.SET_LOADING(true);
                    let missingCompanies = await this.getMissedCompanies(difference);
                    this.SET_LOADING(false);
                    let merged = response.data.concat(missingCompanies);
                    return merged;
                }
                return response.data;
            }
            return {};
        },

        async getMissedCompanies(difference) {
            let missingCompanies = [];
            for (let i in difference) {
                let historicalProduction = await this.getHistoricalProduction(difference[i]);
                historicalProduction.date = moment().subtract(1,'days').format();
                missingCompanies.push(historicalProduction);
            }
            return missingCompanies;
        },

        async getHistoricalProduction(dzoName) {
            let queryOptions = {'dzoName': dzoName};
            let uri = this.localeUrl("/get-historical-production");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status === 200) {
                return response.data[0];
            }
        },

        processProductionDataByCompanies(productionData,metricName,chartSecondaryName) {
            if (this.isConsolidatedCategoryActive()) {
                this.isOpecFilterActive = false;
                this.planFieldName = 'oil_plan';
            }
            if (!this.condolidatedButtons.includes(this.selectedButtonName)) {
                let indexes = this.getElementIndexesByCompany(productionData,'ПКИ','dzo_name');
                for (var i in indexes.reverse()) {
                    productionData.splice(indexes[i], 1);
                }
            }
            if (this.isProductionDetailsActive) {
                productionData = this.getFormattingProductionDetails(productionData);
            }

            let updatedData = productionData;
            this.productionTableData = productionData;
            let yesterdayPeriodStart = moment(new Date(this.timestampToday)).subtract(1,'days').valueOf();
            let yesterdayPeriodEnd = moment(new Date(this.timestampEnd)).subtract(1,'days').valueOf();
            let processedByAllCompaniesForYesterday = this.getProcessedDataForAllCompanies(productionData,yesterdayPeriodStart,yesterdayPeriodEnd);
            let processedByAllCompaniesForActual = this.getProcessedDataForAllCompanies(productionData,this.timestampToday,this.timestampEnd);
            updatedData = processedByAllCompaniesForActual.filteredData;
            if (processedByAllCompaniesForYesterday.summary.length !== 15 && this.isConsolidatedCategoryActive()) {
                processedByAllCompaniesForYesterday.summary = this.getFilledByAllCompanies(processedByAllCompaniesForYesterday.summary);
                processedByAllCompaniesForActual.summary = this.getFilledByAllCompanies(processedByAllCompaniesForActual.summary);
            }
            this.yesterdayProductionDetails = processedByAllCompaniesForYesterday.summary;
            this.bigTable = processedByAllCompaniesForActual.summary;
            this.setColorToMainMenuButtons();
            this.updateProductionOilandGas(updatedData);
            this.updateProductionOilandGasPercent(updatedData);
        },

        getFilledByAllCompanies(input) {
            let missingCompanies = this.getMissingCompanies(input);
            if (missingCompanies.length > 0) {
                input.concat(missingCompanies);
            }
            return input;
        },

        getMissingCompanies(input) {
            let template = _.cloneDeep(this.companyTemplate);
            let actualCompanies = _.map(input, 'dzoMonth');
            let missingCompanies = [];
            let difference = _.differenceWith(this.companies, actualCompanies, _.isEqual);
            for (let i in difference) {
                if (difference[i] !== 'АГ') {
                    template.dzoMonth = difference[i];
                    missingCompanies.push(template);
                }
            }
            return missingCompanies;
        },

        getElementIndexesByCompany(productionData,companyName,fieldName) {
            return productionData.map((elm, index) => this.getElementIndexByCompany(elm,index,companyName,fieldName)).filter(String);
        },

        getElementIndexByCompany(element,index,companyName,fieldName) {
            if (element[fieldName] === companyName) {
                return index;
            }
            return '';
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

        getProcessedDataForAllCompanies(data,periodStart,periodEnd) {
            let self = this;
            var dataWithMay = new Array();

            dataWithMay = _.filter(data, function (item) {
                return _.every([
                    _.inRange(
                        item.__time,
                        periodStart,
                        periodEnd
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
                            periodStart - 2 * self.millisecondsInOneDay,
                            periodStart + self.millisecondsInOneDay
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

            var dzoPercent = [];
            var productionFactPercent = [];



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

            let opec = [];
            let dzo = [];
            let impulses = [];
            let landing = [];
            let accident = [];
            let restrictions = [];
            let otheraccidents = [];
            let gasRestriction = [];

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
                gasRestriction.push({gasRestriction: item.gasRestriction});
            });

            var bigTable = _.zipWith(
                opec,
                impulses,
                landing,
                accident,
                restrictions,
                otheraccidents,
                gasRestriction,
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
                 gasRestriction,
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
                        gasRestriction,
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

            bigTable = bigTable.filter(row => row.factMonth > 0 && row.planMonth > 0);

            if (this.isOpecFilterActive) {
                bigTable = bigTable.filter(item => dzoListWithoutOpec.includes(item.dzoMonth));
            }

            this.clearNullAccidentCases();
            this.exportDzoCompaniesSummaryForChart(this.dzoCompaniesSummaryForChart);

            return {filteredData: data, summary: bigTable};
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
                    gasRestriction: _.sumBy(dzo, 'gasRestriction'),
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
        getDzoTicker() {
            let dzoTicker = '';
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
        mainMenu,
        сompaniesDzo,
        helpers,
        oilRates,
        usdRates,
        mainStatisticsTable,
        rates,
        dates,
        oilProductionFilters,
        mainTableChart,
        secondaryParams,
        consolidateOilCondensate,
        productionDetails,
        chemistryDetails,
        wellsWorkoverDetails,
        managers,
        drillingDetails,
        wellsDetails,
        productionFondDetails,
        injectionFondDetails,
        emergency
    ],
    async mounted() {
        this.SET_LOADING(true);
        this.getOpecDataForYear();

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
        this.updateDzoMenu();
        localStorage.setItem("selectedPeriod", "undefined");
        this.getCurrencyNow(this.timeSelect);
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
        this.sortDzoList();
        this.changeDate();
        this.changeMenu2();

        this.buttonDailyTab = "button-tab-highlighted";
        this.mainMenuButtonElementOptions = _.cloneDeep(mainMenuConfiguration);
        this.getDzoYearlyPlan();
        this.selectedDzoCompanies = this.getAllDzoCompanies();
        this.updateChemistryWidget();
        this.updateWellsWorkoverWidget();
        this.updateDrillingWidget();
        this.updateProductionFondWidget();
        this.updateInjectionFondWidget();
    },   
    watch: {
        bigTable: function () {
            let isOneDzoSelected = this.getDzoTicker();
            if (isOneDzoSelected) {
                this.assignOneCompanyToSelectedDzo(isOneDzoSelected);
            };
            this.dzoCompanySummary = this.bigTable;
            if (this.oilCondensateProductionButton.length > 0 || this.oilCondensateDeliveryButton.length > 0) {
                let yesterdayPeriodStart = moment(new Date(this.timestampToday)).subtract(this.quantityRange, 'days').valueOf();
                let yesterdayPeriodEnd = moment(new Date(this.timestampEnd)).subtract(this.quantityRange, 'days').valueOf();
                this.updateConsolidatedOilCondensate(yesterdayPeriodStart,yesterdayPeriodEnd,'yesterday',this.yesterdayProductionDetails);
                this.updateConsolidatedOilCondensate(this.timestampToday,this.timestampEnd,'current',this.dzoCompanySummary);
                this.dzoCompanySummary = this.getConsolidatedBy('current');
                this.yesterdaySummary = this.getConsolidatedBy('yesterday');
                this.consolidatedData[this.selectedButtonName].current = this.getConsolidatedBy('current');
                this.consolidatedData[this.selectedButtonName].yesterday = this.getConsolidatedBy('yesterday');
            }
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
