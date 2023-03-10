import moment from "moment";

export default {
    data: function () {
        return {
            periodStart: moment().subtract(1,'days'),
            periodEnd: moment().subtract(1,'days').endOf('day'),
            historicalPeriodStart: moment(),
            historicalPeriodEnd: moment().subtract(2,'days').endOf('day'),
            periodRange: 0,
            productionParams: {
                'tableData': [],
                'chartData': [],
            },
            selectedCategory: 'oilCondensateProduction',
            selectedView: 'day',
            productionTableData: [],
            productionChartData: [],
            troubleCategories: [
                'oilCondensateProduction',
                'oilCondensateDelivery',
                'oilCondensateProductionWithoutKMG',
                'oilCondensateDeliveryWithoutKMG'
            ],
            datePickerModel: {
                start: moment().startOf('day').subtract(1, "days").format(),
                end: moment().endOf('day').subtract(1, "days").format(),
                formatInput: true,
            },
            disabledDate: moment().subtract(1,'days').format(),
            minimumDate: moment().startOf('year').startOf('day').format(),
            mainMenu: {
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
                'processingAssociatedGas': false,
                'waterInjection': false,
                'seaWaterInjection': false,
                'wasteWaterInjection': false,
                'artezianWaterInjection': false,
                'streamWaterInjection': false,
                'volgaWaterInjection': false
            },
            flagOn: '<svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                '<path fill-rule="evenodd" clip-rule="evenodd" d="M12.4791 0.469238H2.31923C1.20141 0.469238 0.297516 1.38392 0.297516 2.50136L0.287109 18.7576L7.39917 15.7094L14.5112 18.7576V2.50136C14.5112 1.38392 13.5969 0.469238 12.4791 0.469238Z" fill="#2E50E9"/>' +
                '</svg>',
            flagOff: '<svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg"> \n' +
                '<path fill-rule="evenodd" clip-rule="evenodd" d="M12.8448 0.286987H2.68496C1.56713 0.286987 0.663191 1.20167 0.663191 2.31911L0.652832 18.5754L7.76489 15.5272L14.877 18.5754V2.31911C14.877 1.20167 13.9627 0.286987 12.8448 0.286987Z" fill="#656A8A"/>' +
                '</svg>',
            previousCategory: 'oilCondensateProduction',
            doubleFilter: ['oilCondensateProductionWithoutKMG','oilCondensateDeliveryWithoutKMG'],
            condensateCompanies: {
                '????????': {
                    'id': '1.1.'
                },
                '????': {
                    'id': '1.2.'
                }
            },
            companiesWithData: [],
            exceptionDzo: ['????????????','????','????????'],
            todayDate: moment().subtract(2,'days').format('DD.MM.YYYY'),
            summaryMapping: {
                'oilProduction': ['oilCondensateProductionWithoutKMG','oilCondensateProduction'],
                'condensateProduction': ['oilCondensateProductionCondensateOnly'],
                'oilDelivery': ['oilCondensateDeliveryWithoutKMG','oilCondensateDelivery','oilCondensateDeliveryOilResidue'],
                'condensateDelivery': ['oilCondensateDeliveryCondensateOnly'],
            },
            parentCategory: 'oilCondensateProduction'
        }
    },
    methods: {
        async getProductionParamsByCategory() {
            let queryOptions = {
                'periodStart': this.periodStart.format(),
                'periodEnd': this.periodEnd.format(),
                'historicalPeriodStart': this.historicalPeriodStart.format(),
                'historicalPeriodEnd': this.historicalPeriodEnd.format(),
                'periodRange': this.periodRange,
                'dzoName': this.oneDzoSelected,
                'category': this.selectedCategory,
                'periodType' : this.selectedView
            };

            let uri = this.localeUrl("/get-production-params-by-category");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status !== 200) {
                return [];
            }
            return response.data;
        },
        getProgress(fact,plan) {
            return (fact / plan) * 100;
        },

        getSummaryFact(data,fieldName) {
            let summary = 0;
            _.forEach(data, (item) => {
                if (!this.exceptionDzo.includes(item.name) && item[fieldName]) {
                    summary += item[fieldName];
                }
            });
            return summary;
        },

        async switchView(view) {
            this.selectAllDzoCompanies();
            this.SET_LOADING(true);
            this.buttonDailyTab = "";
            this.buttonMonthlyTab = "";
            this.buttonYearlyTab = "";
            this.buttonPeriodTab = "";
            this.selectedView = view;
            if (view === 'period') {
                this.periodStart = moment(this.datePickerModel.start, 'DD.MM.YYYY').startOf('day');
                this.periodEnd = moment(this.datePickerModel.end, 'DD.MM.YYYY').endOf('day');
            } else {
                this.periodStart = moment().startOf(view);
                this.periodEnd = moment().subtract(1,'days').endOf('day');
            }
            if (view === 'day') {
                this.periodStart = this.periodStart.subtract(1,'days');
            }
            if (view === 'month' && moment().date() < 3) {
                this.periodStart = this.periodStart.subtract(3,'days');
            }
            if (view !== 'year') {
                this.isFilterTargetPlanActive = false;
            }
            this.periodRange = this.periodEnd.diff(this.periodStart, 'days');
            this.historicalPeriodEnd = this.periodStart.clone().subtract(1,'days').endOf('day');
            this.historicalPeriodStart = this.historicalPeriodEnd.clone().subtract(this.periodRange,'days');
            this.switchSelectedButton(view);
            this.productionParams = await this.getProductionParamsByCategory();
            this.productionTableData = this.productionParams.tableData.current[this.selectedCategory];
            if (['oilCondensateProductionCondensateOnly','oilCondensateDeliveryCondensateOnly'].includes(this.selectedCategory) && !this.productionTableData) {
                this.productionTableData = _.cloneDeep(this.productionParams.tableData.current[this.parentCategory]);
                this.productionTableData = this.getFilteredByDzo(this.productionTableData,this.condensateCompanies);
            }
            if (this.periodRange > 0) {
                this.companiesWithData = _.map(this.productionTableData, 'name');
                this.productionChartData = this.getSummaryForChart();
                this.exportDzoCompaniesSummaryForChart(this.productionChartData);
            } else if (view === 'period') {
                this.isDecreaseReasonActive = false;
            }
            this.chartReasons = this.getReasonExplanations();
            this.productionData = _.cloneDeep(this.productionTableData);
            this.productionData = this.getFilteredTableData();
            this.SET_LOADING(false);
        },

        switchSelectedButton(view) {
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

        async switchCategory(category,parent) {
            this.parentCategory = parent;
            this.isDecreaseReasonActive = false;
            this.selectedChartCategory.head = this.chartNameMapping[category].head;
            this.selectedChartCategory.name = this.chartNameMapping[category].name;
            this.selectedChartCategory.metric = this.chartNameMapping[category].metric;
            let isFilterChanged = category === this.selectedCategory;
            for (let item in this.mainMenu) {
                if (item === category) {
                    continue;
                }
                this.mainMenu[item] = false;
            }

            this.mainMenu[category] = !this.mainMenu[category];
            this.mainMenu[parent] = true;

            if (isFilterChanged) {
                this.selectedCategory = this.previousCategory;
            } else {
                this.previousCategory = parent;
                this.selectedCategory = category;
            }
            this.SET_LOADING(true);
            this.productionParams = await this.getProductionParamsByCategory();
            this.productionTableData = this.productionParams.tableData.current[this.selectedCategory];
            if (this.periodRange > 0) {
                this.productionChartData = this.getSummaryForChart();
                this.exportDzoCompaniesSummaryForChart(this.productionChartData);
            }
            this.SET_LOADING(false);
            this.productionTableData = _.cloneDeep(this.productionParams.tableData.current[this.selectedCategory]);
            if (['oilCondensateProductionCondensateOnly','oilCondensateDeliveryCondensateOnly'].includes(category) && !isFilterChanged) {
                this.productionTableData = _.cloneDeep(this.productionParams.tableData.current[parent]);
                this.productionTableData = this.getFilteredByDzo(this.productionTableData,this.condensateCompanies);
            }

            if (!this.mainMenu[category]) {
                this.productionTableData = _.cloneDeep(this.productionParams.tableData.current[parent]);
                this.selectedCategory = parent;
            }
            this.chartReasons = this.getReasonExplanations();
            this.productionData = this.getFilteredTableData();
            if (this.productionData.length === 0) {
                this.selectAllDzoCompanies();
                this.productionData = _.cloneDeep(this.productionTableData);
            }
            if (this.periodRange !== 0) {
                this.companiesWithData = _.map(this.productionTableData, 'name');
                this.productionChartData = this.getSummaryForChart();
                this.exportDzoCompaniesSummaryForChart(this.productionChartData);
                return;
            }
        },
        getFilteredByDzo(data,dzoList) {
            let filtered = data.filter(record => Object.keys(dzoList).includes((record.name)));
            for (let i in filtered) {
                filtered[i].id = dzoList[filtered[i].name].id;
            }
            return filtered;
        },
        getSummaryForChart() {
            let chartData = _.cloneDeep(this.productionParams.chartData);
            if (this.oneDzoSelected !== null) {
                chartData = _.filter(chartData, (item) => {
                    return item.name === this.oneDzoSelected;
                });
            } else {
                chartData = _.filter(chartData, (item) => {
                   return this.selectedDzoCompanies.includes(item.name)
                });
            }
            _.forEach(chartData, (item) => {
                item.date = moment(item.date, 'DD/MM/YYYY').valueOf();
            });
            let summary = _(chartData)
                .groupBy("date")
                .map((item, date) => ({
                    time: date,
                    productionFactForChart: _.round(_.sumBy(item, 'fact'), 0),
                    productionPlanForChart: _.round(_.sumBy(item, 'plan'), 0),
                    productionPlanForChart2: _.round(_.sumBy(item, 'opek'), 0),
                }))
                .value();

            if (!this.isFilterTargetPlanActive) {
                return summary;
            }
            return this.getMonthlyPlansInYear(summary);
        },
        getSummaryByCategorySelected(data,field) {
            return this.getSummaryByFieldForCompany(data,field);
        },
        getSummaryByCondensateSelected(data,field,type) {
            let condensate = _.filter(data, (item) => {
                return Object.keys(this.condensateCompanies).includes(item.name);
            });
            return this.getSummaryByFieldForCompany(condensate,field);
        },
        getSummaryByFieldForCompany(data,fieldName) {
            let summary = 0;
            _.forEach(data, (item) => {
                if (!this.exceptionDzo.includes(item.name) && this.selectedDzoCompanies.includes(item.name)) {
                    summary += item[fieldName];
                }
            });
            return summary;
        },
    },
    computed: {
        summaryYearlyPlan() {
            let filtered = [];
            _.forEach(this.productionData, (item) => {
                if (!['????????','????????????','????'].includes(item.name)) {
                    filtered.push(item);
                }
            });
            if (this.mainMenu.oilCondensateProduction && !this.mainMenu.oilCondensateProductionWithoutKMG && !this.mainMenu.oilCondensateProductionCondensateOnly) {
                return _.sumBy(filtered, 'yearlyPlan');
            }
            return _.sumBy(this.productionData, 'yearlyPlan');
        },
        summaryMonthlyPlan() {
            return _.sumBy(this.productionData, 'monthlyPlan');
        },
        summaryFact() {
            let activeCategories = this.getActiveCategoriesCount();
            if (activeCategories === 1) {
                return this.getSummaryFact(this.productionData,'fact');
            }
            return this.getSummaryByField(this.productionData,'fact');
        },
        summaryPlan() {
            let activeCategories = this.getActiveCategoriesCount();
            if (activeCategories === 1) {
                return this.getSummaryFact(this.productionData,'plan');
            }
            return this.getSummaryByField(this.productionData,'plan');
        },
        summaryOpek() {
            let activeCategories = this.getActiveCategoriesCount();
            if (activeCategories === 1) {
                return this.getSummaryFact(this.productionData,'opek');
            }
            return this.getSummaryByField(this.productionData,'opek');
        },
        summaryDifference() {
            return this.summaryPlan - this.summaryFact;
        },
        summaryOpekDifference() {
            return this.summaryOpek - this.summaryFact;
        },
        summaryTargetPlan() {
            return _.sumBy(this.productionData, 'yearlyPlan') - _.sumBy(this.productionData, 'plan');
        },
        summaryOilFact() {
            if (!this.productionParams.tableData.current) {
                return 0;
            }
            if (this.summaryMapping.oilProduction.includes(this.selectedCategory)) {
                return this.getSummaryByCategorySelected(this.productionParams.tableData.current[this.selectedCategory],'fact');
            }
            if (this.summaryMapping.condensateProduction.includes(this.selectedCategory)) {
                return this.getSummaryByCondensateSelected(this.productionParams.tableData.current.oilCondensateProduction,'fact','current');
            }
            return this.getSummaryByCategorySelected(this.productionParams.tableData.current.oilCondensateProduction,'fact');
        },
        summaryHistoricalOilFact() {
            if (!this.productionParams.tableData.historical) {
                return 0;
            }
            if (this.summaryMapping.oilProduction.includes(this.selectedCategory)) {
                return this.getSummaryByCategorySelected(this.productionParams.tableData.historical[this.selectedCategory],'fact');
            }
            if (this.summaryMapping.condensateProduction.includes(this.selectedCategory)) {
                return this.getSummaryByCondensateSelected(this.productionParams.tableData.historical.oilCondensateProduction,'fact','historical');
            }
            return this.getSummaryByCategorySelected(this.productionParams.tableData.historical.oilCondensateProduction,'fact');
        },
        summaryOilPlan() {
            if (!this.productionParams.tableData.current) {
                return 0;
            }
            if (this.summaryMapping.oilProduction.includes(this.selectedCategory)) {
                return this.getSummaryByCategorySelected(this.productionParams.tableData.current[this.selectedCategory],'plan');
            }
            if (this.summaryMapping.condensateProduction.includes(this.selectedCategory)) {
                return this.getSummaryByCondensateSelected(this.productionParams.tableData.current.oilCondensateProduction,'plan','plan production');
            }
            return this.getSummaryByCategorySelected(this.productionParams.tableData.current.oilCondensateProduction,'plan');
        },
        summaryOilDeliveryFact() {
            if (!this.productionParams.tableData.current) {
                return 0;
            }
            if (this.summaryMapping.oilDelivery.includes(this.selectedCategory)) {
                return this.getSummaryByCategorySelected(this.productionParams.tableData.current[this.selectedCategory],'fact');
            }
            if (this.summaryMapping.condensateDelivery.includes(this.selectedCategory)) {
                return this.getSummaryByCondensateSelected(this.productionParams.tableData.current.oilCondensateDelivery,'fact');
            }
            return this.getSummaryByCategorySelected(this.productionParams.tableData.current.oilCondensateDelivery,'fact');
        },
        summaryHistoricalOilDeliveryFact() {
            if (!this.productionParams.tableData.historical) {
                return 0;
            }
            if (this.summaryMapping.oilDelivery.includes(this.selectedCategory)) {
                return this.getSummaryByCategorySelected(this.productionParams.tableData.historical[this.selectedCategory],'fact');
            }
            if (this.summaryMapping.condensateDelivery.includes(this.selectedCategory)) {
                return this.getSummaryByCondensateSelected(this.productionParams.tableData.historical.oilCondensateDelivery,'fact');
            }
            return this.getSummaryByCategorySelected(this.productionParams.tableData.historical.oilCondensateDelivery,'fact');
        },
        summaryOilDeliveryPlan() {
            if (!this.productionParams.tableData.current) {
                return 0;
            }
            if (this.summaryMapping.oilDelivery.includes(this.selectedCategory)) {
                return this.getSummaryByCategorySelected(this.productionParams.tableData.current[this.selectedCategory],'plan');
            }
            if (this.summaryMapping.condensateDelivery.includes(this.selectedCategory)) {
                return this.getSummaryByCondensateSelected(this.productionParams.tableData.current.oilCondensateDelivery,'plan','plan delivery');
            }
            return this.getSummaryByCategorySelected(this.productionParams.tableData.current.oilCondensateDelivery,'plan');
        },
        summaryGasProductionFact() {
            if (!this.productionParams.tableData.current) {
                return 0;
            }
            if (this.selectedCategory.toLowerCase().includes('gas')) {
                return this.getSummaryFact(this.productionParams.tableData.current[this.selectedCategory],'fact');
            }
            return this.getSummaryFact(this.productionParams.tableData.current.gasProduction,'fact');
        },
        summaryGasPlan() {
            if (!this.productionParams.tableData.current) {
                return 0;
            }
            if (this.selectedCategory.toLowerCase().includes('gas')) {
                return this.getSummaryFact(this.productionParams.tableData.current[this.selectedCategory],'plan');
            }
            return this.getSummaryFact(this.productionParams.tableData.current.gasProduction,'plan');
        },
        summaryGasHistoricalFact() {
            if (!this.productionParams.tableData.historical) {
                return 0;
            }
            if (this.selectedCategory.toLowerCase().includes('gas')) {
                return this.getSummaryFact(this.productionParams.tableData.historical[this.selectedCategory],'fact');
            }
            return this.getSummaryFact(this.productionParams.tableData.historical.gasProduction,'fact');
        },
    },
}