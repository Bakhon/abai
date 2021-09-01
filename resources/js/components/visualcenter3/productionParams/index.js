import moment from "moment";

export default {
    data: function () {
        return {
            backendPeriodStart: moment().subtract(1,'days'),
            backendPeriodEnd: moment().subtract(1,'days').endOf('day'),
            backendHistoricalPeriodStart: moment(),
            backendHistoricalPeriodEnd: moment().subtract(2,'days').endOf('day'),
            backendPeriodRange: 0,
            backendSelectedDzo: null,
            backendProductionParams: {
                'tableData': [],
                'chartData': [],
                'historicalTableData': []
            },
            backendSelectedCategory: 'oilCondensateProduction',
            backendSelectedFilter: [],
            backendSummary: {
                'oilProductionFact': 0,
                'oilProductionPlan': 0,
                'oilDeliveryFact': 0,
                'oilDeliveryPlan': 0,
                'gasProductionFact': 0,
                'gasProductionPlan': 0,
            },
            backendHistoricalSummaryFact: {
                'oilProductionFact': 0,
                'oilDeliveryFact': 0,
                'gasProductionFact': 0
            },
            backendSelectedView: 'daily',
            backendProductionTableData: [],
            backendMarginMapping: {
                'oilCondensateProduction': [1,13,14,15],
                'oilCondensateDelivery': [1,11,12,13],
            }
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
        },
        backendUpdateSummaryFact() {
            this.backendSummary.oilProductionFact = _.sumBy(this.backendProductionParams.tableData.current.oilCondensateProduction,'fact');
            this.backendSummary.oilProductionPlan = _.sumBy(this.backendProductionParams.tableData.current.oilCondensateProduction,'plan');
            this.backendSummary.oilDeliveryFact = _.sumBy(this.backendProductionParams.tableData.current.oilCondensateDelivery,'fact');
            this.backendSummary.oilDeliveryPlan = _.sumBy(this.backendProductionParams.tableData.current.oilCondensateDelivery,'plan');
            this.backendHistoricalSummaryFact.oilProductionFact = _.sumBy(this.backendProductionParams.tableData.historical.oilCondensateProduction,'fact');
            this.backendHistoricalSummaryFact.oilDeliveryFact = _.sumBy(this.backendProductionParams.tableData.historical.oilCondensateDelivery,'fact');
        },
        getBackendProgress(fact,plan) {
            return (fact / plan) * 100;
        },
        async backendSwitchView(view) {
            this.SET_LOADING(true);
            this.buttonDailyTab = "";
            this.buttonMonthlyTab = "";
            this.buttonYearlyTab = "";
            this.buttonPeriodTab = "";
            this.backendSelectedView = view;
            this.backendPeriodStart = moment().startOf(view).subtract(1,'days');
            if (view === 'month' && this.backendPeriodStart.date() < 3) {
                this.backendPeriodStart = this.backendPeriodStart.subtract(3,'days');
            }
            this.backendPeriodEnd = moment().subtract(1,'days').endOf('day');
            this.backendPeriodRange = this.backendPeriodEnd.diff(this.backendPeriodStart, 'days');
            this.backendHistoricalPeriodEnd = this.backendPeriodStart.clone().subtract(1,'days').endOf('day');
            this.backendHistoricalPeriodStart = this.backendHistoricalPeriodEnd.clone().subtract(this.backendPeriodRange,'days');
            this.backendSwitchSelectedButton(view);
            this.backendProductionParams = await this.backendGetProductionParamsByCategory();
            console.log('done backend');
            console.log(this.backendProductionParams);
            this.backendProductionTableData = this.backendProductionParams.tableData.current[this.backendSelectedCategory];
            this.SET_LOADING(false);
        },
        backendSwitchSelectedButton(view) {
            if (view !== 'year') {
                this.isFilterTargetPlanActive = false;
            }
            if (view === 'day') {
                this.buttonDailyTab = this.highlightedButton;
            } else if (view === 'month') {
                this.buttonMonthlyTab = this.highlightedButton;
            } else if (view === 'year') {
                this.buttonYearlyTab = this.highlightedButton;
            }
        },
        backendSwitchCategory(category,button) {
            this.oilCondensateProductionButton = "";
            this.oilCondensateDeliveryButton = "";
            this[button] = "button-tab-highlighted";
            this.backendSelectedCategory = category;
            this.backendProductionTableData = this.backendProductionParams.tableData.current[category];
            console.log(this.backendProductionTableData);
        }
    },
    computed: {
        backendSummaryFact() {
            return _.sumBy(this.backendProductionTableData, 'fact');
        },
        backendSummaryPlan() {
            return _.sumBy(this.backendProductionTableData, 'plan');
        },
        backendSummaryOpek() {
            return _.sumBy(this.backendProductionTableData, 'opek');
        },
        backendSummaryDifference() {
            return _.sumBy(this.backendProductionTableData, 'plan') - _.sumBy(this.backendProductionTableData, 'fact');
        },
        backendSummaryOpekDifference() {
            return _.sumBy(this.backendProductionTableData, 'opek') - _.sumBy(this.backendProductionTableData, 'fact');
        }
    },
    created() {
        this.backendPeriodRange = this.backendPeriodEnd.diff(this.backendPeriodStart, 'days');
        this.backendHistoricalPeriodStart = this.backendPeriodStart.clone().subtract(1,'days');
    },
    async mounted() {
        this.SET_LOADING(true);
        this.backendProductionParams = await this.backendGetProductionParamsByCategory();
        console.log('done backend');
        console.log(this.backendProductionParams);
        this.backendUpdateSummaryFact();
        this.backendProductionTableData = this.backendProductionParams.tableData.current[this.backendSelectedCategory];
        this.SET_LOADING(false);
        console.log(this.buttonMonthlyTab);

    }
}