import moment from "moment";

export default {
    data: function () {
        return {
            productionFondDetails: [],
            productionFondPeriodStart: moment().subtract(1, 'days').startOf('day').format('DD.MM.YYYY'),
            productionFondPeriodEnd: moment().subtract(1, 'days').endOf('day').format('DD.MM.YYYY'),
            productionFondDaysCount: 1,
            productionFondHistoryPeriodStart: moment().subtract(2, 'days').startOf('day').format('DD.MM.YYYY'),
            productionFondHistoryPeriodEnd: moment().subtract(2, 'days').endOf('day').format('DD.MM.YYYY'),
            productionFondDailyPeriod: 'button-tab-highlighted',
            productionFondMonthlyPeriod: '',
            productionFondYearlyPeriod: '',
            productionFondPeriod: '',
            isProductionFondPeriodSelected: false,
            productionFondPeriodMapping: {
                productionFondDailyPeriod: {
                    'start': moment().subtract(1, 'days').startOf('day').format('DD.MM.YYYY'),
                    'end': moment().subtract(1, 'days').endOf('day').format('DD.MM.YYYY'),
                },
                productionFondMonthlyPeriod: {
                    'start': moment().startOf('month').format('DD.MM.YYYY'),
                    'end': moment().format('DD.MM.YYYY'),
                },
                productionFondYearlyPeriod: {
                    'start': moment().startOf('year').format('DD.MM.YYYY'),
                    'end': moment().format('DD.MM.YYYY'),
                },
                productionFondPeriod: {
                    'start': moment().subtract(1, 'days').format('DD.MM.YYYY'),
                    'end': moment().subtract(1, 'days').format('DD.MM.YYYY')
                },
            },
            productionFondSelectedCompany: 'all',
            productionFondSelectedRow: 'operating_production_fond',
            productionFondData: [
                {
                    name: this.trans("visualcenter.exploitationFond"),
                    code: 'operating_production_fond',
                    fact: 0,
                    isVisible: true
                },
                {
                    name: this.trans("visualcenter.operatingFond"),
                    code: 'active_production_fond',
                    fact: 0,
                    isVisible: true
                },
                {
                    name: this.trans("visualcenter.nonOperatingFond"),
                    code: 'inactive_production_fond',
                    fact: 0,
                    isVisible: true
                },
                {
                    name: this.trans("visualcenter.masteringFond"),
                    code: 'developing_production_fond',
                    fact: 0,
                    isVisible: true
                },
                {
                    name: this.trans("visualcenter.liquidationFond"),
                    code: 'pending_liquidation_production_fond',
                    fact: 0,
                    isVisible: true
                },
                {
                    name: this.trans("visualcenter.waitingUndergroundRepairFond"),
                    code: 'prs_wait_downtime_production_wells_count',
                    fact: 0,
                    isVisible: false
                },
                {
                    name: this.trans("visualcenter.undergroundRepairFond"),
                    code: 'prs_downtime_production_wells_count',
                    fact: 0,
                    isVisible: false
                },
                {
                    name: this.trans("visualcenter.waitingOverhaulFond"),
                    code: 'krs_wait_downtime_production_wells_count',
                    fact: 0,
                    isVisible: false
                },
                {
                    name: this.trans("visualcenter.overhaulFond"),
                    code: 'krs_downtime_production_wells_count',
                    fact: 0,
                    isVisible: false
                },
                {
                    name: this.trans("visualcenter.researchFond"),
                    code: 'well_survey_downtime_production_wells_count',
                    fact: 0,
                    isVisible: false
                },
                {
                    name: this.trans("visualcenter.unprofitableFond"),
                    code: 'unprofitable_downtime_production_wells_count',
                    fact: 0,
                    isVisible: false
                },
                {
                    name: this.trans("visualcenter.othersFond"),
                    code: 'other_downtime_production_wells_count',
                    fact: 0,
                    isVisible: false
                },
            ],
            productionFondChartData: [],
            productionFondSum: {
                'actual': {
                    'work': 0,
                    'idle': 0
                },
                'history': {
                    'work': 0,
                    'idle': 0
                }
            },
            productionFondHistory: []
        };
    },
    methods: {
        async switchProductionFondPeriod(buttonType) {
            this.$store.commit('globalloading/SET_LOADING', true);
            this.productionFondDailyPeriod = "";
            this.productionFondMonthlyPeriod = "";
            this.productionFondYearlyPeriod = "";
            this.productionFondPeriod = "";
            this[buttonType] = this.highlightedButton;
            this.productionFondPeriodStart = this.productionFondPeriodMapping[buttonType].start;
            this.productionFondPeriodEnd = this.productionFondPeriodMapping[buttonType].end;
            this.isProductionFondPeriodSelected = this.isProductionFondFewMonthsSelected();
            this.updateProductionFondHistory();
            this.productionFondDetails = await this.getFondByMonth(this.productionFondPeriodStart,this.productionFondPeriodEnd,'production');
            this.productionFondHistory = await this.getFondByMonth(this.productionFondHistoryPeriodStart,this.productionFondHistoryPeriodEnd,'production');
            this.updateProductionFondWidget();
            this.$store.commit('globalloading/SET_LOADING', false);
        },

        async updateProductionFondHistory() {
            this.productionFondHistoryPeriodEnd = moment(this.productionFondPeriodStart,'DD.MM.YYYY').subtract(1,'days').format('DD.MM.YYYY');
            this.productionFondHistoryPeriodStart =  moment(this.productionFondPeriodStart,'DD.MM.YYYY').subtract(this.fondDaysCountSelected.production, 'days').startOf('day').format('DD.MM.YYYY');
        },

        isProductionFondFewMonthsSelected() {
            let startDate =  moment(this.productionFondPeriodStart,'DD.MM.YYYY');
            let endDate = moment(this.productionFondPeriodEnd,'DD.MM.YYYY');
            this.fondDaysCountSelected.production = endDate.diff(startDate, 'days');
            if (this.fondDaysCountSelected.production === 0) {
                this.fondDaysCountSelected.production = 1;
            }
            return endDate.diff(startDate, 'days') > 0;
        },

        switchProductionFondPeriodRange() {
            this.switchProductionFondPeriod('productionFondPeriod');
        },

        async updateProductionFondWidget() {
            let productionFondDetails = _.cloneDeep(this.productionFondDetails);
            let productionFondDetailsHistory = _.cloneDeep(this.productionFondHistory);
            if (this.productionFondSelectedCompany !== 'all') {
                productionFondDetails = this.getFoundsFilteredByDzo(productionFondDetails,this.productionFondSelectedCompany);
                productionFondDetailsHistory = this.getFoundsFilteredByDzo(productionFondDetailsHistory,this.productionFondSelectedCompany);
            }
            let compared = this.getMergedByChild(productionFondDetails,'import_downtime_reason');
            this.updateProductionFondWidgetTable(compared);
            this.productionFondChartData = this.getProductionFondWidgetChartData(compared);
            this.updateProductionFondSum('actual',productionFondDetails);
            this.updateProductionFondSum('history',productionFondDetailsHistory);
        },

        updateProductionFondSum(type,inputData) {
            let summary = this.getProductionWidgetSum(inputData);
            this.productionFondSum[type].work = summary.in_work_production_fond / this.fondDaysCountSelected.production;
            this.productionFondSum[type].idle = summary.in_idle_production_fond / this.fondDaysCountSelected.production;
        },

        getProductionFondWidgetChartData(compared) {
            let groupedForChart =  _.groupBy(compared, item => {
                return moment(item.date).startOf('day').format("MM.DD.YYYY");
            });
            let chartData = {};
            if (groupedForChart) {
                for (let i in groupedForChart) {
                    chartData[i] = this.getSumByFond(groupedForChart[i],'production','other_downtime_production_wells_count','isProductionIdleActive');
                }
            }
            return chartData;
        },

        updateProductionFondWidgetTable(input) {
            let tableData = _(input)
                .groupBy("data")
                .map((item) => (this.getSumByFond(item,'production','other_downtime_production_wells_count','isProductionIdleActive'))).value();
            this.updateFoundsTable(tableData,this.productionFondData);
        },

        changeSelectedProductionFondCompanies(e) {
            this.productionFondSelectedCompany = e.target.value;
            this.updateProductionFondWidget();
        },

        getProductionFondFilteredByDzo(inputData,dzoName) {
            return _.filter(inputData, function (item) {
                return (item.dzo_name === dzoName);
            })
        },

        getProductionWidgetSum(input) {
            let factOptions = {
                'in_work_production_fond': 0,
                'in_idle_production_fond': 0
            };
            let tableData = _(input)
                .groupBy("data")
                .map((item) => ({
                    in_work_production_fond: _.round(_.sumBy(item, 'in_work_production_fond'), 0),
                    in_idle_production_fond: _.round(_.sumBy(item, 'in_idle_production_fond'), 0),
                })).value();
            if (tableData.length > 0) {
                factOptions = tableData[0];
            }
            return factOptions;
        },

        switchProductionFondFilter(filterName) {
            this.fondsFilter[filterName] = !this.fondsFilter[filterName];
            if (this.fondsFilter[filterName]) {
                this.productionFondSelectedRow = 'prs_wait_downtime_production_wells_count';
            } else {
                this.productionFondSelectedRow = 'operating_production_fond';
            }
            this.updateProductionFondWidget();
        },
    },
    computed: {
        productionFondDataForChart() {
            let series = []
            let labels = []
            for (let i in this.productionFondChartData) {
                series.push(this.productionFondChartData[i][this.productionFondSelectedRow])
                labels.push(i)
            }
            return {
                series: series,
                labels: labels
            }
        },
    },
}