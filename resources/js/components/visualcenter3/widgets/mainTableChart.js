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
            chartOutput: [],
            oilResidueChartName: this.trans('visualcenter.ostatokNefti'),
            chartNameMapping: {
                'oilCondensateProduction': {
                    'head': this.trans('visualcenter.oilCondensateProductionChartName'),
                    'name': this.trans('visualcenter.oilCondensateProduction'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.chemistryMetricTon'),
                },
                'oilCondensateProductionWithoutKMG': {
                    'head': this.trans('visualcenter.oilCondensateProductionChartName'),
                    'name': this.trans('visualcenter.oilCondensateProduction'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.chemistryMetricTon'),
                },
                'oilCondensateProductionCondensateOnly': {
                    'head': this.trans('visualcenter.dynamicCondensateProduction'),
                    'name': this.trans('visualcenter.getgk'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.chemistryMetricTon'),
                },
                'oilCondensateDelivery': {
                    'head': this.trans('visualcenter.oilCondensateDeliveryChartName'),
                    'name': this.trans('visualcenter.oilCondensateDelivery'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.chemistryMetricTon'),
                },
                'oilCondensateDeliveryWithoutKMG': {
                    'head': this.trans('visualcenter.oilCondensateDeliveryChartName'),
                    'name': this.trans('visualcenter.oilCondensateDelivery'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.chemistryMetricTon'),
                },
                'oilCondensateDeliveryOilResidue': {
                    'head': this.trans('visualcenter.stockOfGoodsDynamic'),
                    'name': this.trans('visualcenter.ostatokNefti'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.chemistryMetricTon'),
                },
                'oilCondensateDeliveryCondensateOnly': {
                    'head': this.trans('visualcenter.dynamicCondensateDelivery'),
                    'name': this.trans('visualcenter.condensateDelivery'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.chemistryMetricTon'),
                },
                'gasProduction': {
                    'head': this.trans('visualcenter.dynamicGasProduction'),
                    'name': this.trans('visualcenter.getgaz'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'naturalGasProduction': {
                    'head': this.trans('visualcenter.dynamicNaturalGasProduction'),
                    'name': this.trans('visualcenter.productionNaturalGas'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'associatedGasProduction': {
                    'head': this.trans('visualcenter.dynamicAssociatedlGasProduction'),
                    'name': this.trans('visualcenter.productionAssociatedGas'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'associatedGasFlaring': {
                    'head': this.trans('visualcenter.dynamicAssociatedlGasFlaring'),
                    'name': this.trans('visualcenter.flaringAssociatedGas'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'naturalGasDelivery': {
                    'head': this.trans('visualcenter.dynamicNaturalGasDelivery'),
                    'name': this.trans('visualcenter.prirodGazdlv'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'expensesForOwnNaturalGas': {
                    'head': this.trans('visualcenter.dynamicNaturalGasExpenses'),
                    'name': this.trans('visualcenter.naturalGasExpenses'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'associatedGasDelivery': {
                    'head': this.trans('visualcenter.dynamicAssociatedGasDelivery'),
                    'name': this.trans('visualcenter.poputGazdlv'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'expensesForOwnAssociatedGas': {
                    'head': this.trans('visualcenter.dynamicNaturalGasExpenses'),
                    'name': this.trans('visualcenter.associatedGasExpenses'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'processingAssociatedGas': {
                    'head': this.trans('visualcenter.pererabotkapoputGazDynamic'),
                    'name': this.trans('visualcenter.pererabotkapoputGaz'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'waterInjection': {
                    'head': this.trans('visualcenter.injectionWaterChartName'),
                    'name': this.trans('visualcenter.liq'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'seaWaterInjection': {
                    'head': this.trans('visualcenter.dynamicSeaInjection'),
                    'name': this.trans('visualcenter.liqOcean'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'wasteWaterInjection': {
                    'head': this.trans('visualcenter.dynamicWasteInjection'),
                    'name': this.trans('visualcenter.liqStochnaya'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'artezianWaterInjection': {
                    'head': this.trans('visualcenter.dynamicArtesianWater'),
                    'name': this.trans('visualcenter.injectionArtesianWater'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'streamWaterInjection': {
                    'head': this.trans('visualcenter.dynamicStreamInjection'),
                    'name': this.trans('visualcenter.streamInjection'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
                'volgaWaterInjection': {
                    'head': this.trans('visualcenter.dynamicVolgaWater'),
                    'name': this.trans('visualcenter.volgaWaterInjection'),
                    'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.meterCubic'),
                },
            },
            selectedChartCategory: {
                'head': this.trans('visualcenter.oilCondensateProductionChartName'),
                'name': this.trans('visualcenter.oilCondensateProduction'),
                'metric': this.trans('visualcenter.thousand') + ' ' + this.trans('visualcenter.chemistryMetricTon'),
            }
        };
    },
    methods: {
        isGrouppingFilterActive() {
          return (this.dzoCompaniesAssets.isOperating || this.dzoCompaniesAssets.isNonOperating || this.dzoCompaniesAssets.isRegion);
        },

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
            this.$refs.targetPlan.classList.remove('show');
            this.isFilterTargetPlanActive = !this.isFilterTargetPlanActive;
            if (!this.buttonTargetPlan) {
                this.buttonTargetPlan = "";
            } else {
                this.buttonTargetPlan = "button-tab-highlighted";
            }
            this.switchView('year');
            this.productionChartData = this.getSummaryForChart();
            this.exportDzoCompaniesSummaryForChart(this.productionChartData);
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
            }
            if (date.month() === moment().month() && dzoName) {
                let initialMonthlyPlan = monthlyPlan / this.getDaysCountInMonth(date.format("YYYY-MM"));
                let currentDatePlan = initialMonthlyPlan *= moment().date();
                initialSummary.monthlyPlan = (currentDatePlan - monthlyFact);
                return initialSummary;
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

        getSummaryTargetPlan(yearlyData) {
            let targetPlan = 0;
            _.forEach(yearlyData, function(monthData) {
                if (moment(monthData.time).month() <= moment().month()) {
                    targetPlan += monthData.monthlyPlan;
                }
            });
            return targetPlan;
        },

        setTotalFact(monthlyFact) {
            this.dzoYearlyData.totallyFact += monthlyFact;
        },
    }
}