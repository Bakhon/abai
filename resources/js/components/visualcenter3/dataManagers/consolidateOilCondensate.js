import moment from "moment";
import dzoCompaniesNameMapping from "../dzo_companies_consolidated_name_mapping.json"
import companiesListWithKMG from "../dzo_companies_initial_consolidated_withkmg.json";
import companiesListWithoutKMG from "../dzo_companies_initial_consolidated_withoutkmg.json";
import mainMenuConfiguration from "../main_menu_configuration.json";

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
                'ОМГ','ОМГК','ММГ','ЭМГ','КБМ','КГМ','КТМ','КОА',
                'УО','ТШО','ПКК','ТП','КПО','НКО','АГ'
            ],
            consolidatedData: {
                'withParticipation': [],
                'withoutParticipation': [],
                'yesterdayWithParticipation': [],
                'yesterdayWithoutParticipation': [],
                'chartWithParticipation': [],
                'chartWithoutParticipation': [],
                'oilCondensateProductionButton': {
                    'current': [],
                    'yesterday': [],
                    'currentWithoutKMG': [],
                    'yesterdayWithoutKMG': [],
                    'currentWithKMG': [],
                    'yesterdayWithKMGKMG': []
                },
                'oilCondensateDeliveryButton': {
                    'current': [],
                    'yesterday': [],
                    'currentWithoutKMG': [],
                    'yesterdayWithoutKMG': [],
                    'currentWithKMG': [],
                    'yesterdayWithKMGKMG': []
                }
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
                'isWithoutKMGFilterActive': true,
                'isCondensateOnly': false
            },
            nkoMapping: {
                'formula': (value) => Math.round(((value - value * 0.019) * 241 / 1428) / 2)
            },
            dzoMultiplier: {
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
            },
            selectedView: 'oilCondensateDeliveryButton',
            productionSummary: {
                'oilCondensateProductionButton': {
                    'actual': {
                        'oilFact': 0,
                        'oilPlan': 0,
                        'progress': 0
                    },
                    'yesterday': {
                        'oilFact': 0
                    }
                },
                'oilCondensateDeliveryButton': {
                    'actual': {
                        'oilFact': 0,
                        'oilPlan': 0,
                        'progress': 0
                    },
                    'yesterday': {
                        'oilFact': 0
                    }
                }
            },
            condensateCompanies: ['ОМГК','АГ']
        };
    },
    methods: {
        getConsolidatedBy(periodType) {
            if (periodType === 'current') {
                return this.consolidatedData.withParticipation;
            } else if (periodType === 'yesterday') {
                return this.consolidatedData.yesterdayWithParticipation;
            }
            return [];
        },

        switchFilterConsolidatedOilCondensate(parentButton,childButton,filterName) {
            this.oilCondensateFilters[filterName] = !this.oilCondensateFilters[filterName];
            this.chartOutput = this.consolidatedData.chartWithParticipation;
            this.dzoCompanySummary = this.consolidatedData.withParticipation;
            this.yesterdaySummary = this.consolidatedData.yesterdayWithParticipation;
            this.changeDzoCompaniesList(companiesListWithKMG);
            if (!this.oilCondensateFilters.isWithoutKMGFilterActive) {
                this.chartOutput = this.consolidatedData.chartWithoutParticipation;
                this.dzoCompanySummary = this.consolidatedData.withoutParticipation;
                this.yesterdaySummary = this.consolidatedData.yesterdayWithoutParticipation;
                this.changeDzoCompaniesList(companiesListWithoutKMG);
            }
            this.dzoCompanies = _.cloneDeep(this.dzoCompaniesTemplate);
            _.forEach(this.dzoCompanies, function (dzo) {
                _.set(dzo, 'selected', true);
            });
            this.selectDzoCompanies();
            let elementOptions = this.mainMenuButtonElementOptions[parentButton].childItems[childButton];
            this.switchButtonOptions(elementOptions);
            if (this.oilCondensateFilters.isCondensateOnly) {
               this.updateByCondensateOnly();
            }
            this.calculateDzoCompaniesSummary();
        },
        updateByCondensateOnly() {
            this.dzoCompanySummary = _.filter(this.dzoCompanySummary, (company) => this.condensateCompanies.includes(company.dzoMonth));
            this.yesterdaySummary = _.filter(this.dzoCompanySummary, (company) => this.condensateCompanies.includes(company.dzoMonth));
            _.forEach(this.dzoCompanies, (dzo) => {
                if (!this.condensateCompanies.includes(dzo.ticker)) {
                    dzo.selected = false;
                }
            });
        },
        updateConsolidatedOilCondensate(periodStart,periodEnd,periodName,summary) {
            let self = this;
            let filteredByCompanies = this.getFilteredCompaniesList(_.cloneDeep(this.productionTableData));
            let filteredByPeriod = this.getFilteredByPeriod(filteredByCompanies,true,periodStart,periodEnd);
            let filteredInitial = this.getFilteredByPeriod(_.cloneDeep(this.productionTableData),false,periodStart,periodEnd);

            let actualUpdatedByOpek = this.getUpdatedByOpekPlan(summary,filteredByPeriod);
            let dataWithKMGParticipation = this.getUpdatedByDzoOptions(_.cloneDeep(actualUpdatedByOpek),filteredByPeriod,filteredInitial);
            let dataWithoutKMGParticipation = this.getUpdatedByDzoOptionsWithoutKMG(_.cloneDeep(actualUpdatedByOpek),filteredByPeriod,filteredInitial);
            this.updateConsolidatedData(dataWithKMGParticipation,dataWithoutKMGParticipation,periodStart,periodEnd,periodName);
            let output = this.consolidatedData.withParticipation;
            this.chartOutput = this.consolidatedData.chartWithParticipation;
            this.isOpecFilterActive = true;
            if (!this.oilCondensateFilters.isWithoutKMGFilterActive) {
                output = this.consolidatedData.withoutParticipation;
                this.chartOutput = this.consolidatedData.chartWithoutParticipation;
            }
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

            if (periodName === 'current') {
                this.consolidatedData[this.selectedButtonName].currentWithoutKMG = sortedWithoutKMGParticipation;
                this.consolidatedData[this.selectedButtonName].currentWithKMG = sortedWithKMGParticipation;
                this.consolidatedData.withParticipation = sortedWithKMGParticipation;
                this.consolidatedData.withoutParticipation = sortedWithoutKMGParticipation;
            } else {
                this.consolidatedData[this.selectedButtonName].yesterdayWithoutKMG = sortedWithoutKMGParticipation;
                this.consolidatedData[this.selectedButtonName].yesterdayWithKMG = sortedWithKMGParticipation;
                this.consolidatedData.yesterdayWithParticipation = sortedWithKMGParticipation;
                this.consolidatedData.yesterdayWithoutParticipation = sortedWithoutKMGParticipation;
            }

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
                if (item.dzo === 'АГ') {
                    item.oil_fact = item.gk_fact;
                    item.oil_plan = item.gk_plan;
                }
            });

            this.consolidatedData.chartWithParticipation = withKMG;
            this.consolidatedData.chartWithoutParticipation = withoutKMG;
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
                if (item.opekPlan === null || item.opekPlan === 0) {
                    item.opekPlan = item.planMonth;
                }
            });

            let pkiIndex = actualUpdatedByOpek.findIndex(element => element.dzoMonth === 'ПКИ');
            if (pkiIndex > -1) {
                actualUpdatedByOpek[pkiIndex].factMonth = pkiSummary.factMonth;
                actualUpdatedByOpek[pkiIndex].planMonth = pkiSummary.planMonth;
                actualUpdatedByOpek[pkiIndex].opekPlan = pkiSummary.opekPlan;
            } else {
                pkiSummary.dzoMonth = 'ПКИ';
                actualUpdatedByOpek.push(pkiSummary);
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

        updateProductionTotalFact(yesterdaySummary,actualSummary,viewName) {
            this.productionSummary[viewName].actual.oilFact = _.sumBy(actualSummary,'factMonth');
            this.productionSummary[viewName].actual.oilPlan = _.sumBy(actualSummary,'planMonth');
            this.productionSummary[viewName].actual.progress = this.getProductionProgress(viewName);
            this.productionSummary[viewName].yesterday.oilFact = _.sumBy(yesterdaySummary,'factMonth');
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

        getProductionProgress(viewName) {
            return (this.productionSummary[viewName].actual.oilFact / this.productionSummary[viewName].actual.oilPlan) * 100;
        },

        getFilteredForChartBySelectedCompanies() {
            let result = this.chartOutput.filter(item => this.selectedDzoCompanies.includes(item.dzo));
            let troubledCompanies = {
                'ОМГК':'ОМГ',
                'ПККР':'ПКК',
                'КГМКМГ':'КГМ',
            };
            _.forEach(Object.keys(troubledCompanies), (key) => {
                if (this.selectedDzoCompanies.includes(key)) {
                    result = result.concat(this.getConsolidatedByTroubledCompanies(troubledCompanies[key]));
                }
            });
            if (this.selectedDzoCompanies.includes('ПКИ')) {
                let childCompanies = this.getConsolidatedByTroubledCompanies('ОМГ');
                childCompanies = childCompanies.concat(this.getConsolidatedByTroubledCompanies('ПКК'));
                childCompanies = childCompanies.concat(this.getConsolidatedByTroubledCompanies('КГМ'));
                let consolidated = this.getConsolidatedByPKI(childCompanies,'ПКИ');
                result = result.concat(consolidated);
            }
            return result;
        },
        getConsolidatedByTroubledCompanies(parentCompany) {
            let result = [];
            let filtered = this.chartOutput.filter(item => item.dzo === parentCompany);
            let multiplier = this.consolidatedOptions[parentCompany];
            _.forEach(filtered, (item) => {
                let parent = _.cloneDeep(item);
                parent.dzo = multiplier.dzo,
                parent.oil_fact = multiplier.formula(multiplier.fact,item),
                parent.oil_opek_plan = multiplier.formula(multiplier.opek,item),
                parent.oil_plan = multiplier.formula(multiplier.plan,item),
                result.push(parent);
            });
            return result;
        },
        getConsolidatedByPKI(input, parentDzo) {
            let filtered = input.filter(item => ['КГМКМГ','ОМГК','ПККР'].includes(item.dzo));
            let result = [];
            if (filtered.length === 0) {
                return result;
            }
            filtered = _.groupBy(filtered, 'date');
            _.forEach(filtered, (items) => {
                let template = _.cloneDeep(items[0]);
                template.dzo = parentDzo;
                _.forEach(items, (item) => {
                    template.oil_fact += item.oil_fact;
                    template.oil_opek_plan += item.oil_opek_plan;
                    template.oil_plan += item.oil_plan;
                });
                result.push(template);
            });
            return result;
        },
    }
}
