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
                totallyFact: 0,
                totalDifference: 0,
                differenceOnEachMonth: 0,
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

        getMonthlyPlansInYear(summaryForChart,dzoName) {
            let dzoGroupedMonthlyPlans = this.getGroupedMonthlyPlans(dzoName);
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

        getGroupedMonthlyPlans(dzoName) {
            let self = this;
            let initialPlans = _.cloneDeep(this.dzoMonthlyPlans);
            if (dzoName) {
                this.filteredDzoMonthlyPlans = _.cloneDeep(this.dzoMonthlyPlans).filter(row => dzoName === row.dzo);
            } else {
                this.filteredDzoMonthlyPlans = _.cloneDeep(this.dzoMonthlyPlans).filter(row => this.selectedDzoCompanies.includes(row.dzo));
            }
            if (this.filteredDzoMonthlyPlans.length > 0) {
                this.dzoYearlyData.totallyFact = 0;
                this.dzoYearlyData.totalDifference = 0;
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
            let monthlyFact = this.getMonthlyFact(date,summaryForChart);

            let initialSummary = _.cloneDeep(this.initialYearlySummary);
            initialSummary.time = date.valueOf();
            initialSummary.productionPlanForChart = monthlyPlan;
            if (monthlyFact > 0 && date.month() < moment().month()) {
                initialSummary.productionFactForChart = monthlyFact;
            }
            if (date.month() !== 0) {
                initialSummary.dailyPlan = this.getDzoDailyPlan(date,monthlyPlan,monthlyFact);
            } else {
                this.setTotalDifference(monthlyPlan,monthlyFact);
                initialSummary.dailyPlan = monthlyPlan;
            }
            return initialSummary;
        },

        getMonthlyFact(date,summaryForChart) {
            let monthlyFactSummary = summaryForChart.filter(function(item) {
                return new Date(parseInt(item.time)).getMonth() === (date.month());
            }).map(function(item) {
                return item;
            });
            return _.sumBy(monthlyFactSummary, 'productionFactForChart');
        },

        getDzoDailyPlan(date,monthlyPlan,monthlyFact) {
            if (monthlyFact > 0) {
                let monthsLeftInYear = 12 - date.month();
                this.dzoYearlyData.differenceOnEachMonth = Math.round(this.dzoYearlyData.totalDifference / monthsLeftInYear);
                this.setTotalDifference(monthlyPlan,monthlyFact);
            }
            return monthlyPlan + this.dzoYearlyData.differenceOnEachMonth;
        },

        setTotalDifference(monthlyPlan,monthlyFact) {
            let difference = Math.round(monthlyPlan - monthlyFact);
            this.dzoYearlyData.totalDifference += difference;
        },

        getProductionData(data, dzoName) {
            let summary = data.filter(row => dzoName === row.dzo);
            let groupedByTime = _(summary)
                .groupBy("__time")
                .map((items, time) => ({
                    time: time,
                    productionFactForChart: _.round(_.sumBy(items, this.factFieldName), 0),
                    productionPlanForChart: _.round(_.sumBy(items, this.planFieldName), 0),
                }))
                .value();
            return this.getMonthlyPlansInYear(groupedByTime,dzoName);
        },

        getSummaryTargetPlan(yearlyData) {
            let targetPlan = 0;
            _.forEach(yearlyData, function(monthData) {
                if (moment(monthData.time).month() < moment().month()) {
                    targetPlan += monthData.dailyPlan;
                }
            });
            return targetPlan;
        },
    }
}