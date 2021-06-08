import moment from "moment";

export default {
    data: function () {
        return {
            productionTableData: [],
            dzoNameMapping: {
                'ОМГ': this.trans("visualcenter.consolidatedDzoNameMapping.OMG"),
                'ОМГК': this.trans("visualcenter.consolidatedDzoNameMapping.OMGK"),
                'ММГ': this.trans("visualcenter.consolidatedDzoNameMapping.MMG"),
                'ЭМГ': this.trans("visualcenter.consolidatedDzoNameMapping.EMG"),
                'КБМ': this.trans("visualcenter.consolidatedDzoNameMapping.KBM"),
                'КГМ': this.trans("visualcenter.consolidatedDzoNameMapping.KGM"),
                'КТМ': this.trans("visualcenter.consolidatedDzoNameMapping.KTM"),
                'КОА': this.trans("visualcenter.consolidatedDzoNameMapping.KOA"),
                'УО': this.trans("visualcenter.consolidatedDzoNameMapping.YO"),
                'ТШ': this.trans("visualcenter.consolidatedDzoNameMapping.TSH"),
                'ТШО': this.trans("visualcenter.consolidatedDzoNameMapping.TSH"),
                'НКО': this.trans("visualcenter.consolidatedDzoNameMapping.NKO"),
                'КПО': this.trans("visualcenter.consolidatedDzoNameMapping.KPO"),
                'ПКИ': this.trans("visualcenter.consolidatedDzoNameMapping.PKI"),
                'ПККР': this.trans("visualcenter.consolidatedDzoNameMapping.PKKR"),
                'КГМКМГ': this.trans("visualcenter.consolidatedDzoNameMapping.KGMKMG"),
                'ТП': this.trans("visualcenter.consolidatedDzoNameMapping.TP"),
                'АГ': this.trans("visualcenter.consolidatedDzoNameMapping.AG"),
                'НКОН': this.trans("visualcenter.consolidatedDzoNameMapping.NKON"),
                'НКОС': this.trans("visualcenter.consolidatedDzoNameMapping.NKOS"),
            },
        };
    },
    methods: {
        getConsolidatedOilCondensate() {
            let updatedData = _.cloneDeep(this.productionTableData);
            let filteredInitialData = this.getProductionDataInPeriodRange(updatedData,this.timestampToday,this.timestampEnd);
            let filteredDataByCompanies = this.getFilteredCompaniesList(updatedData);
            let filteredDataByPeriod = this.getProductionDataInPeriodRange(filteredDataByCompanies,this.timestampToday,this.timestampEnd);
            filteredDataByPeriod = this.getDataOrderedByAsc(filteredDataByPeriod);
            if (this.isOneDateSelected) {
                filteredDataByPeriod = this.getFilteredDataByOneDay(filteredDataByCompanies);
                filteredInitialData = this.getFilteredDataByOneDay(filteredInitialData);
            }
            let self = this;
            let initialData = _.cloneDeep(this.dzoCompanySummary);
            _.forEach(initialData, function(item) {
                item.opekPlan = self.getOpekPlanForCompany(item.dzoMonth,filteredDataByPeriod);
            });
            let calculatedData = this.getCalculatedParticipations(initialData,filteredDataByPeriod,filteredInitialData);
            let sortedData = this.getSorted(calculatedData);
            console.log(sortedData);
            return sortedData;
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
            let updatedData = summaryData;
            updatedData = this.getUpdatedByDzoOptions(updatedData,inputData,filteredInitialData);
            return updatedData;
        },

        getUpdatedByDzoOptions(updatedData,inputData,filteredInitialData) {
            let self = this;
            let dzoOptions = this.getDzoOptions(inputData,filteredInitialData);

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
            let factorOptions = {
                'ММГ': 0.5,
                'КБМ': 0.5,
                'КГМ': 0.5,
                'КОА': 0.5,
                'ТШО': 0.2,
                'КПО': 0.1,
            }
            let temporaryData = updatedData;
            let tpIndex = temporaryData.findIndex(element => element.dzoMonth === 'ТП');
            let pkkIndex = temporaryData.findIndex(element => element.dzoMonth === 'ПКК');
            temporaryData.splice(tpIndex, 1);
            temporaryData.splice(pkkIndex, 1);

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
                if (factorOptions[item.dzoMonth]) {
                    item.factMonth *= factorOptions[item.dzoMonth];
                    item.opekPlan *= factorOptions[item.dzoMonth];
                    item.planMonth *= factorOptions[item.dzoMonth];
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

        getSorted(inputData) {
            let sorted = [];
            let sortingOrder = ['ОМГ','ОМГК','ММГ','ЭМГ','КБМ',
                'КГМ','КТМ','КОА','УО','ТШО','НКО','КПО','ПКИ',
                'ПККР','КГМКМГ','ТП','АГ','НКОН','НКОС'];
            _.forEach(sortingOrder, function (key) {
                let itemIndex = inputData.findIndex(element => element.dzoMonth === key);
                sorted.push(inputData[itemIndex]);
            });
            return sorted;
        },
    }
}