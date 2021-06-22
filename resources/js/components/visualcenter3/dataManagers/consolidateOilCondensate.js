import moment from "moment";
import dzoCompaniesNameMapping from "../dzo_companies_consolidated_name_mapping.json";

export default {
    data: function () {
        return {
            productionTableData: [],
            dzoNameMapping: _.cloneDeep(dzoCompaniesNameMapping.dzoNameMapping),
            dzoNameMappingWithoutKMG: _.cloneDeep(dzoCompaniesNameMapping.dzoNameMappingWithoutKMG),
            dzoNameMappingNormal: _.cloneDeep(dzoCompaniesNameMapping.normalNames),
            sortingOrder: [
                'ОМГ','ОМГК','ММГ','ЭМГ','КБМ',
                'КГМ','КТМ','КОА','УО','ТШО','НКО','КПО','ПКИ',
                'ПККР','КГМКМГ','ТП','АГ'
            ],
            sortingOrderWithoutParticipation: [
                'ОМГ','ОМГК','ЭМГ','АГ','ТШО','ММГ','КОА','КТМ',
                'КГМ','ПКК','ТП','КБМ','КПО','НКО','УО'
            ],
            consolidatedData: {
                'withParticipation': [],
                'withoutParticipation': [],
                'yesterdayWithParticipation': [],
                'chartWithParticipation': [],
                'chartWithoutParticipation': [],
            },

            productionParamsWidget: {
                'oilFact' : 0,
                'oilPlan' : 0,
                'yesterdayOilFact': 0,
                'yesterdayOldFact': 0,
                'yesterdayOilFactWithFilter': 0,

            },
            factorOptions: {
                'ММГ': 0.5,
                'КБМ': 0.5,
                'КГМ': 0.5,
                'КОА': 0.5,
                'ТШО': 0.2,
                'КПО': 0.1,
            },
            dzoOptions: {
                'default': [
                    {
                        'dzoMonth': 'ОМГК',
                        'dzoName' : 'ОМГ',
                        'factMonth': 'gk_fact',
                        'opekMonth': 'gk_plan',
                        'planMonth': 'gk_plan',
                        'formula': (fieldName, dzoName,inputData) => this.sumBy(fieldName,dzoName,inputData)
                    },
                    {
                        'dzoMonth': 'ПККР',
                        'dzoName' : 'ПКК',
                        'factMonth': 'oil_fact',
                        'opekMonth': 'oil_opek_plan',
                        'planMonth': 'oil_plan',
                        'formula': (fieldName, dzoName,inputData) => Math.round(this.sumBy(fieldName,dzoName,inputData) * 0.33)
                    },
                    {
                        'dzoMonth': 'КГМКМГ',
                        'dzoName' : 'КГМ',
                        'factMonth': 'oil_fact',
                        'opekMonth': 'oil_opek_plan',
                        'planMonth': 'oil_plan',
                        'formula': (fieldName, dzoName,inputData) => Math.round(this.sumBy(fieldName,dzoName,inputData) * 0.5 * 0.33)
                    },
                    {
                        'dzoMonth': 'ТП',
                        'dzoName' : 'ТП',
                        'factMonth': 'oil_fact',
                        'opekMonth': 'oil_opek_plan',
                        'planMonth': 'oil_plan',
                        'formula': (fieldName, dzoName,inputData) => Math.round(this.sumBy(fieldName,dzoName,inputData) * 0.5 * 0.33)
                    },
                    {
                        'dzoMonth': 'АГ',
                        'dzoName' : 'АГ',
                        'factMonth': 'gk_fact',
                        'opekMonth': 'gk_plan',
                        'planMonth': 'gk_plan',
                        'formula': (fieldName, dzoName,filteredInitialData) => this.sumBy(fieldName,dzoName,filteredInitialData)
                    },
                ],
                'withoutKMGFilter': [
                    {
                        'dzoMonth': 'ОМГК',
                        'dzoName' : 'ОМГ',
                        'factMonth': 'gk_fact',
                        'opekMonth': 'gk_plan',
                        'planMonth': 'gk_plan',
                        'formula': (fieldName, dzoName,inputData) => this.sumBy(fieldName,dzoName,inputData)
                    },
                    {
                        'dzoMonth': 'АГ',
                        'dzoName' : 'АГ',
                        'factMonth': 'gk_fact',
                        'opekMonth': 'gk_plan',
                        'planMonth': 'gk_plan',
                        'formula': (fieldName, dzoName,filteredInitialData) => this.sumBy(fieldName,dzoName,filteredInitialData)
                    },
                ]
            },
            oilCondensateFilters: {
                'isWithoutKMGFilterActive': true
            },
            nkoMapping: {
                'formula': (value) => Math.round(((value - value * 0.019) * 241 / 1428) / 2)
            },
            emptyTemplate: {
                accident: null,
                dzoMonth: 'КГМ',
                factMonth: 0,
                impulses: null,
                landing: null,
                opec: null,
                opekPlan: 0,
                otheraccidents: null,
                periodPlan: null,
                planMonth: 0,
                restrictions: null
            },
            dzoMultiplier: {
                'ОМГ': (item,value,fieldName) => value + item[fieldName],
                'ПКК': (item,value,fieldName) => value * 0.33,
                'КГМ': (item,value,fieldName) => value * 0.5 * 0.33,
                'ТП': (item,value,fieldName) => value * 0.5 * 0.33,
                'НКО': (item,value,fieldName) => ((value - value * 0.019) * 241 / 1428) / 2
            }
        };
    },
    methods: {
        switchFilterConsolidatedOilCondensate(parentButton,childButton,filterName) {
            this.oilCondensateFilters[filterName] = !this.oilCondensateFilters[filterName];
            let chartOutput = this.consolidatedData.chartWithParticipation;
            if (!this.oilCondensateFilters.isWithoutKMGFilterActive) {
                chartOutput = this.consolidatedData.chartWithoutParticipation;
            }
            this.exportDzoCompaniesSummaryForChart(chartOutput);
            if (this.oilCondensateFilters[filterName]) {
                this.dzoCompanySummary = this.consolidatedData.withParticipation;
            } else {
                this.dzoCompanySummary = this.consolidatedData.withoutParticipation;
            }
            let elementOptions = this.mainMenuButtonElementOptions[parentButton].childItems[childButton];
            this.switchButtonOptions(elementOptions);
            this.calculateDzoCompaniesSummary();
        },
        getConsolidatedOilCondensate() {
            let self = this;

            let filteredByCompanies = this.getFilteredCompaniesList(_.cloneDeep(this.productionTableData));
            let filteredByPeriod = this.getFilteredByPeriod(filteredByCompanies,true);
            let filteredInitial = this.getFilteredByPeriod(_.cloneDeep(this.productionTableData),false);
            let actualUpdatedByOpek = this.getUpdatedByOpekPlan(_.cloneDeep(this.dzoCompanySummary),filteredByPeriod);

            let dataWithKMGParticipation = this.getUpdatedByDzoOptions(_.cloneDeep(actualUpdatedByOpek),filteredByPeriod,filteredInitial);
            let dataWithoutKMGParticipation = this.getUpdatedByDzoOptionsWithoutKMG(_.cloneDeep(actualUpdatedByOpek),filteredByPeriod,filteredInitial);
            let yesterdayData = this.getYesterdayData(_.cloneDeep(actualUpdatedByOpek),filteredByCompanies);

            this.updateConsolidatedData(dataWithKMGParticipation,dataWithoutKMGParticipation);
            let output = dataWithKMGParticipation;
            let chartOutput = this.consolidatedData.chartWithParticipation;
            this.isOpecFilterActive = true;
            if (!this.oilCondensateFilters.isWithoutKMGFilterActive) {
                output = dataWithoutKMGParticipation;
                chartOutput = this.consolidatedData.chartWithoutParticipation;

            }

            this.exportDzoCompaniesSummaryForChart(chartOutput);
            return output;
        },

        getFilteredByPeriod(productionData,isNeedSort) {
            let filtered = this.getProductionDataInPeriodRange(productionData,this.timestampToday,this.timestampEnd);
            if (this.isOneDateSelected) {
                filtered = this.getFilteredDataByOneDay(filtered, 'today');
            }
            if (isNeedSort) {
                filtered = this.getFilteredDataByOneDay(productionData, 'today');
                filtered = this.getDataOrderedByAsc(filtered);
            }
            return filtered;
        },

        getUpdatedByOpekPlan(dzoSummary,filteredDataByPeriod) {
            let self = this;
            let updatedByOpek = dzoSummary;
            _.forEach(updatedByOpek, function(item) {
                item.opekPlan = self.sumBy('oil_opek_plan',item.dzoMonth,filteredDataByPeriod);
            });
            return updatedByOpek;
        },

        updateConsolidatedData(sortedWithKMGParticipation,sortedWithoutKMGParticipation) {
            this.consolidatedData.withParticipation = sortedWithKMGParticipation;
            this.consolidatedData.withoutParticipation = sortedWithoutKMGParticipation;
            this.updateChart();
        },

        updateChart() {
            let self = this;
            let withKMG = this.getProductionDataInPeriodRange(_.cloneDeep(this.productionTableData),this.timestampToday,this.timestampEnd);
            let withoutKMG = this.getProductionDataInPeriodRange(_.cloneDeep(this.productionTableData),this.timestampToday,this.timestampEnd);

            _.forEach(withKMG, function (item) {
                if (self.dzoMultiplier[item.dzo]) {
                    item.oil_fact = self.dzoMultiplier[item.dzo](item,item.oil_fact,'oil_fact');
                    item.oil_plan = self.dzoMultiplier[item.dzo](item,item.oil_plan,'oil_plan');
                }
            });

            _.forEach(withoutKMG, function (item) {
                if (item.dzo === 'ОМГ') {
                    item.oil_fact += item.gk_fact;
                    item.oil_plan += item.gk_plan;
                }
            });

            this.consolidatedData.chartWithParticipation = this.getSumForChart(withKMG);
            this.consolidatedData.chartWithoutParticipation = this.getSumForChart(withoutKMG);
        },

        getSumForChart(data) {
            let summaryForChart = _(data)
                .groupBy("date")
                .map((item, timestamp) => ({
                    time: timestamp,
                    dzo: 'dzo',
                    productionFactForChart: _.round(_.sumBy(item, 'oil_plan'), 0),
                    productionPlanForChart: _.round(_.sumBy(item, 'oil_fact'), 0),
                    productionPlanForChart2: _.round(_.sumBy(item, 'oil_opek_plan'), 0),
                }))
                .value();

            if (this.isFilterTargetPlanActive) {
                let monthlyPlansInYear = this.getMonthlyPlansInYear(summaryForChart);
                summaryForChart = monthlyPlansInYear;
            }

            return summaryForChart;
        },

        getUpdatedByDzoOptions(inputActualUpdatedByOpek,inputData,filteredInitialData) {
            let self = this;
            let dzoOptions = _.cloneDeep(this.dzoOptions.default);
            let pkiSummary = {
                'factMonth': 0,
                'planMonth': 0,
                'opekPlan': 0
            };

            let actualUpdatedByOpek = inputActualUpdatedByOpek;
            actualUpdatedByOpek = this.getFilteredByNotUsableDzo(actualUpdatedByOpek);

            _.forEach(dzoOptions, function(item) {
                if (item.dzoName === 'АГ') {
                    actualUpdatedByOpek.push({
                        'dzoMonth' : item.dzoMonth,
                        'factMonth' : item.formula(item.factMonth,item.dzoName,filteredInitialData),
                        'opekPlan' : item.formula(item.opekMonth,item.dzoName,filteredInitialData),
                        'planMonth' : item.formula(item.planMonth,item.dzoName,filteredInitialData),
                    });
                } else {
                    actualUpdatedByOpek.push({
                        'dzoMonth' : item.dzoMonth,
                        'factMonth' : item.formula(item.factMonth,item.dzoName,inputData),
                        'opekPlan' : item.formula(item.opekMonth,item.dzoName,inputData),
                        'planMonth' : item.formula(item.planMonth,item.dzoName,inputData),
                    });
                }
                if (['ПКК','КГМ','ТП'].includes(item.dzoName)) {
                    self.updateDzoCompaniesSummary(item,pkiSummary,inputData);
                }
            });

            _.forEach(actualUpdatedByOpek, function(item, index) {
                if (self.factorOptions[item.dzoMonth]) {
                    item.factMonth *= self.factorOptions[item.dzoMonth];
                    item.opekPlan *= self.factorOptions[item.dzoMonth];
                    item.planMonth *= self.factorOptions[item.dzoMonth];
                }
                if (item.dzoMonth === 'ПКИ') {
                    item.factMonth = pkiSummary.factMonth;
                    item.opekPlan = pkiSummary.opekPlan;
                    item.planMonth = pkiSummary.planMonth;
                }
                if (item.dzoMonth === 'НКО') {
                    item.factMonth = self.dzoMultiplier['НКО'](null,item.factMonth,null);
                    item.opekPlan = self.dzoMultiplier['НКО'](null,item.opekPlan,null);
                    item.planMonth = self.dzoMultiplier['НКО'](null,item.planMonth,null);
                }
            });

            actualUpdatedByOpek = this.getUpdatedByTemplates(this.sortingOrder,actualUpdatedByOpek);
            actualUpdatedByOpek = this.getSorted(actualUpdatedByOpek,this.sortingOrder);
            if (this.buttonMonthlyTab || this.buttonYearlyTab) {
                actualUpdatedByOpek = this.getUpdatedByPeriodPlan(actualUpdatedByOpek);
            }
            return actualUpdatedByOpek;
        },

        sumBy(fieldName, dzoName, data) {
            let updatedValue = 0;
            _.forEach(data, function(item) {
                if (item.dzo === dzoName) {
                    updatedValue += item[fieldName];
                }
            });
            return updatedValue;
        },

        updateDzoCompaniesSummary(item,summary,inputData) {
            summary.factMonth += item.formula(item.factMonth,item.dzoName,inputData);
            summary.planMonth += item.formula(item.planMonth,item.dzoName,inputData);
            summary.opekPlan += item.formula(item.opekMonth,item.dzoName,inputData);
        },

        getSorted(inputData,sortingOrder) {
            let sorted = [];
            _.forEach(sortingOrder, function (key) {
                let itemIndex = inputData.findIndex(element => element.dzoMonth === key);
                sorted.push(inputData[itemIndex]);
            });
            return sorted;
        },

        getUpdatedByDzoOptionsWithoutKMG(inputActualUpdatedByOpek,inputData,filteredInitialData) {
            let dzoOptions = _.cloneDeep(this.dzoOptions.withoutKMGFilter);
            let actualUpdatedByOpek = inputActualUpdatedByOpek;
            let pkiIndex = actualUpdatedByOpek.findIndex(element => element.dzoMonth === 'ПКИ');
            actualUpdatedByOpek.splice(pkiIndex, 1);
            _.forEach(dzoOptions, function(item) {
                if (item.dzoName === 'АГ') {
                    actualUpdatedByOpek.push({
                        'dzoMonth' : item.dzoMonth,
                        'factMonth' : item.formula(item.factMonth,item.dzoName,filteredInitialData),
                        'opekPlan' : item.formula(item.opekMonth,item.dzoName,filteredInitialData),
                        'planMonth' : item.formula(item.planMonth,item.dzoName,filteredInitialData),
                    });
                } else {
                    actualUpdatedByOpek.push({
                        'dzoMonth' : item.dzoMonth,
                        'factMonth' : item.formula(item.factMonth,item.dzoName,inputData),
                        'opekPlan' : item.formula(item.opekMonth,item.dzoName,inputData),
                        'planMonth' : item.formula(item.planMonth,item.dzoName,inputData),
                    });
                }
            });

            actualUpdatedByOpek = this.getUpdatedByTemplates(this.sortingOrderWithoutParticipation,actualUpdatedByOpek);
            actualUpdatedByOpek = this.getSorted(actualUpdatedByOpek,this.sortingOrderWithoutParticipation);
            if (this.buttonMonthlyTab || this.buttonYearlyTab) {
                actualUpdatedByOpek = this.getUpdatedByPeriodPlan(actualUpdatedByOpek);
            }

            return actualUpdatedByOpek;
        },

        updateProductionTotalFact() {
            this.productionParams['oil_fact'] = this.productionParamsWidget.oilFact;
            this.productionParams['oil_plan'] = this.productionParamsWidget.oilPlan;
            this.productionPercentParams['oil_fact'] = this.productionParamsWidget.yesterdayOldFact;
        },

        getYesterdayData(initialData,filteredDataByCompanies) {
            let updatedData = _.cloneDeep(this.productionTableData);
            let periodStart = moment(new Date(this.timestampToday)).subtract(this.quantityRange, 'days').valueOf();
            let filteredByPeriod = this.getProductionDataInPeriodRange(filteredDataByCompanies,periodStart,this.timestampToday);
            filteredByPeriod = this.getDataOrderedByAsc(filteredByPeriod);
            let filteredInitialData = this.getProductionDataInPeriodRange(updatedData,periodStart,this.timestampToday);
            if (this.isOneDateSelected) {
                filteredByPeriod = this.getFilteredDataByOneDay(_.cloneDeep(filteredDataByCompanies),'yesterday');
                filteredInitialData = this.getFilteredDataByOneDay(filteredInitialData,'yesterday');
            }
            let groupedData = _(filteredByPeriod)
                .groupBy("dzo")
                .map((dzo, id) => ({
                    dzoMonth: id,
                    factMonth: _.sumBy(dzo, 'oil_fact'),
                    planMonth: _.sumBy(dzo, 'oil_plan'),
                    opekPlan: _.sumBy(dzo, 'oil_opek_plan'),
                }))
                .value();
            let dataWithKMGParticipation = this.getUpdatedByDzoOptions(_.cloneDeep(initialData),filteredByPeriod,filteredInitialData);
            let dataWithoutKMGParticipation = this.getUpdatedByDzoOptionsWithoutKMG(_.cloneDeep(initialData),filteredByPeriod,filteredInitialData);
            this.productionParamsWidget.yesterdayOilFact = _.sumBy(dataWithKMGParticipation, 'factMonth');
            this.productionParamsWidget.yesterdayOilFactWithFilter = _.sumBy(dataWithoutKMGParticipation, 'factMonth');

            return dataWithKMGParticipation;
        },
        getFilteredByNotUsableDzo(data) {
            let updatedData = data;
            let tpIndex = updatedData.findIndex(element => element.dzoMonth === 'ТП');
            let pkkIndex = updatedData.findIndex(element => element.dzoMonth === 'ПКК');
            updatedData.splice(tpIndex, 1);
            updatedData.splice(pkkIndex, 1);
            return updatedData;
        },

        getUpdatedByPeriodPlan(data) {
            let updatedData = data;
            let daysPassed = moment().date();
            let daysCountInMonth = moment().daysInMonth();
            _.forEach(updatedData, function(item) {
                item.periodPlan = item.planMonth / daysPassed * daysCountInMonth;
            });
            return updatedData;
        },

        getUpdatedByTemplates(sortingOrder,inputData) {
            let self = this;
            _.forEach(sortingOrder, function (dzoName) {
                if (inputData.findIndex(element => element.dzoMonth === dzoName) === -1) {
                    let template = self.emptyTemplate;
                    template.dzoMonth = dzoName;
                    inputData.push(template);
                }
            });
            return inputData;
        },
    }
}