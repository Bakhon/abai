import moment from "moment";

export default {
    data: function () {
        return {
            productionTableData: []
        };
    },
    methods: {
        getConsolidatedOilCondensate() {
            let filteredDataByCompanies = this.getFilteredCompaniesList(this.productionTableData);
            let filteredDataByPeriod = this.getProductionDataInPeriodRange(filteredDataByCompanies,this.timestampToday,this.timestampEnd);
            filteredDataByPeriod = this.getDataOrderedByAsc(filteredDataByPeriod);
            if (this.isOneDateSelected) {
                filteredDataByPeriod = this.getFilteredDataByOneDay(filteredDataByCompanies);
            } else {
                filteredDataByPeriod = this.getDataOrderedByAsc(filteredDataByPeriod);
            }
            let self = this;
            let initialData = this.dzoCompanySummary;
            _.forEach(initialData, function(item) {
                item.opekPlan = self.getOpekPlanForCompany(item.dzoMonth,filteredDataByPeriod);
            });
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
    }
}