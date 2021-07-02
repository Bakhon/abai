export default {
    data: function () {
        return {

        };
    },
    methods: {
        getProductionProgressBarData(planFieldName,factFieldName) {
            return (this.productionParams[factFieldName] / this.productionParams[planFieldName]) * 100;
        },

        updateNamesParams(planFieldName,factFieldName,chartHeadName,metricName,chartSecondaryName) {
            this.planFieldName = planFieldName;
            this.factFieldName = factFieldName;
            this.chartHeadName = chartHeadName;
            this.metricName = metricName;
            this.chartSecondaryName = chartSecondaryName;
        },

        updateSecondaryParams(inputData) {
            let filteredDataByCompanies = this.getFilteredDataByOneCompany(inputData);
            let filteredDataByPeriod = this.getProductionDataInPeriodRange(filteredDataByCompanies,this.timestampToday,this.timestampEnd);
            if (this.selectedSecondaryOption === 'injection') {
                this.updateInjectionWells(filteredDataByPeriod,filteredDataByCompanies);
            } else if (this.selectedSecondaryOption === 'production') {
                this.updateProductionWells(filteredDataByPeriod,filteredDataByCompanies);
            }
        },

        updateInjectionWells(filteredDataByPeriod,filteredDataByCompanies) {
            this.updateWellsWidgetData(filteredDataByPeriod,'inj_wells_work','inj_wells_idle');
            this.updateWellsPercentWidgetData(filteredDataByCompanies,'inj_wells_work','inj_wells_idle','inj_wells_workPercent','inj_wells_idlePercent');
            this.injectionWells = this.getSummaryWells(filteredDataByPeriod,this.wellStockIdleButtons.isInjectionIdleButtonActive,'injectionFonds');
            this.innerWellsChartData = this.getSummaryInjectionWellsForChart(filteredDataByPeriod);
        },

        updateProductionWells(filteredDataByPeriod,filteredDataByCompanies) {
            this.updateWellsWidgetData(filteredDataByPeriod,'prod_wells_work','prod_wells_idle');
            this.updateWellsPercentWidgetData(filteredDataByCompanies,'prod_wells_work','prod_wells_idle','prod_wells_workPercent','prod_wells_idlePercent');
            this.productionWells = this.getSummaryWells(filteredDataByPeriod, this.wellStockIdleButtons.isProductionIdleButtonActive,'productionFonds');
            this.innerWells2ChartData = this.getSummaryProductionWellsForChart(filteredDataByPeriod);
        },

        clearNullAccidentCases() {
            _.forEach(this.bigTable, function (item) {
                if (item.accident && typeof (item.accident) !== 'number') {
                    item.accident = item.accident.toString().replace(/null/g, '');
                }
                if (item.restrictions && typeof (item.restrictions) !== 'number') {
                    item.restrictions = item.restrictions.toString().replace(/null/g, '');
                }
            })
        },
    }
}