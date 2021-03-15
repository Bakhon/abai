import moment from "moment";

export default {
    data: function () {
        return {
            usdRatesData: {
                for_chart: [],
                for_table: []
            },
        };
    },
    methods: {
        setUsdPlacements(ratesData) {
            this.usdRatesData = ratesData;
            if (this.period === 0) {
                this.usdPeriod = this.defaultOilPeriod;
            }
            this.usdRatesData.for_chart = this.usdRatesDataChartForCurrentPeriod();
        },

        usdRatesDataChartForCurrentPeriod() {
            return this.usdRatesData.for_chart.slice(this.usdPeriod * -1);
        },
    },
    computed: {
        usdRatesDataTableForCurrentPeriod() {
            this.sortUsdRatesDataForTable;
            return this.usdRatesData.for_table.slice(0, this.usdPeriod);
        },

        sortUsdRatesDataForTable() {
            this.usdRatesData.for_table.sort((a, b) => {
                return moment(b.date_string, 'DD.MM.YYYY') - moment(a.date_string, 'DD.MM.YYYY');
            });
        },
    },
}