import moment from "moment";

export default {
    data: function () {
        return {
            injectionFondDetails: [],
            injectionFondPeriodStart: moment().subtract(1, 'days').startOf('day').format('DD.MM.YYYY'),
            injectionFondPeriodEnd: moment().subtract(1, 'days').endOf('day').format('DD.MM.YYYY'),
            injectionFondDaysCount: 1,
            injectionFondHistoryPeriodStart: moment().subtract(2, 'days').startOf('day').format('DD.MM.YYYY'),
            injectionFondHistoryPeriodEnd: moment().subtract(2, 'days').endOf('day').format('DD.MM.YYYY'),
            injectionFondButtons: {
                dailyPeriod: 'button-tab-highlighted',
                monthlyPeriod: '',
                yearlyPeriod: '',
                period: '',
            },
            isInjectionFondPeriodSelected: false,
            injectionFondPeriodMapping: {
                dailyPeriod: {
                    'start': moment().subtract(1, 'days').startOf('day').format('DD.MM.YYYY'),
                    'end': moment().subtract(1, 'days').endOf('day').format('DD.MM.YYYY'),
                },
                monthlyPeriod: {
                    'start': moment().startOf('month').format('DD.MM.YYYY'),
                    'end': moment().format('DD.MM.YYYY'),
                },
                yearlyPeriod: {
                    'start': moment().startOf('year').format('DD.MM.YYYY'),
                    'end': moment().format('DD.MM.YYYY'),
                },
                period: {
                    'start': moment().format('DD.MM.YYYY'),
                    'end': moment().format('DD.MM.YYYY')
                },
            },
            injectionFondSelectedCompany: 'all',
            injectionFondSelectedRow: 'operating_injection_fond',
            injectionFondData: [
                {
                    name: this.trans("visualcenter.exploitationFond"),
                    code: 'operating_injection_fond',
                    fact: 0,
                    isVisible: true
                },
                {
                    name: this.trans("visualcenter.operatingFond"),
                    code: 'active_injection_fond',
                    fact: 0,
                    isVisible: true
                },
                {
                    name: this.trans("visualcenter.nonOperatingFond"),
                    code: 'inactive_injection_fond',
                    fact: 0,
                    isVisible: true
                },
                {
                    name: this.trans("visualcenter.masteringFond"),
                    code: 'developing_injection_fond',
                    fact: 0,
                    isVisible: true
                },
                {
                    name: this.trans("visualcenter.liquidationFond"),
                    code: 'pending_liquidation_injection_fond',
                    fact: 0,
                    isVisible: true
                },
                {
                    name: this.trans("visualcenter.waitingUndergroundRepairFond"),
                    code: 'prs_wait_downtime_injection_wells_count',
                    fact: 0,
                    isVisible: false
                },
                {
                    name: this.trans("visualcenter.undergroundRepairFond"),
                    code: 'prs_downtime_injection_wells_count',
                    fact: 0,
                    isVisible: false
                },
                {
                    name: this.trans("visualcenter.waitingOverhaulFond"),
                    code: 'krs_wait_downtime_injection_wells_count',
                    fact: 0,
                    isVisible: false
                },
                {
                    name: this.trans("visualcenter.overhaulFond"),
                    code: 'krs_downtime_injection_wells_count',
                    fact: 0,
                    isVisible: false
                },
                {
                    name: this.trans("visualcenter.researchFond"),
                    code: 'well_survey_downtime_injection_wells_count',
                    fact: 0,
                    isVisible: false
                },
                {
                    name: this.trans("visualcenter.othersFond"),
                    code: 'other_downtime_injection_wells_count',
                    fact: 0,
                    isVisible: false
                },
            ],
            injectionFondChartData: [],
            injectionFondSum: {
                'actual': {
                    'work': 0,
                    'idle': 0
                },
                'history': {
                    'work': 0,
                    'idle': 0
                }
            },
            injectionFondHistory: [],
            forDailyInjectionChart: [],
            injectionDailyChart: {
                series: [],
                labels: []
            },
            injectionFondWorkFields: [
                'operating_injection_fond',
                'active_injection_fond',
                'inactive_injection_fond',
                'developing_injection_fond',
                'pending_liquidation_injection_fond'
            ],
            injectionFondIdleFields: [
                'prs_wait_downtime_injection_wells_count',
                'prs_downtime_injection_wells_count',
                'krs_wait_downtime_injection_wells_count',
                'krs_downtime_injection_wells_count',
                'well_survey_downtime_injection_wells_count',
                'other_downtime_injection_wells_count'
            ]
        };
    },
    methods: {
        async getInjectionFondByMonth(periodStart,periodEnd) {
            let queryOptions = {
                'startPeriod': periodStart,
                'endPeriod': periodEnd
            };

            let uri = this.localeUrl("/get-injection-fond-details");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status === 200) {
                return response.data;
            }
            return {};
        },

        async switchInjectionFondPeriod(buttonType) {
            this.SET_LOADING(true);
            this.injectionFondButtons = _.mapValues(this.injectionFondButtons, () => '');
            this.injectionFondButtons[buttonType] = this.highlightedButton;
            this.injectionFondPeriodStart = this.injectionFondPeriodMapping[buttonType].start;
            this.injectionFondPeriodEnd = this.injectionFondPeriodMapping[buttonType].end;
            this.isInjectionFondPeriodSelected = this.isInjectionFondFewMonthsSelected();
            this.updateInjectionFondHistory();
            this.injectionFondDetails = await this.getFondByMonth(this.injectionFondPeriodStart,this.injectionFondPeriodEnd,'injection');
            this.injectionFondHistory = await this.getFondByMonth(this.injectionFondHistoryPeriodStart,this.injectionFondHistoryPeriodEnd,'injection');
            this.updateInjectionFondWidget();
            this.SET_LOADING(false);
        },

        async updateInjectionFondHistory() {
            this.injectionFondHistoryPeriodEnd = moment(this.injectionFondPeriodStart,'DD.MM.YYYY').subtract(1,'days').format('DD.MM.YYYY');
            this.injectionFondHistoryPeriodStart =  moment(this.injectionFondPeriodStart,'DD.MM.YYYY').subtract(this.fondDaysCountSelected.injection, 'days').startOf('day').format('DD.MM.YYYY');
        },

        isInjectionFondFewMonthsSelected() {
            let startDate =  moment(this.injectionFondPeriodStart,'DD.MM.YYYY');
            let endDate = moment(this.injectionFondPeriodEnd,'DD.MM.YYYY');
            this.fondDaysCountSelected.injection = endDate.diff(startDate, 'days');

            if (this.fondDaysCountSelected.injection === 0) {
                this.fondDaysCountSelected.injection = 1;
            }
            return endDate.diff(startDate, 'days') > 0;
        },

        switchInjectionFondPeriodRange() {
            this.switchInjectionFondPeriod('period');
        },

        async updateInjectionFondWidget() {
            this.SET_LOADING(true);
            let injectionFondDetails = _.cloneDeep(this.injectionFondDetails);
            let injectionFondDetailsHistory = _.cloneDeep(this.injectionFondHistory);
            if (this.injectionFondSelectedCompany !== 'all') {
                injectionFondDetails = this.getFoundsFilteredByDzo(injectionFondDetails,this.injectionFondSelectedCompany);
                injectionFondDetailsHistory = this.getFoundsFilteredByDzo(injectionFondDetailsHistory,this.injectionFondSelectedCompany);
            }
            let compared = this.getMergedByChild(injectionFondDetails,'import_downtime_reason');
            if (!this.isInjectionFondPeriodSelected) {
                this.forDailyInjectionChart = await this.getChartData(this.injectionFondWorkFields,this.injectionFondIdleFields,this.injectionFondPeriodStart,this.injectionFondPeriodEnd,'injection',this.injectionFondSelectedCompany);
                this.updateDailyChart(this.forDailyInjectionChart,this.injectionFondSelectedCompany,'isInjectionIdleActive','injectionDailyChart');
            } else {
                this.injectionFondChartData = this.getInjectionFondWidgetChartData(compared);
            }
            this.updateInjectionFondWidgetTable(compared);
            this.updateInjectionFondSum('actual',injectionFondDetails);
            this.updateInjectionFondSum('history',injectionFondDetailsHistory);
            this.SET_LOADING(false);
        },

        updateInjectionFondSum(type,inputData) {
            let summary = this.getInjectionWidgetSum(inputData);
            this.injectionFondSum[type].work = summary.in_work_injection_fond / this.fondDaysCountSelected.injection;
            this.injectionFondSum[type].idle = summary.in_idle_injection_fond / this.fondDaysCountSelected.injection;
        },

        getInjectionFondWidgetChartData(compared) {
            let sorted = _.sortBy(compared,'date','asc');
            let groupedForChart =  _.groupBy(sorted, item => {
                return moment(item.date).startOf('day').format("MM.DD.YYYY");
            });
            let chartData = {};
            if (groupedForChart) {
                for (let i in groupedForChart) {
                    chartData[i] = this.getSumOfFond(groupedForChart[i],this.injectionFondWorkFields,this.injectionFondIdleFields,'isInjectionIdleActive');
                }
            }
            return chartData;
        },

        updateInjectionFondWidgetTable(input) {
            let tableData = _(input)
                .groupBy("data")
                .map((item) => (this.getSumByFond(item,'injection','other_downtime_injection_wells_count','isInjectionIdleActive'))).value();
            this.updateFoundsTable(tableData,this.injectionFondData);
        },

        changeSelectedInjectionFondCompanies(e) {
            this.injectionFondSelectedCompany = e.target.value;
            this.updateInjectionFondWidget();
        },

        getInjectionWidgetSum(input) {
            let factOptions = {
                'in_work_injection_fond': 0,
                'in_idle_injection_fond': 0
            };
            let tableData = _(input)
                .groupBy("data")
                .map((item) => ({
                    in_work_injection_fond: _.round(_.sumBy(item, 'in_work_injection_fond'), 0),
                    in_idle_injection_fond: _.round(_.sumBy(item, 'in_idle_injection_fond'), 0),
                })).value();
            if (tableData.length > 0) {
                factOptions = tableData[0];
            }
            return factOptions;
        },

        switchInjectionFondFilter(filterName) {
            this.fondsFilter[filterName] = !this.fondsFilter[filterName];
            if (this.fondsFilter[filterName]) {
                this.injectionFondSelectedRow = 'prs_wait_downtime_injection_wells_count';
            } else {
                this.injectionFondSelectedRow = 'operating_injection_fond';
            }
            this.updateInjectionFondWidget();
        },
    },
    computed: {
        injectionFondDataForChart() {
            let series = {
                fact: []
            }
            let labels = []
            for (let i in this.injectionFondChartData) {
                series.fact.push(Math.round(this.injectionFondChartData[i][this.injectionFondSelectedRow]));
                labels.push(i);
            }
            return {
                series: series,
                labels: labels
            }
        },
    },
}