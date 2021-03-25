import moment from "moment";

export default {
    data: function () {
        return {
            usdRatesData: {
                for_chart: [],
                for_table: []
            },
            currencyNow: "",
            currencyChartData: "",
            currencyNowUsd: "",
            selectedUsdPeriod: 0,
            usdPeriod: 7,
            dailyCurrencyChangeUsd: 0,
            dailyCurrencyChangeIndexUsd: '',
        };
    },
    methods: {
        getCurrencyNow(dates) {
            let uri = this.localeUrl("/getcurrency?fdate=") + dates + "";

            this.axios.get(uri).then((response) => {
                let data = response.data;


                if (data) {
                    this.currencyNow = parseInt(data.description * 10) / 10;
                    this.currencyNowUsd = parseInt(data.description * 10) / 10;
                    this.dailyCurrencyChangeUsd = Math.abs(parseFloat(data.change));
                    this.dailyCurrencyChangeIndexUsd = data.index;
                } else {
                    console.log("No data");
                }
            });
        },

        updateCurrentUsdPrices(period) {
            this.isPricesChartLoading = true;
            this.usdPeriod = period;
            let uri = this.localeUrl("/get-usd-rates");
            this.setDataAndChart(uri, 'usd');
            this.isPricesChartLoading = false;
        },

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