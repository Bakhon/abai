export default {
    data: function () {
        return {

        };
    },
    methods: {
        getProductionProgressBarData(planFieldName,factFieldName) {
            return (this.productionParams[factFieldName] / this.productionParams[planFieldName]) * 100;
        },
    }
}