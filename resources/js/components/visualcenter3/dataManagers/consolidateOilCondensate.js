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
            console.log(calculatedData);
            return initialData;
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
            let self = this;
            let updatedData = summaryData;
            updatedData.push({
                'dzoMonth': 'ОМГК',
                'factMonth': this.getValueFromInput('gk_fact','ОМГ',inputData),
                'opekPlan' : this.getValueFromInput('gk_plan','ОМГ',inputData),
                'planMonth': this.getValueFromInput('gk_plan','ОМГ',inputData),
            });
            updatedData.push({
                'dzoMonth': 'ПККР',
                'factMonth': Math.round(this.getValueFromInput('oil_fact','ПКК',inputData) * 0.33),
                'opekPlan' : Math.round(this.getValueFromInput('oil_opek_plan','ПКК',inputData) * 0.33),
                'planMonth': Math.round(this.getValueFromInput('oil_plan','ПКК',inputData) * 0.33),
            });
            updatedData.push({
                'dzoMonth': 'КГМКМГ',
                'factMonth': Math.round(this.getValueFromInput('oil_fact','КГМ',inputData) * 0.5 * 0.33),
                'opekPlan' : Math.round(this.getValueFromInput('oil_opek_plan','КГМ',inputData) * 0.5 * 0.33),
                'planMonth': Math.round(this.getValueFromInput('oil_plan','КГМ',inputData) * 0.5 * 0.33),
            });
            updatedData.push({
                'dzoMonth': 'ТП',
                'factMonth': Math.round(this.getValueFromInput('oil_fact','ТП',inputData) * 0.5 * 0.33),
                'opekPlan' : Math.round(this.getValueFromInput('oil_opek_plan','ТП',inputData) * 0.5 * 0.33),
                'planMonth': Math.round(this.getValueFromInput('oil_plan','ТП',inputData) * 0.5 * 0.33),
            });
            updatedData.push({
                'dzoMonth': 'АГ',
                'factMonth': this.getValueFromInput('gk_fact','АГ',filteredInitialData),
                'opekPlan' : this.getValueFromInput('gk_plan','АГ',filteredInitialData),
                'planMonth': this.getValueFromInput('gk_plan','АГ',filteredInitialData),
            });
            updatedData.push({
                'dzoMonth': 'НКОН',
                'factMonth': (this.getValueFromInput('oil_fact','НКО',inputData) - this.getValueFromInput('oil_fact','НКО',inputData) * 0.019) * 241 / 1428,
                'opekPlan' : (this.getValueFromInput('oil_opek_plan','НКО',inputData) - this.getValueFromInput('oil_opek_plan','НКО',inputData) * 0.019) * 241 / 1428,
                'planMonth': (this.getValueFromInput('oil_plan','НКО',inputData) - this.getValueFromInput('oil_plan','НКО',inputData) * 0.019) * 241 / 1428,
            });
            let pkiSummary = {
                'factMonth': Math.round(this.getValueFromInput('oil_fact','ПКК',inputData) * 0.33) +
                  Math.round(this.getValueFromInput('oil_fact','КГМ',inputData) * 0.5 * 0.33) +
                  Math.round(this.getValueFromInput('oil_fact','ТП',inputData) * 0.5 * 0.33),
                'planMonth': Math.round(this.getValueFromInput('oil_plan','ПКК',inputData) * 0.33) +
                    Math.round(this.getValueFromInput('oil_plan','КГМ',inputData) * 0.5 * 0.33) +
                    Math.round(this.getValueFromInput('oil_plan','ТП',inputData) * 0.5 * 0.33),
                'opekPlan': Math.round(this.getValueFromInput('oil_opek_plan','ПКК',inputData) * 0.33) +
                    Math.round(this.getValueFromInput('oil_opek_plan','КГМ',inputData) * 0.5 * 0.33) +
                    Math.round(this.getValueFromInput('oil_opek_plan','ТП',inputData) * 0.5 * 0.33),
            };
            let nkoSummary = {
                'factMonth': (this.getValueFromInput('oil_fact','НКО',inputData) - this.getValueFromInput('oil_fact','НКО',inputData) * 0.019) * 241 / 1428,
                'planMonth': (this.getValueFromInput('oil_plan','НКО',inputData) - this.getValueFromInput('oil_plan','НКО',inputData) * 0.019) * 241 / 1428,
                'opekPlan' : (this.getValueFromInput('oil_opek_plan','НКО',inputData) - this.getValueFromInput('oil_opek_plan','НКО',inputData) * 0.019) * 241 / 1428
            }
            updatedData.push({
                'dzoMonth': 'НКОС',
                'factMonth': nkoSummary.factMonth / 2,
                'opekPlan' : nkoSummary.opekPlan / 2,
                'planMonth': nkoSummary.planMonth / 2,
            });
            let pkkIndex = 0;
            _.forEach(updatedData, function(item, index) {
                if (item.dzoMonth === 'ММГ') {
                    item.factMonth = item.factMonth * 0.5;
                    item.opekPlan = item.opekPlan * 0.5;
                    item.planMonth = item.planMonth * 0.5;
                }
                if (item.dzoMonth === 'КБМ') {
                    item.factMonth = item.factMonth * 0.5;
                    item.opekPlan = item.opekPlan * 0.5;
                    item.planMonth = item.planMonth * 0.5;
                }
                if (item.dzoMonth === 'КГМ') {
                    item.factMonth = item.factMonth * 0.5;
                    item.opekPlan = item.opekPlan * 0.5;
                    item.planMonth = item.planMonth * 0.5;
                }
                if (item.dzoMonth === 'КОА') {
                    item.factMonth = item.factMonth * 0.5;
                    item.opekPlan = item.opekPlan * 0.5;
                    item.planMonth = item.planMonth * 0.5;
                }
                if (item.dzoMonth === 'ТШО') {
                    item.factMonth = item.factMonth * 0.2;
                    item.opekPlan = item.opekPlan * 0.2;
                    item.planMonth = item.planMonth * 0.2;
                }
                if (item.dzoMonth === 'КПО') {
                    item.factMonth = item.factMonth * 0.1;
                    item.opekPlan = item.opekPlan * 0.1;
                    item.planMonth = item.planMonth * 0.1;
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
                if (item.dzoMonth === 'ПКК') {
                    pkkIndex = index;
                }
            });
            updatedData.splice(pkkIndex, 1);
            return updatedData;
        },

        getValueFromInput(fieldName, dzoName, data) {
            let updatedValue = 0;
            _.forEach(data, function(item) {
                if (item.dzo === dzoName) {
                    updatedValue = Math.round(updatedValue + item[fieldName]);
                }
            });
            return updatedValue;
        },
    }
}