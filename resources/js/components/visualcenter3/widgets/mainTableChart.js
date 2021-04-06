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
                monthlyPlan: null,
                productionPlanForChart: 0,
                productionFactForChart: null,
                productionPlanForChart2: null,
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
            this.dzoYearlyData.plan =  _.sumBy(dzoGroupedMonthlyPlans, 'monthlyPlan');
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
                monthlyPlansInYear.push(this.getInitialSummaryForMonth(currentPeriodDate,summaryForChart,dzoGroupedMonthlyPlans,dzoName));
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
                    monthlyPlan: _.round(_.sumBy(items, 'plan_oil') * self.getDaysCountInMonth(moment(date).format("YYYY-MM")), 0),
                }))
                .value();
        },

        getInitialSummaryForMonth(date,summaryForChart,dzoGroupedMonthlyPlans,dzoName) {
            let monthlyPlan = dzoGroupedMonthlyPlans[date.month()]['monthlyPlan'];
            let monthlyFact = this.getMonthlyFact(date,summaryForChart,'productionFactForChart');
            let monthlyOpecPlan = this.getMonthlyFact(date,summaryForChart,'productionPlanForChart2');
            let initialSummary = _.cloneDeep(this.initialYearlySummary);
            initialSummary.time = date.valueOf();
            initialSummary.productionPlanForChart = monthlyPlan;
            if (monthlyFact > 0 && date.month() < moment().month()) {
                initialSummary.productionFactForChart = monthlyFact;
            } else if (date.month() === moment().month() && dzoName) {
                let initialMonthlyPlan = monthlyPlan / this.getDaysCountInMonth(date.format("YYYY-MM"));
                let currentDatePlan = initialMonthlyPlan *= date.date();
                initialSummary.productionFactForChart = currentDatePlan;
            }
            if (monthlyOpecPlan > 0 && date.month() < moment().month()) {
                initialSummary.productionPlanForChart2 = monthlyOpecPlan;
            }
            initialSummary.monthlyPlan = this.getDzoMonthlyPlan(date,monthlyFact);
            return initialSummary;
        },

        getMonthlyFact(date,summaryForChart,fieldName) {
            let monthlyFactSummary = summaryForChart.filter(function(item) {
                return new Date(parseInt(item.time)).getMonth() === date.month();
            }).map(function(item) {
                return item;
            });
            return _.sumBy(monthlyFactSummary, fieldName);
        },

        getDzoMonthlyPlan(date,monthlyFact) {
            if (monthlyFact > 0) {
                let monthsLeftInYear = 12 - date.month();
                this.dzoYearlyData.differenceOnEachMonth = Math.round((this.dzoYearlyData.plan - this.dzoYearlyData.totallyFact) / monthsLeftInYear);
                this.setTotalFact(monthlyFact);
            }
            return this.dzoYearlyData.differenceOnEachMonth;
        },

        setTotalFact(monthlyFact) {
            this.dzoYearlyData.totallyFact += monthlyFact;
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
                    targetPlan += monthData.monthlyPlan;
                }
            });
            return targetPlan;
        },
    }
}