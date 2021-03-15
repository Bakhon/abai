import moment from "moment";

export default {
    data: function () {
        return {
            oilRatesData: {
                for_chart: [],
                for_table: []
            },
            oilRatesWidgetData: {
                changePercent: 0,
                index: ''
            },
        };
    },
    methods: {
        setDailyOilPriceChange(currentPrice, previousPrice) {
            if (currentPrice > previousPrice) {
                this.dailyOilPriceChange = 'UP';
            } else {
                this.dailyOilPriceChange = 'DOWN';
            }
        },

        setOilPlacements(ratesData) {
            this.oilRatesData = ratesData;
            this.setDailyOilPriceChange(this.prices['oil']['current'], this.prices['oil']['previous']);

            if (this.period === 0) {
                this.oilPeriod = this.defaultOilPeriod;
            }
            this.oilRatesData.for_chart = this.oilRatesDataChartForCurrentPeriod();
        },

        oilRatesDataChartForCurrentPeriod() {
            return this.oilRatesData.for_chart.slice(this.oilPeriod * -1);
        },
    },
    computed: {
        oilRatesDataTableForCurrentPeriod() {
            this.sortOilRatesDataForTable;
            return this.oilRatesData.for_table.slice(0, this.oilPeriod);
        },

        sortOilRatesDataForTable() {
            this.oilRatesData.for_table.sort((a, b) => {
                return moment(b.date_string, 'DD.MM.YYYY') - moment(a.date_string, 'DD.MM.YYYY');
            });
        },
    },
}