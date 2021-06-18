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
                'ПККР','КГМКМГ','ТП','АГ','НКОН','НКОС'
            ],
            sortingOrderWithoutParticipation: [
                'ОМГ','ОМГК','ЭМГ','АГ','ТШО','ММГ','КОА','КТМ',
                'КГМ','ПКК','ТП','КБМ','КПО','НКО','УО'
            ],
            consolidatedData: {
                'withParticipation': [],
                'withoutParticipation': [],
                'yesterdayWithParticipation': []
            },
            productionParamsWidget: {
                'oilFact' : 0,
                'oilPlan' : 0,
                'yesterdayOilFact': 0,
                'yesterdayOldFact': 0
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
                    {
                        'dzoMonth': 'НКОН',
                        'dzoName' : 'НКО',
                        'factMonth': 'oil_fact',
                        'opekMonth': 'oil_opek_plan',
                        'planMonth': 'oil_plan',
                        'formula': (fieldName, dzoName,inputData) => {
                            let parameter = this.sumBy(fieldName,dzoName,inputData);
                            return Math.round((parameter - parameter * 0.019) * 241 / 1428);
                        }
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
            }
        };
    },
    methods: {
        switchFilterConsolidatedOilCondensate(parentButton,childButton,filterName) {
            this.oilCondensateFilters[filterName] = !this.oilCondensateFilters[filterName];
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
            let updatedData = _.cloneDeep(this.productionTableData);
            let filteredInitialData = this.getProductionDataInPeriodRange(updatedData,this.timestampToday,this.timestampEnd);
            let filteredDataByCompanies = this.getFilteredCompaniesList(updatedData);
            let filteredDataByPeriod = this.getProductionDataInPeriodRange(filteredDataByCompanies,this.timestampToday,this.timestampEnd);
            filteredDataByPeriod = this.getDataOrderedByAsc(filteredDataByPeriod);

            if (this.isOneDateSelected) {
                filteredDataByPeriod = this.getFilteredDataByOneDay(_.cloneDeep(filteredDataByCompanies),'today');
                filteredInitialData = this.getFilteredDataByOneDay(filteredInitialData,'today');
            }
            let self = this;
            let initialData = _.cloneDeep(this.dzoCompanySummary);
            _.forEach(initialData, function(item) {
                item.opekPlan = self.sumBy('oil_opek_plan',item.dzoMonth,filteredDataByPeriod);
            });
            let dataWithKMGParticipation = this.getUpdatedByDzoOptions(_.cloneDeep(initialData),filteredDataByPeriod,filteredInitialData);
            let sortedWithKMGParticipation = this.getSorted(dataWithKMGParticipation,this.sortingOrder);
            let emptyRecordIndex = sortedWithKMGParticipation.findIndex(element => !element);
            if (emptyRecordIndex !== -1) {
                sortedWithKMGParticipation.splice(emptyRecordIndex, 1);
            }
            let yesterdayData = this.getYesterdayData(_.cloneDeep(this.productionTableData),filteredDataByCompanies);
            let dataWithoutKMGParticipation = this.getUpdatedByDzoOptionsWithoutKMG(_.cloneDeep(initialData),filteredDataByPeriod,filteredInitialData);
            let sortedWithoutKMGParticipation = this.getSorted(dataWithoutKMGParticipation,this.sortingOrderWithoutParticipation);
            if (this.buttonMonthlyTab || this.buttonYearlyTab) {
                sortedWithKMGParticipation = this.getUpdatedByPeriodPlan(sortedWithKMGParticipation);
                sortedWithoutKMGParticipation = this.getUpdatedByPeriodPlan(sortedWithoutKMGParticipation);
            }
            this.updateConsolidatedData(sortedWithKMGParticipation,sortedWithoutKMGParticipation);
            return sortedWithKMGParticipation;
        },

        updateConsolidatedData(sortedWithKMGParticipation,sortedWithoutKMGParticipation) {
            this.consolidatedData.withParticipation = sortedWithKMGParticipation;
            this.consolidatedData.withoutParticipation = sortedWithoutKMGParticipation;
        },

        getUpdatedByDzoOptions(updatedData,inputData,filteredInitialData) {
            let self = this;
            let dzoOptions = _.cloneDeep(this.dzoOptions.default);
            let pkiSummary = {
                'factMonth': 0,
                'planMonth': 0,
                'opekPlan': 0
            };
            let nkoSummary = {
                'factMonth': 0,
                'planMonth': 0,
                'opekPlan': 0
            };
            let temporaryData = updatedData;
            temporaryData = this.getFilteredByNotUsableDzo(temporaryData);

            _.forEach(dzoOptions, function(item) {
                if (item.dzoName === 'АГ') {
                    temporaryData.push({
                        'dzoMonth' : item.dzoMonth,
                        'factMonth' : item.formula(item.factMonth,item.dzoName,filteredInitialData),
                        'opekPlan' : item.formula(item.opekMonth,item.dzoName,filteredInitialData),
                        'planMonth' : item.formula(item.planMonth,item.dzoName,filteredInitialData),
                    });
                } else {
                    temporaryData.push({
                        'dzoMonth' : item.dzoMonth,
                        'factMonth' : item.formula(item.factMonth,item.dzoName,inputData),
                        'opekPlan' : item.formula(item.opekMonth,item.dzoName,inputData),
                        'planMonth' : item.formula(item.planMonth,item.dzoName,inputData),
                    });
                }
                if (['ПКК','КГМ','ТП'].includes(item.dzoName)) {
                    self.updateDzoCompaniesSummary(item,pkiSummary,inputData);
                }
                if (item.dzoName === 'НКО') {
                    self.updateDzoCompaniesSummary(item,nkoSummary,inputData);
                }
            });

            temporaryData.push({
                'dzoMonth': 'НКОС',
                'factMonth': nkoSummary.factMonth / 2,
                'opekPlan' : nkoSummary.opekPlan / 2,
                'planMonth': nkoSummary.planMonth / 2,
            });

            _.forEach(temporaryData, function(item, index) {
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
                    item.factMonth = nkoSummary.factMonth / 2;
                    item.opekPlan = nkoSummary.opekPlan / 2;
                    item.planMonth = nkoSummary.planMonth / 2;
                }
            });

            return temporaryData;
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

        getUpdatedByDzoOptionsWithoutKMG(updatedData,inputData,filteredInitialData) {
            let dzoOptions = _.cloneDeep(this.dzoOptions.withoutKMGFilter);
            let temporaryData = updatedData;
            let pkiIndex = temporaryData.findIndex(element => element.dzoMonth === 'ПКИ');
           temporaryData.splice(pkiIndex, 1);

            _.forEach(dzoOptions, function(item) {
                if (item.dzoName === 'АГ') {
                    temporaryData.push({
                        'dzoMonth' : item.dzoMonth,
                        'factMonth' : item.formula(item.factMonth,item.dzoName,filteredInitialData),
                        'opekPlan' : item.formula(item.opekMonth,item.dzoName,filteredInitialData),
                        'planMonth' : item.formula(item.planMonth,item.dzoName,filteredInitialData),
                    });
                } else {
                    temporaryData.push({
                        'dzoMonth' : item.dzoMonth,
                        'factMonth' : item.formula(item.factMonth,item.dzoName,inputData),
                        'opekPlan' : item.formula(item.opekMonth,item.dzoName,inputData),
                        'planMonth' : item.formula(item.planMonth,item.dzoName,inputData),
                    });
                }
            });
            return temporaryData;
        },

        updateProductionTotalFact() {
            this.productionParams['oil_fact'] = this.productionParamsWidget.oilFact;
            this.productionParams['oil_plan'] = this.productionParamsWidget.oilPlan;
            this.productionPercentParams['oil_fact'] = this.productionParamsWidget.yesterdayOldFact;
        },

        getYesterdayData(productionTable,filteredDataByCompanies) {
            let yesterdayFilteredData = this.getFilteredDataByOneDay(_.cloneDeep(filteredDataByCompanies),'yesterday');
            let periodStart = moment(new Date(this.timestampToday)).subtract(1, 'days').valueOf();
            let filteredInitialData = this.getProductionDataInPeriodRange(productionTable,periodStart,this.timestampToday);
            filteredInitialData = this.getFilteredDataByOneDay(filteredInitialData,'yesterday');
            let groupedData = _(yesterdayFilteredData)
                .groupBy("dzo")
                .map((dzo, id) => ({
                    dzoMonth: id,
                    factMonth: _.round(_.sumBy(dzo, 'oil_fact'), 0),
                    planMonth: _.round(_.sumBy(dzo, 'oil_plan'), 0),
                    opekPlan: _.round(_.sumBy(dzo, 'oil_opek_plan'), 0),
                }))
                .value();
            let dataWithKMGParticipation = this.getUpdatedByDzoOptions(_.cloneDeep(groupedData),yesterdayFilteredData,filteredInitialData);
            this.productionParamsWidget.yesterdayOilFact = _.sumBy(dataWithKMGParticipation, 'factMonth');

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
    }
}