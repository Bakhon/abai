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
            categoryMapping: {
                'oilCondensateProduction': {
                    'plan': 'oilProductionPlan',
                    'fact': 'oilProductionFact',
                    'opek': 'productionOpek'
                }
            },
            backendProductionTableData: []
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
            _.forEach(Object.keys(this.backendSummary), (key) => {
                this.backendSummary[key] = _.sumBy(this.backendProductionParams.tableData,key);
                if (!this.backendSummary[key]) {
                    this.backendSummary[key] = 0;
                }
            });
            _.forEach(Object.keys(this.backendHistoricalSummaryFact), (key) => {
                this.backendHistoricalSummaryFact[key] = _.sumBy(this.backendProductionParams.historicalTableData,key);
                if (!this.backendHistoricalSummaryFact[key]) {
                    this.backendHistoricalSummaryFact[key] = 0;
                }
            });
        },
        getBackendProgress(fact,plan) {
            return (fact / plan) * 100;
        },
        getBackendTableDataByView() {
            let formatted = [];
            _.forEach(this.backendProductionParams.tableData, (item) => {
                let selectedCategoryTableData = item;
                selectedCategoryTableData.plan = item[this.categoryMapping[this.backendSelectedCategory]['plan']];
                selectedCategoryTableData.fact = item[this.categoryMapping[this.backendSelectedCategory]['fact']];
                selectedCategoryTableData.opek = item[this.categoryMapping[this.backendSelectedCategory]['opek']];
                if (this.buttonMonthlyTab) {
                    selectedCategoryTableData['monthlyPlan'] = item.monthlyPlan;
                }
                if (this.buttonYearlyTab) {
                    selectedCategoryTableData['yearlyPlan'] = item.yearlyPlan;
                }
                formatted.push(selectedCategoryTableData);
            });
            return formatted;
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
        console.log(this.categoryMapping[this.backendSelectedCategory]['plan'])
        this.SET_LOADING(true);

        this.backendProductionParams = await this.backendGetProductionParamsByCategory();
        console.log('done backend');
        console.log(this.backendProductionParams);
        console.log('summary');
        this.backendUpdateSummaryFact();
        this.backendProductionTableData = this.getBackendTableDataByView();
        console.log(this.backendProductionTableData);

        this.SET_LOADING(false);
    }
}