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