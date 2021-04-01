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

        changeTargetCompanyFilter() {
            this.isFilterTargetPlanActive = !this.isFilterTargetPlanActive;
            if (!this.buttonTargetPlan) {
                this.buttonTargetPlan = "";
            } else {
                this.buttonTargetPlan = "button-tab-highlighted";
            }
            this.changeMenu2(3);
        },

        getMonthlyPlansInYear(summaryForChart) {
            let dzoGroupedMonthlyPlans = this.getGroupedMonthlyPlans();
            this.setDzoYearlyPlan(dzoGroupedMonthlyPlans);
            let currentYear = moment().year();
            var currentPeriodDate = moment().startOf('year');
            var monthlyPlansInYear = [];
            while (currentPeriodDate.year() === currentYear) {
                monthlyPlansInYear.push(this.getInitialSummaryForMonth(currentPeriodDate,summaryForChart,dzoGroupedMonthlyPlans));
                currentPeriodDate = currentPeriodDate.add(1, 'M');
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
                    dailyPlan: _.round(_.sumBy(items, 'plan_oil') * self.getDaysCountInMonth(moment(date).format("YYYY-MM")), 0),
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
            let monthsLeftInYear = 12 - date.month();
            if (date.month() !== 0) {
                this.refreshTotalFact(monthlyFactSum);
            }
            let targetPlan = Math.round((this.dzoYearlyData.plan - this.dzoYearlyData.totallyFact) / monthsLeftInYear);

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

        setTargetPlanForTable() {
            let self = this;
            _.forEach(this.dzoCompanySummary, function(dzo) {
                dzo.targetPlan = self.getDzoPlanForPeriod(dzo.dzoMonth);
            });
        },

        getDzoPlanForPeriod(dzoName) {
            let currentMonth = moment().month();
            let dailyPlan = 0;
            let self = this;
            _.forEach(this.dzoMonthlyPlans, function(dzo) {
                let planDate = moment(dzo.date);
                if (dzo.dzo !== dzoName) {
                    return;
                }
                if (planDate.month() < currentMonth) {
                    dailyPlan +=  (dzo.plan_oil * self.getDaysCountInMonth(planDate.format("YYYY-MM")));
                }
                if (planDate.month() === currentMonth) {
                    dailyPlan += dzo.plan_oil * (moment().date() - 1);
                }
            });
            return dailyPlan;
        },
    }
}