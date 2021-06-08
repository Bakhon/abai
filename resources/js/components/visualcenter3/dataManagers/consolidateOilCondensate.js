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
            isWithoutKMGFilterActive: true,
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
        };
    },
    methods: {
        switchFilterConsolidatedOilCondensate() {
            this.isWithoutKMGFilterActive = !this.isWithoutKMGFilterActive;
            if (this.isWithoutKMGFilterActive) {
                this.dzoCompanySummary = this.consolidatedData.withParticipation;
            } else {
                this.dzoCompanySummary = this.consolidatedData.withoutParticipation;
            }
            let elementOptions = this.mainMenuButtonElementOptions['oilCondensateProductionButton'].childItems['withoutKmgParticipation'];
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
                item.opekPlan = self.getOpekPlanForCompany(item.dzoMonth,filteredDataByPeriod);
            });
            let calculatedData = this.getCalculatedParticipations(initialData,filteredDataByPeriod,filteredInitialData);
            let yesterdayData = this.getYesterdayData(_.cloneDeep(this.productionTableData),filteredDataByCompanies);
            let calculatedDataWithoutKMG = this.getCalculatedWithoutParticipations(initialData,filteredDataByPeriod,filteredInitialData);
            this.consolidatedData.withParticipation = this.getSorted(calculatedData,this.sortingOrder);
            this.consolidatedData.withoutParticipation = this.getSorted(calculatedDataWithoutKMG,this.sortingOrderWithoutParticipation);
            return this.consolidatedData.withParticipation;
        },

        getOpekPlanForCompany(dzoName,data) {
            let self = this;
            let opekPlan = 0;
            _.forEach(data, function(item) {
                if (item.dzo === dzoName) {
                    opekPlan = Math.round(opekPlan + item.oil_opek_plan);
                }
            });
            return opekPlan;
        },

        getCalculatedParticipations(summaryData,inputData,filteredInitialData) {
            let updatedData = _.cloneDeep(summaryData);
            updatedData = this.getUpdatedByDzoOptions(updatedData,inputData,filteredInitialData);
            return updatedData;
        },

        getCalculatedWithoutParticipations(summaryData,inputData,filteredInitialData) {
            let updatedData = _.cloneDeep(summaryData);
            updatedData = this.getUpdatedByDzoOptionsWithoutKMG(updatedData,inputData,filteredInitialData);
            return updatedData;
        },

        getUpdatedByDzoOptions(updatedData,inputData,filteredInitialData) {
            let self = this;
            let dzoOptions = _.cloneDeep(this.getDzoOptions(inputData,filteredInitialData));
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
                temporaryData.push({
                    'dzoMonth' : item.dzoMonth,
                    'factMonth' : item.formula(item.factMonth,item.dzoName),
                    'opekPlan' : item.formula(item.opekMonth,item.dzoName),
                    'planMonth' : item.formula(item.planMonth,item.dzoName),
                });
                if (['ПКК','КГМ','ТП'].includes(item.dzoName)) {
                    self.updateDzoCompaniesSummary(item,pkiSummary);
                }
                if (item.dzoName === 'НКО') {
                    self.updateDzoCompaniesSummary(item,nkoSummary);
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

        getDzoOptions(inputData,filteredInitialData) {
            let self = this;
            return [
                {
                    'dzoMonth': 'ОМГК',
                    'dzoName' : 'ОМГ',
                    'factMonth': 'gk_fact',
                    'opekMonth': 'gk_plan',
                    'planMonth': 'gk_plan',
                    'formula': (fieldName, dzoName) => {
                        return Math.round(self.getInitialFromInputData(fieldName,dzoName,inputData));
                    }
                },
                {
                    'dzoMonth': 'ПККР',
                    'dzoName' : 'ПКК',
                    'factMonth': 'oil_fact',
                    'opekMonth': 'oil_opek_plan',
                    'planMonth': 'oil_plan',
                    'formula': (fieldName, dzoName) => {
                        let parameter = self.getInitialFromInputData(fieldName,dzoName,inputData);
                        return Math.round(parameter * 0.33);
                    }
                },
                {
                    'dzoMonth': 'КГМКМГ',
                    'dzoName' : 'КГМ',
                    'factMonth': 'oil_fact',
                    'opekMonth': 'oil_opek_plan',
                    'planMonth': 'oil_plan',
                    'formula': (fieldName, dzoName) => {
                        let parameter = self.getInitialFromInputData(fieldName,dzoName,inputData);
                        return Math.round(parameter * 0.5 * 0.33);
                    }
                },
                {
                    'dzoMonth': 'ТП',
                    'dzoName' : 'ТП',
                    'factMonth': 'oil_fact',
                    'opekMonth': 'oil_opek_plan',
                    'planMonth': 'oil_plan',
                    'formula': (fieldName, dzoName) => {
                        let parameter = self.getInitialFromInputData(fieldName,dzoName,inputData);
                        return Math.round(parameter * 0.5 * 0.33);
                    }
                },
                {
                    'dzoMonth': 'АГ',
                    'dzoName' : 'АГ',
                    'factMonth': 'gk_fact',
                    'opekMonth': 'gk_plan',
                    'planMonth': 'gk_plan',
                    'formula': (fieldName, dzoName) => {
                        return self.getInitialFromInputData(fieldName,dzoName,filteredInitialData);
                    }
                },
                {
                    'dzoMonth': 'НКОН',
                    'dzoName' : 'НКО',
                    'factMonth': 'oil_fact',
                    'opekMonth': 'oil_opek_plan',
                    'planMonth': 'oil_plan',
                    'formula': (fieldName, dzoName) => {
                        let parameter = self.getInitialFromInputData(fieldName,dzoName,inputData);
                        return Math.round((parameter - parameter * 0.019) * 241 / 1428);
                    }
                },
            ];
        },

        getInitialFromInputData(fieldName, dzoName, data) {
            let updatedValue = 0;
            _.forEach(data, function(item) {
                if (item.dzo === dzoName) {
                    updatedValue = Math.round(updatedValue + item[fieldName]);
                }
            });
            return updatedValue;
        },

        updateDzoCompaniesSummary(item,summary) {
            summary.factMonth += item.formula(item.factMonth,item.dzoName);
            summary.planMonth += item.formula(item.planMonth,item.dzoName);
            summary.opekPlan += item.formula(item.opekMonth,item.dzoName);
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
            let dzoOptions = this.getDzoOptionsWithoutKMG(inputData,filteredInitialData);
            let temporaryData = updatedData;
            let pkiIndex = temporaryData.findIndex(element => element.dzoMonth === 'ПКИ');
           temporaryData.splice(pkiIndex, 1);

            _.forEach(dzoOptions, function(item) {
                temporaryData.push({
                    'dzoMonth' : item.dzoMonth,
                    'factMonth' : item.formula(item.factMonth,item.dzoName),
                    'opekPlan' : item.formula(item.opekMonth,item.dzoName),
                    'planMonth' : item.formula(item.planMonth,item.dzoName),
                });
            });
            return temporaryData;
        },

        getDzoOptionsWithoutKMG(inputData,filteredInitialData) {
            let self = this;
            return [
                {
                    'dzoMonth': 'ОМГК',
                    'dzoName' : 'ОМГ',
                    'factMonth': 'gk_fact',
                    'opekMonth': 'gk_plan',
                    'planMonth': 'gk_plan',
                    'formula': (fieldName, dzoName) => {
                        return Math.round(self.getInitialFromInputData(fieldName,dzoName,inputData));
                    }
                },
                {
                    'dzoMonth': 'АГ',
                    'dzoName' : 'АГ',
                    'factMonth': 'gk_fact',
                    'opekMonth': 'gk_plan',
                    'planMonth': 'gk_plan',
                    'formula': (fieldName, dzoName) => {
                        return self.getInitialFromInputData(fieldName,dzoName,filteredInitialData);
                    }
                },
            ];
        },

        updateProductionTotalFact() {
            this.productionParams['oil_fact'] = this.productionParamsWidget.oilFact;
            this.productionParams['oil_plan'] = this.productionParamsWidget.oilPlan;
            if (!this.isWithoutKMGFilterActive) {
                this.productionPercentParams['oil_fact'] = this.productionParamsWidget.yesterdayOldFact;
            } else {
                this.productionPercentParams['oil_fact'] = this.productionParamsWidget.yesterdayOilFact;
            }
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
            let calculatedData = this.getCalculatedParticipations(groupedData,yesterdayFilteredData,filteredInitialData);
            this.productionParamsWidget.yesterdayOilFact = _.sumBy(calculatedData, 'factMonth');
            return calculatedData;
        },
        getFilteredByNotUsableDzo(data) {
            let updatedData = data;
            let tpIndex = updatedData.findIndex(element => element.dzoMonth === 'ТП');
            let pkkIndex = updatedData.findIndex(element => element.dzoMonth === 'ПКК');
            updatedData.splice(tpIndex, 1);
            updatedData.splice(pkkIndex, 1);
            return updatedData;
        }
    }
}