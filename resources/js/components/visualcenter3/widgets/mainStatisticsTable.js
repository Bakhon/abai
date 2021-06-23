import moment from "moment";

export default {
    data: function () {
        return {
            displayTable: "display:  none;",
            displayHeadTables: "display: block;",
            buttonDailyTab: "button-tab-highlighted",
            buttonMonthlyTab: "",
            buttonYearlyTab: "",
            buttonPeriodTab: "",
            scroll: '',
            tables: "",
            showTable2: "Yes",
            showTableOn: "",
            buttonNormalTab: "",
            highlightedButton: "button-tab-highlighted",
            ChartTable: "График",
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
            displayChart: "display: none;",
            minimalDaysCountInPeriodForChart: 1,
            oilCondensateProductionButton: "button-tab-highlighted",
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

            this.selectedSecondaryOption = '';
            this.selectedDzo = 'all';
            this.isFilterTargetPlanActive = false;
            this.buttonTargetPlan = "";
            this.company = "all";
            this.changeMenu2('daily');
            this.tableMapping[tableName]['class'] = 'show-company-list';
            this.tableMapping[tableName]['hover'] = 'button_hover';

            if (tableName == "otmDrilling") {
                this.otmSelectedRow = 'otm_iz_burenia_skv_fact';
            } else if (tableName == "otmWorkover") {
                this.otmSelectedRow = 'otm_krs_skv_fact';
            } else if (["chemistry","otmWorkover"].includes(tableName)) {
                this.changeMenu2('monthly');
            }
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.chartSecondaryName);
        },

        changeMenu2(change) {
            this.buttonDailyTab = "";
            this.buttonMonthlyTab = "";
            this.buttonYearlyTab = "";
            this.buttonPeriodTab = "";
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

        changeButton(showTableItem, changeButton) {
            var a;
            if (changeButton == "Yes") {
                if (showTableItem == "Yes") {
                    a = "No";
                } else {
                    a = "Yes";
                }
                this.showTable2 = a;
                localStorage.setItem("changeButton", a);
            }
            this.showTable(localStorage.getItem("changeButton"));
        },

        showTable(showTableItem, changeButton) {
            var showTableOn =
                " border: none;" +
                "color: white;" +
                "background: url(../img/level1/button-on.png) no-repeat;" +
                "background-size: 16% auto;" +
                "background-position: 80% 50%;" +
                "outline: none;";

            if (showTableItem == "Yes") {
                this.ChartTable = "График";
                this.displayChart = "display:none;";

                if (this.company == "all") {
                    this.displayTable = "display:none;";
                } else {
                    this.displayTable = "d-flex;";
                    this.displayHeadTables = "display: none";
                }
                this.showTableOn = "";
            } else if (showTableItem == "No") {
                this.displayTable = "display:none;";
                this.displayChart = "display:block;";
                this.ChartTable = "Таблица";
                this.showTableOn = showTableOn;
            }
        },
    }
}