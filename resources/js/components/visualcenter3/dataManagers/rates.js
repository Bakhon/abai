
export default {
    data: function () {
        return {
            prices: {
                'oil': {},
                'usd': {}
            },
            period: 0,
        };
    },
    methods: {
        setDataAndChart(uri, type) {
            let ratesData;
            this.axios.get(uri).then((response) => {
                let data = response.data;
                if (!data) {
                    console.log("No data");
                    return;
                }
                ratesData = this.getRatesData(data, ratesData);
                this.setQuotes(type, ratesData.for_chart);
                if (type === 'oil') {
                    this.setOilPlacements(ratesData);
                } else {
                    this.setUsdPlacements(ratesData);
                }
            });
        },

        getRatesData(data, ratesData) {
            ratesData = {
                for_chart: [],
                for_table: []
            };
            let previousPrice = 0.00;
            let self = this;
            _.forEach(data, function (item) {
                let currentPrice = parseFloat(item['value']);
                let changeValue = ((currentPrice - previousPrice) / previousPrice * 100).toFixed(2);
                self.pushRatesData(item, changeValue, ratesData);
                self.pushRatesChart(item, ratesData);
                previousPrice = currentPrice;
            });
            return ratesData;
        },

        pushRatesData(item, changeValue, ratesData) {
            ratesData.for_table.push({
                date_string: this.$moment(item['date']).format('DD.MM.YYYY'),
                value: parseFloat(item['value']),
                change: Math.abs(changeValue),
                index: changeValue > 0 ? 'UP' : 'DOWN'
            });
        },

        pushRatesChart(item, ratesData) {
            ratesData.for_chart.push([
                new Date(item['date']).getTime(),
                parseFloat(item['value']),
            ]);
        },

        getSortedQuotesData(chartData) {
            return _.orderBy(
                chartData,
                [0],
                ["desc"]
            );
        },

        setQuotes(type, chartData) {
            let sortedData = this.getSortedQuotesData(chartData);
            this.setPrices(type, 'current', sortedData[0][1]);
            this.setPrices(type, 'previous', sortedData[1][1]);
            this.setPrices(type, 'previousFetchDate', sortedData[1][0]);
        },

        setPrices(type, pricesKey, value) {
            this.prices[type][pricesKey] = value;
        },

        updatePrices(period) {
            this.updateCurrentUsdPrices(period);
            this.updateCurrentOilPrices(period);
        },
    },
}