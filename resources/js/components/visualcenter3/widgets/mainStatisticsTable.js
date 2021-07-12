import moment from "moment";

export default {
    data: function () {
        return {
            buttonDailyTab: "button-tab-highlighted",
            buttonMonthlyTab: "",
            buttonYearlyTab: "",
            buttonPeriodTab: "",
            scroll: '',
            tables: "",
            buttonNormalTab: "",
            highlightedButton: "button-tab-highlighted",
            display: "none",
            assetTitleMapping: {
                isOperating: this.trans("visualcenter.summaryOperatingAssets"),
                isNonOperating: this.trans("visualcenter.summaryNonOperatingAssets"),
                isAllAssets: this.trans("visualcenter.summaryAssets"),
                opecRestriction: this.trans("visualcenter.opek"),
                kmgParticipation: this.trans("visualcenter.dolyaUchast"),
                isRegion: this.trans("visualcenter.summaryByRegion"),
            },
            oilProductionButton: "",
            oilDeliveryButton: "",
            gasProductionButton: "",
            condensateProductionButton: "",
            minimalDaysCountInPeriodForChart: 1,
            oilCondensateProductionButton: "button-tab-highlighted",
            oilCondensateDeliveryButton: '',
            tableMapping: {
                'productionDetails': {
                    'class': '',
                    'hover': '',
                },
                'oilRate': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
                'usdRate': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
                'productionWells': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
                'injectionWells': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
                'otmDrilling': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
                'chemistry': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
                'otmWorkover': {
                    'class': 'hide-company-list',
                    'hover': '',
                },
            }
        };
    },
    methods: {
        changeTable(tableName) {
            _.forEach(this.tableMapping, function (item) {
                _.set(item, 'class', 'hide-company-list');
                _.set(item, 'hover', '');
            });

            this.isFilterTargetPlanActive = false;
            this.buttonTargetPlan = "";
            this.changeMenu2('daily');
            this.tableMapping[tableName]['class'] = 'show-company-list';
            this.tableMapping[tableName]['hover'] = 'button_hover';
        },

        changeMenu2(change) {
            this.buttonDailyTab = "";
            this.buttonMonthlyTab = "";
            this.buttonYearlyTab = "";
            this.buttonPeriodTab = "";
            if (!this.isFirstLoading) {
                this.lastSelectedCategory = this.selectedButtonName;
            }
            if (change !== 'yearly') {
                this.isFilterTargetPlanActive = false;
            }

            if (change === 'daily') {
                this.currentDzoList = 'daily';
                this.buttonDailyTab = this.highlightedButton;
                this.range = {
                    start: moment().startOf('day').subtract(1, "days").format(),
                    end: moment().endOf('day').subtract(1, "days").format(),
                    formatInput: true,
                };
                this.changeDate();
                this.calculateDzoCompaniesSummary();
            }

            if (change === 'monthly') {
                this.buttonMonthlyTab = this.highlightedButton;
                this.currentDzoList = 'monthly';
                let periodStart = moment().startOf('month').format();
                let periodEnd = moment().subtract(1, "days").endOf('day').format();
                let daysDifference = moment(periodEnd).diff(moment(periodStart), 'days');
                if (periodStart > periodEnd || daysDifference < this.minimalDaysCountInPeriodForChart) {
                    periodEnd = moment(periodStart).endOf('day').format();
                    periodStart = this.getPreviousWorkday();
                }

                this.range = {
                    start: periodStart,
                    end: periodEnd,
                    formatInput: true,
                };
                this.changeDate();
            }

            if (change === 'yearly') {
                this.buttonYearlyTab = this.highlightedButton;
                this.currentDzoList = 'yearly';
                this.range = {
                    start: moment().startOf('year').format(),
                    end: moment().endOf('day').format(),
                    formatInput: true,
                };
                this.changeDate();
            }

            if (change === 'period') {
                this.buttonPeriodTab = this.highlightedButton;
                this.currentDzoList = 'daily';
            }
        },
    }
}