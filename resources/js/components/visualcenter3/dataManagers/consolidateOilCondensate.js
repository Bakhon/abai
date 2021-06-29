import moment from "moment";
import dzoCompaniesNameMapping from "../dzo_companies_consolidated_name_mapping.json"
import companiesListWithKMG from "../dzo_companies_initial_consolidated_withkmg.json";
import companiesListWithoutKMG from "../dzo_companies_initial_consolidated_withoutkmg.json";

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
            dzoMultiplier: {
                'ОМГ': (item,value,fieldName) => value + item[fieldName],
                'ПКК': (item,value,fieldName) => value * 0.33,
                'КГМ': (item,value,fieldName) => value * 0.5 * 0.33,
                'ТП': (item,value,fieldName) => value * 0.5 * 0.33,
                'НКО': (item,value,fieldName) => ((value - value * 0.019) * 241 / 1428) / 2
            },
            companiesForNominalInput: ['АГ','ПКК'],
            yesterdaySummary: [],
            yesterdayProductionDetails: [],
            consolidatedMenuMapping: {
                oilDelivery: {
                    'plan_oil': 'plan_oil_dlv',
                    'plan_oil_opek': 'plan_oil_dlv_opek',
                    'oil_production_fact': 'oil_delivery_fact',
                    'condensate_production_fact': 'condensate_delivery_fact',
                    'plan_kondensat': 'plan_kondensat_dlv'
                },
                oilResidue: {
                    'oil_production_fact': 'stock_of_goods_delivery_fact'
                }
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
                this.changeDzoCompaniesList(companiesListWithKMG);
            } else {
                this.dzoCompanySummary = this.consolidatedData.withoutParticipation;
                this.changeDzoCompaniesList(companiesListWithoutKMG);
            }
            this.selectAllDzoCompanies();
            let elementOptions = this.mainMenuButtonElementOptions[parentButton].childItems[childButton];
            this.switchButtonOptions(elementOptions);
            this.calculateDzoCompaniesSummary();
        },
        getConsolidatedOilCondensate(periodStart,periodEnd,periodName,summary) {
            // console.log(this.oilCondensateDeliveryButton)
            // console.log('-summary')
            // console.log(summary)
            // console.log('-this.productionTableData')
            // console.log(this.productionTableData)
            let self = this;
            let filteredByCompanies = this.getFilteredCompaniesList(_.cloneDeep(this.productionTableData));
            let filteredByPeriod = this.getFilteredByPeriod(filteredByCompanies,true,periodStart,periodEnd);
            let filteredInitial = this.getFilteredByPeriod(_.cloneDeep(this.productionTableData),false,periodStart,periodEnd);

            let actualUpdatedByOpek = this.getUpdatedByOpekPlan(summary,filteredByPeriod);
            let dataWithKMGParticipation = this.getUpdatedByDzoOptions(_.cloneDeep(actualUpdatedByOpek),filteredByPeriod,filteredInitial);
            let dataWithoutKMGParticipation = this.getUpdatedByDzoOptionsWithoutKMG(_.cloneDeep(actualUpdatedByOpek),filteredByPeriod,filteredInitial);

            this.updateConsolidatedData(dataWithKMGParticipation,dataWithoutKMGParticipation,periodStart,periodEnd,periodName);
            let output = this.consolidatedData.withParticipation;
            let chartOutput = this.consolidatedData.chartWithParticipation;
            this.isOpecFilterActive = true;
            if (!this.oilCondensateFilters.isWithoutKMGFilterActive) {
                output = this.consolidatedData.withoutParticipation;
                chartOutput = this.consolidatedData.chartWithoutParticipation;
            }

            this.exportDzoCompaniesSummaryForChart(chartOutput);
            return output;
        },

        getFilteredByPeriod(productionData,isNeedSort,periodStart,periodEnd) {
            let filtered = this.getProductionDataInPeriodRange(productionData,periodStart,periodEnd);
            if (this.isOneDateSelected) {
                filtered = this.getFilteredDataByOneDay(filtered, 'today',periodStart,periodEnd);
            }
            if (isNeedSort) {
                filtered = this.getFilteredDataByOneDay(productionData, 'today',periodStart,periodEnd);
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

        updateConsolidatedData(sortedWithKMGParticipation,sortedWithoutKMGParticipation,periodStart,periodEnd,periodName) {
            let selectedCompanies = this.dzoCompanies.filter(row => row.selected === true).map(row => row.ticker);
            sortedWithKMGParticipation = sortedWithKMGParticipation.filter(row => selectedCompanies.includes(row.dzoMonth));
            sortedWithoutKMGParticipation = sortedWithoutKMGParticipation.filter(row => selectedCompanies.includes(row.dzoMonth));
            this.consolidatedData.withParticipation = sortedWithKMGParticipation;
            this.consolidatedData.withoutParticipation = sortedWithoutKMGParticipation;
            this.updateChart(periodStart,periodEnd);
        },

        updateChart(periodStart,periodEnd) {
            let self = this;
            let withKMG = this.getProductionDataInPeriodRange(_.cloneDeep(this.productionTableData),periodStart,periodEnd);
            let withoutKMG = this.getProductionDataInPeriodRange(_.cloneDeep(this.productionTableData),periodStart,periodEnd);

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
            let sorted = this.getOrderedByAsc(data);
            let summaryForChart = _(sorted)
                .groupBy("date")
                .map((item, timestamp) => ({
                    time: timestamp,
                    dzo: 'dzo',
                    productionFactForChart: _.round(_.sumBy(item, 'oil_fact'), 0),
                    productionPlanForChart: _.round(_.sumBy(item, 'oil_plan'), 0),
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
                if (self.companiesForNominalInput.includes(item.dzoName)) {
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

            _.forEach(actualUpdatedByOpek, function(item, index) {
                if (self.factorOptions[item.dzoMonth]) {
                    item.factMonth *= self.factorOptions[item.dzoMonth];
                    item.opekPlan *= self.factorOptions[item.dzoMonth];
                    item.planMonth *= self.factorOptions[item.dzoMonth];
                }
                if (['ПККР','КГМКМГ','ТП'].includes(item.dzoMonth)) {
                    pkiSummary.factMonth +=item.factMonth;
                    pkiSummary.planMonth +=item.planMonth;
                    pkiSummary.opekPlan +=item.opekPlan;
                }
                if (item.dzoMonth === 'НКО') {
                    item.factMonth = self.dzoMultiplier['НКО'](null,item.factMonth,null);
                    item.opekPlan = self.dzoMultiplier['НКО'](null,item.opekPlan,null);
                    item.planMonth = self.dzoMultiplier['НКО'](null,item.planMonth,null);
                }
            });
            let pkiIndex = actualUpdatedByOpek.findIndex(element => element.dzoMonth === 'ПКИ');
            if (pkiIndex > -1) {
                actualUpdatedByOpek[pkiIndex].factMonth = pkiSummary.factMonth;
                actualUpdatedByOpek[pkiIndex].planMonth = pkiSummary.planMonth;
                actualUpdatedByOpek[pkiIndex].opekPlan = pkiSummary.opekPlan;
            }

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
                if (itemIndex > -1) {
                    sorted.push(inputData[itemIndex]);
                }
            });
            return sorted;
        },

        getUpdatedByDzoOptionsWithoutKMG(inputActualUpdatedByOpek,inputData,filteredInitialData) {
            let dzoOptions = _.cloneDeep(this.dzoOptions.withoutKMGFilter);
            let actualUpdatedByOpek = inputActualUpdatedByOpek;
            let pkiIndex = actualUpdatedByOpek.findIndex(element => element.dzoMonth === 'ПКИ');
            let self = this;
            actualUpdatedByOpek.splice(pkiIndex, 1);
            _.forEach(dzoOptions, function(item) {
                if (self.companiesForNominalInput.includes(item.dzoName)) {
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

            actualUpdatedByOpek = this.getSorted(actualUpdatedByOpek,this.sortingOrderWithoutParticipation);
            if (this.buttonMonthlyTab || this.buttonYearlyTab) {
                actualUpdatedByOpek = this.getUpdatedByPeriodPlan(actualUpdatedByOpek);
            }

            return actualUpdatedByOpek;
        },

        updateProductionTotalFact(filteredByCompaniesYesterday,summary,todayDzoSummaryWithoutTroubledCompanies) {
            let oldFactFormatted = parseFloat(summary.fact.replace(/\s/g, ''));
            let oldPlanFormatted = parseFloat(summary.plan.replace(/\s/g, ''));
            this.productionParams['oil_fact'] = _.sumBy(todayDzoSummaryWithoutTroubledCompanies,'factMonth');
            this.productionParams['oil_plan'] = _.sumBy(todayDzoSummaryWithoutTroubledCompanies,'planMonth');
            this.productionPercentParams['oil_fact'] = _.sumBy(filteredByCompaniesYesterday,'factMonth');
            this.productionParamsWidget.oilFact = oldFactFormatted;
            this.productionParamsWidget.oilPlan = oldPlanFormatted;
        },

        deleteTroubleCompanies(yesterdayProductionDetails) {
            let indexes = this.getElementIndexesByCompany(yesterdayProductionDetails,'ПКИ','dzoMonth');
            for (var i in indexes.reverse()) {
                yesterdayProductionDetails.splice(indexes[i], 1);
            }
            return yesterdayProductionDetails;
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
    }
}
