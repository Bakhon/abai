import moment from "moment";

export default {
    data: function () {
        return {
            isFilterTargetPlanActive: false,
            buttonTargetPlan: "",
            dzoMonthlyPlans: [],
            dzoGroupedMonthlyPlans: [],
            filteredDzoMonthlyPlans: [],
            initialYearlySummary: {
                time: null,
                dailyPlan: null,
                productionPlanForChart: 0,
                productionFactForChart: null,
                productionPlanForChart2: 0,
            },
            dzoYearlyData: {
                plan: 0,
                lastMonthWithFact: 0,
                totallyFact: 0,
            },
        };
    },
    methods: {
        setDzoYearlyPlan(dzoGroupedMonthlyPlans) {
            this.dzoYearlyData.plan =  _.sumBy(dzoGroupedMonthlyPlans, 'dailyPlan');
        },

        async getDzoMonthlyPlans() {
            let uri = this.localeUrl("/get-dzo-monthly-plans");
            const response = await axios.get(uri);
            if (response.status === 200) {
                return response.data;
            }
            return [];
        },

        getMonthlyPlansInYear(year,summaryForChart) {
            let dzoGroupedMonthlyPlans = this.getGroupedMonthlyPlans();
            this.setDzoYearlyPlan(dzoGroupedMonthlyPlans);
            var date = moment().startOf('year');
            var monthlyPlansInYear = [];
            while (date.year() === year) {
                monthlyPlansInYear.push(this.getInitialSummaryForMonth(date,summaryForChart,dzoGroupedMonthlyPlans));
                date = date.add(1, 'M');
            }
            return monthlyPlansInYear;
        },

        getGroupedMonthlyPlans() {
            let self = this;
            let initialPlans = _.cloneDeep(this.dzoMonthlyPlans);
            this.filteredDzoMonthlyPlans = _.cloneDeep(this.dzoMonthlyPlans).filter(row => this.selectedDzoCompanies.includes(row.dzo));
            if (this.filteredDzoMonthlyPlans.length > 0) {
                this.dzoYearlyData.totallyFact = 0;
                initialPlans = _.cloneDeep(this.filteredDzoMonthlyPlans);
            }
            return _(initialPlans)
                .groupBy("date")
                .map((items,date) => ({
                    monthNumber: new Date(Date.parse(date)).getMonth(),
                    dailyPlan: _.round(_.sumBy(items, 'plan_oil') * self.getDaysCountInMonth(moment(date).year() + '-' + (moment(date).month() + 1)), 0),
                }))
                .value();
        },

        getInitialSummaryForMonth(date,summaryForChart,dzoGroupedMonthlyPlans) {
            let monthlyPlan = dzoGroupedMonthlyPlans[date.month()]['dailyPlan'];
            let initialSummary = _.cloneDeep(this.initialYearlySummary);
            initialSummary.time = date.valueOf();
            if (date.month() !== 0) {
                initialSummary.dailyPlan = this.getDzoDailyPlan(date,summaryForChart);
            } else {
                initialSummary.dailyPlan = this.dzoYearlyData.plan / 12;
            }
            initialSummary.productionPlanForChart = monthlyPlan;
            return initialSummary;
        },

        getDzoDailyPlan(date,summaryForChart) {
            let monthlyFactSum = this.getMonthlyFact(date,summaryForChart);
            let leftMonthesInYear = 12 - date.month();
            if (date.month() !== 0) {
                this.refreshTotalFact(monthlyFactSum);
            }
            let targetPlan = Math.round((this.dzoYearlyData.plan - this.dzoYearlyData.totallyFact) / leftMonthesInYear);

            if (monthlyFactSum !== 0) {
                this.dzoYearlyData.lastTargetPlanWithFact = targetPlan;
            } else {
                targetPlan = this.dzoYearlyData.lastTargetPlanWithFact;
            }

            return targetPlan;
        },

        getMonthlyFact(date,summaryForChart) {
            let monthlyFactSummary = summaryForChart.filter(function(item) {
                return new Date(parseInt(item.time)).getMonth() === (date.month() - 1);
            }).map(function(item) {
                return item;
            });
            return _.sumBy(monthlyFactSummary, 'productionFactForChart');
        },

        refreshTotalFact(monthlyFactSum) {
            this.dzoYearlyData.totallyFact += monthlyFactSum;
        },

        getSummaryChartForYear(summaryForChart,monthlyPlansInYear) {
            let self = this;
            _.forEach(summaryForChart, function(item) {
                let date = new Date(parseInt(item.time));
                let monthNumber = date.getMonth();
                monthlyPlansInYear[monthNumber].productionFactForChart += item.productionFactForChart;
                monthlyPlansInYear[monthNumber].productionPlanForChart2 += item.productionPlanForChart2;
            });
            return monthlyPlansInYear;
        },
    }
}