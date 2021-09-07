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
            },
            backendSelectedCategory: 'oilCondensateProduction',
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
            backendSelectedView: 'day',
            backendProductionTableData: [],
            backendProductionChartData: [],
            backendMarginMapping: {
                'oilCondensateProduction': [1,13,14,15],
                'oilCondensateDelivery': [1,11,12,13],
            },
            backendDatePickerConfig: {
                start: {
                    timeAdjust: '00:00:00',
                    type: 'string',
                    mask: 'YYYY-MM-DDTHH:mm:ssXXX',
                },
                end: {
                    timeAdjust: '23:59:00',
                    type: 'string',
                    mask: 'YYYY-MM-DDTHH:mm:ssXXX',
                },
            },
            backendDatePickerModel: {
                start: moment().startOf('day').subtract(1, "days").format(),
                end: moment().endOf('day').subtract(1, "days").format(),
                formatInput: true,
            },
            backendDisabledDate: moment().subtract(1,'days').format(),
            backendMenu: {
                'oilCondensateProduction': true,
                'oilCondensateProductionWithoutKMG': false,
                'oilCondensateProductionCondensateOnly': false,
                'oilCondensateDelivery': false,
                'oilCondensateDeliveryWithoutKMG': false,
                'oilCondensateDeliveryOilResidue': false,
                'oilCondensateDeliveryCondensateOnly': false,
                'gasProduction': false,
                'naturalGasProduction': false,
                'associatedGasProduction': false,
                'associatedGasFlaring': false,
                'naturalGasDelivery': false,
                'expensesForOwnNaturalGas': false,
                'associatedGasDelivery': false,
                'expensesForOwnAssociatedGas': false,
                'waterInjection': false,
                'seaWaterInjection': false,
                'wasteWaterInjection': false,
                'artezianWaterInjection': false
            },
            backendFlagOn: '<svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                '<path fill-rule="evenodd" clip-rule="evenodd" d="M12.4791 0.469238H2.31923C1.20141 0.469238 0.297516 1.38392 0.297516 2.50136L0.287109 18.7576L7.39917 15.7094L14.5112 18.7576V2.50136C14.5112 1.38392 13.5969 0.469238 12.4791 0.469238Z" fill="#2E50E9"/>' +
                '</svg>',
            backendFlagOff: '<svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg"> \n' +
                '<path fill-rule="evenodd" clip-rule="evenodd" d="M12.8448 0.286987H2.68496C1.56713 0.286987 0.663191 1.20167 0.663191 2.31911L0.652832 18.5754L7.76489 15.5272L14.877 18.5754V2.31911C14.877 1.20167 13.9627 0.286987 12.8448 0.286987Z" fill="#656A8A"/>' +
                '</svg>',
            backendPreviousCategory: 'oilCondensateProduction',
            backendDoubleFilter: ['oilCondensateProductionWithoutKMG','oilCondensateDeliveryWithoutKMG'],
            backendCondensateCompanies: {
                'ОМГК': {
                    'id': '1.1.'
                },
                'АГ': {
                    'id': '1.2.'
                }
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
                'periodType' : this.backendSelectedView
            };
            let uri = this.localeUrl("/get-production-params-by-category");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status !== 200) {
                return [];
            }
            return response.data;
        },
        backendUpdateSummaryFact(productionName,deliveryName) {
            this.backendSummary.oilProductionFact = _.sumBy(this.backendProductionParams.tableData.current[productionName],'fact');
            this.backendSummary.oilProductionPlan = _.sumBy(this.backendProductionParams.tableData.current[productionName],'plan');
            this.backendSummary.oilDeliveryFact = _.sumBy(this.backendProductionParams.tableData.current[deliveryName],'fact');
            this.backendSummary.oilDeliveryPlan = _.sumBy(this.backendProductionParams.tableData.current[deliveryName],'plan');
            this.backendSummary.gasProductionFact = _.sumBy(this.backendProductionParams.tableData.current['gasProduction'],'fact');
            this.backendSummary.gasProductionPlan = _.sumBy(this.backendProductionParams.tableData.current['gasProduction'],'plan');
            this.backendHistoricalSummaryFact.oilProductionFact = _.sumBy(this.backendProductionParams.tableData.historical[productionName],'fact');
            this.backendHistoricalSummaryFact.oilDeliveryFact = _.sumBy(this.backendProductionParams.tableData.historical[deliveryName],'fact');
            this.backendHistoricalSummaryFact.gasProductionFact = _.sumBy(this.backendProductionParams.tableData.historical['gasProduction'],'fact');
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
            if (view === 'period') {
                this.backendPeriodStart = moment(this.backendDatePickerModel.start, 'DD.MM.YYYY').startOf('day');
                this.backendPeriodEnd = moment(this.backendDatePickerModel.end, 'DD.MM.YYYY').endOf('day');
            } else {
                this.backendPeriodStart = moment().startOf(view);
                this.backendPeriodEnd = moment().subtract(1,'days').endOf('day');
            }
            if (view === 'day') {
                this.backendPeriodStart = this.backendPeriodStart.subtract(1,'days');
            }
            if (view === 'month' && moment().date() < 3) {
                this.backendPeriodStart = this.backendPeriodStart.subtract(3,'days');
            }
            if (view !== 'year') {
                this.isFilterTargetPlanActive = false;
            }
            this.backendPeriodRange = this.backendPeriodEnd.diff(this.backendPeriodStart, 'days');
            this.backendHistoricalPeriodEnd = this.backendPeriodStart.clone().subtract(1,'days').endOf('day');
            this.backendHistoricalPeriodStart = this.backendHistoricalPeriodEnd.clone().subtract(this.backendPeriodRange,'days');
            this.backendSwitchSelectedButton(view);
            this.backendProductionParams = await this.backendGetProductionParamsByCategory();
            this.backendProductionTableData = this.backendProductionParams.tableData.current[this.backendSelectedCategory];
            if (this.backendPeriodRange > 0) {
                this.backendProductionChartData = this.backendGetSummaryForChart();
                this.exportDzoCompaniesSummaryForChart(this.backendProductionChartData);
            }
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
            } else if(view === 'period') {
                this.buttonPeriodTab = this.highlightedButton;
            }
        },

        async backendSwitchCategory(category,parent) {
            let isWithoutKmg = this.backendDoubleFilter.includes(category);
            let isFilterChanged = category === this.backendSelectedCategory;
            let shouldRecalculateSummary = false;
            for (let item in this.backendMenu) {
                if (item === category || this.backendDoubleFilter.includes(category)) {
                    continue;
                }
                this.backendMenu[item] = false;
            }
            this.backendMenu[parent] = true;
            if (!isWithoutKmg) {
                this.backendMenu[category] = !this.backendMenu[category];
            } else {
                this.backendMenu['oilCondensateProductionWithoutKMG'] = !this.backendMenu['oilCondensateProductionWithoutKMG'];
                this.backendMenu['oilCondensateDeliveryWithoutKMG'] = !this.backendMenu['oilCondensateDeliveryWithoutKMG'];
            }
            if (isWithoutKmg && this.backendMenu[category]) {
                shouldRecalculateSummary = true;
            }
            if (isFilterChanged) {
                this.backendSelectedCategory = this.backendPreviousCategory;
            } else {
                this.backendPreviousCategory = parent;
                this.backendSelectedCategory = category;
            }
            this.SET_LOADING(true);
            this.backendProductionParams = await this.backendGetProductionParamsByCategory();
            this.backendProductionTableData = this.backendProductionParams.tableData.current[this.backendSelectedCategory];
            if (this.backendPeriodRange > 0) {
                this.backendProductionChartData = this.backendGetSummaryForChart();
                this.exportDzoCompaniesSummaryForChart(this.backendProductionChartData);
            }
            this.SET_LOADING(false);
            this.backendProductionTableData = _.cloneDeep(this.backendProductionParams.tableData.current[this.backendSelectedCategory]);
            if (['oilCondensateProductionCondensateOnly','oilCondensateDeliveryCondensateOnly'].includes(category) && !isFilterChanged) {
                this.backendProductionTableData = _.cloneDeep(this.backendProductionParams.tableData.current[parent]);
                this.backendProductionTableData = this.backendGetFilteredByDzo(this.backendProductionTableData,this.backendCondensateCompanies);
            }
            if (this.backendPeriodRange !== 0) {
                return;
            }
            if (shouldRecalculateSummary) {
                this.backendUpdateSummaryFact('oilCondensateProductionWithoutKMG','oilCondensateDeliveryWithoutKMG');
            } else {
                this.backendUpdateSummaryFact('oilCondensateProduction','oilCondensateDelivery');
            }
        },
        backendGetFilteredByDzo(data,dzoList) {
            let filtered = data.filter(record => Object.keys(dzoList).includes((record.name)));
            for (let i in filtered) {
                filtered[i].id = dzoList[filtered[i].name].id;
            }
            return filtered;
        },
        backendGetSummaryForChart() {
            let chartData = _.cloneDeep(this.backendProductionParams.chartData);
            if (this.backendSelectedDzo !== null) {
                chartData = _.filter(chartData, (item) => {
                    return item.name === this.backendSelectedDzo;
                });
            }
            _.forEach(chartData, (item) => {
                item.date = moment(item.date, 'DD/MM/YYYY').valueOf();
            });
            return _(chartData)
                .groupBy("date")
                .map((item, date) => ({
                    time: date,
                    productionFactForChart: _.round(_.sumBy(item, 'fact'), 0),
                    productionPlanForChart: _.round(_.sumBy(item, 'plan'), 0),
                    productionPlanForChart2: _.round(_.sumBy(item, 'opek'), 0),
                }))
                .value();
        },
    },
    computed: {
        backendSummaryYearlyPlan() {
            return _.sumBy(this.backendProductionTableData, 'yearlyPlan');
        },
        backendSummaryMonthlyPlan() {
            return _.sumBy(this.backendProductionTableData, 'monthlyPlan');
        },
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
        this.backendUpdateSummaryFact('oilCondensateProduction','oilCondensateDelivery');
        this.backendProductionTableData = this.backendProductionParams.tableData.current[this.backendSelectedCategory];
        this.SET_LOADING(false);
    }
}