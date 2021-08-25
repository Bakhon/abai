import moment from "moment";

export default {
    data: function () {
        return {
            backendPeriodStart: moment().subtract(1,'days'),
            backendPeriodEnd: moment().subtract(1,'days'),
            backendHistoricalPeriodStart: moment(),
            backendHistoricalPeriodEnd: moment().subtract(2,'days').endOf('day'),
            backendPeriodRange: 0,
            backendSelectedDzo: null,
            backendProductionParams: {
                'table': [],
                'chart': {
                    'series': [],
                    'labels': []
                }
            },
            backendSelectedCategory: 'oilCondensateProduction',
            backendSelectedFilter: []
        }
    },
    methods: {
        async backendGetProductionParamsByCategory() {
            let queryOptions = {
                'periodStart': this.backendPeriodStart.format(),
                'periodEnd': this.backendPeriodEnd.format(),
                'historicalPeriodStart': this.backendHistoricalPeriodStart.format(),
                'historicalPeriodEnd': this.backendHistoricalPeriodEnd.format(),
                'periodRange': this.backendPeriodRange,
                'dzoName': this.backendSelectedDzo,
                'category': this.backendSelectedCategory,
                'filter': this.backendSelectedFilter,
            };
            let uri = this.localeUrl("/get-production-params-by-category");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status !== 200) {
                return [];
            }
            return response.data;
        }
    },
    computed: {

    },
    created() {
        this.backendPeriodRange = this.backendPeriodEnd.diff(this.backendPeriodStart, 'days');
        this.backendHistoricalPeriodStart = this.backendPeriodStart.clone().subtract(1,'days');
    },
    async mounted() {
        this.SET_LOADING(true);

        this.backendProductionParams = await this.backendGetProductionParamsByCategory();
        console.log(this.backendProductionParams);

        this.SET_LOADING(false);
    }
}