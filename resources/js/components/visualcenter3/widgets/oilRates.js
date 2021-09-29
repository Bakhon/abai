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
            periodSelectOil: "",
            oilPeriod: 7,
            defaultOilPeriod: 7,
            oilChart: "",
            dailyOilPriceChange: '',
        };
    },
    methods: {
        updateCurrentOilPrices(period) {
            this.oilPeriod = period;
            this.usdPeriod = period;
            let uri = this.localeUrl("/get-oil-rates");
            this.setDataAndChart(uri, 'oil');
        },

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

        periodSelect() {
            if (this.period === 0) {
                return this.$moment(new Date()).diff(this.$moment(new Date()).subtract(7, 'days'), 'days') + 1;
            }
            if (this.period === 1) {
                return this.$moment(new Date()).diff(this.$moment(new Date()).subtract(1, 'months'), 'days') + 1;
            }
            if (this.period === 2) {
                return this.$moment(new Date()).diff(this.$moment(new Date()).subtract(3, 'months'), 'days') + 1;
            }
            if (this.period === 3) {
                return this.$moment(new Date()).diff(this.$moment(new Date()).subtract(1, 'years'), 'days') + 1;
            }
            if (this.period === 4) {
                return null;
            }
        },
    },
    computed: {
        oilRatesDataTableForCurrentPeriod() {
            this.sortOilRatesDataForTable;
            if (typeof(this.oilPeriod) == 'number' && this.oilRatesData.for_table.length > 0) {
                return this.oilRatesData.for_table.slice(0, this.oilPeriod);
            }
            return this.oilRatesData.for_table;
        },

        sortOilRatesDataForTable() {
            this.oilRatesData.for_table.sort((a, b) => {
                return moment(b.date_string, 'DD.MM.YYYY') - moment(a.date_string, 'DD.MM.YYYY');
            });
        },
    },
}