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

        updateSecondaryParams(filteredDataByPeriod,filteredDataByCompanies) {
            this.covid = this.getCovidData(filteredDataByPeriod);
            this.WellsDataAll = this.WellsData(filteredDataByPeriod);
            this.injectionWells = this.getSummaryWells(filteredDataByPeriod,this.wellStockIdleButtons.isInjectionIdleButtonActive,'injectionFonds');
            this.innerWellsChartData = this.getSummaryInjectionWellsForChart(filteredDataByPeriod);
            this.productionWells = this.getSummaryWells(filteredDataByPeriod, this.wellStockIdleButtons.isProductionIdleButtonActive,'productionFonds');
            this.innerWells2ChartData = this.getSummaryProductionWellsForChart(filteredDataByPeriod);
            this.otmData = this.getOtmData(filteredDataByPeriod);
            this.otmChartData = this.getOtmChartData(filteredDataByPeriod);
            this.chemistryData = this.getChemistryData(filteredDataByPeriod);
            this.chemistryChartData = this.getChemistryChartData(filteredDataByPeriod);
            this.getProductionPercentWells(filteredDataByCompanies);
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

        getAccidentTotal() {
            let year = new Date(this.range.end).getFullYear();
            let uri = this.localeUrl("/visualcenter3GetDataAccident?") + "year=" + year + " ";
            this.axios.get(uri).then((response) => {
                let data = Array();
                data = response.data;
                let accidentTotal = [];
                if (data) {
                    _.forEach(data, function (item) {
                        accidentTotal.push(item.tb_accident_total);
                    });
                    this.accidentTotal = accidentTotal[0];
                } else {
                    console.log('No data Accident')
                }
            });
        },
    }
}