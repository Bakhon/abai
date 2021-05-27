import moment from "moment";

export default {
    data: function () {
        return {
            displayTable: "display:  none;",
            displayHeadTables: "display: block;",
            Table1: "display:block;",
            Table2: "display:none;",
            Table3: "display:none;",
            Table4: "display:none;",
            Table5: "display:none;",
            Table6: "display:none;",
            Table7: "display:none;",
            tableHover1: "",
            tableHover2: "",
            tableHover3: "",
            tableHover4: "",
            tableHover5: "",
            tableHover6: "",
            tableHover7: "",
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
        };
    },
    methods: {
        changeTable(change) {
            this.selectedSecondaryOption = '';
            this.isFilterTargetPlanActive = false;
            this.buttonTargetPlan = "";
            this.company = "all";
            this.Table1 = "display:none";
            this.Table2 = "display:none";
            this.Table3 = "display:none";
            this.Table4 = "display:none";
            this.Table5 = "display:none";
            this.Table6 = "display:none";
            this.Table7 = "display:none";

            this.tableHover1 = "";
            this.tableHover2 = "";
            this.tableHover3 = "";
            this.tableHover4 = "";
            this.tableHover5 = "";
            this.tableHover6 = "";
            this.tableHover7 = "";
            var buttonHover2 = " background: #0d2792";

            if (change == "1") {
                this.Table1 = "display:block";
                this.tableHover1 = buttonHover2;
                this.changeMenu2('daily');
            } else if (change == "2") {
                this.Table2 = "display:block";
                this.tableHover2 = buttonHover2;
            } else if (change == "3") {
                this.Table3 = "display:block";
                this.tableHover3 = buttonHover2;
            } else if (change == "4") {
                this.Table4 = "display:block";
                this.tableHover4 = buttonHover2;
            } else if (change == "5") {
                this.Table5 = "display:block";
                this.tableHover5 = buttonHover2;
            } else if (change == "6") {
                this.Table6 = "display:block";
                this.tableHover6 = buttonHover2;
            } else if (change == "7") {
                this.Table7 = "display:block";
                this.tableHover7 = buttonHover2;

                let periodStart = moment().startOf('month').format();
                let periodEnd = moment().subtract(1, "days").endOf('day').format();
                if (periodStart > periodEnd) {
                    periodStart = this.getPreviousWorkday();
                }

                this.range = {
                    start: periodStart,
                    end: periodEnd,
                    formatInput: true,
                };
                this.changeDate();
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
                let minimalDaysPeriodForChart = 2;
                this.buttonMonthlyTab = this.highlightedButton;
                this.currentDzoList = 'monthly';
                let periodStart = moment().startOf('month').format();
                let periodEnd = moment().subtract(1, "days").endOf('day').format();
                let daysDifference = moment(periodEnd).diff(moment(periodStart), 'days');
                if (periodStart > periodEnd || daysDifference < minimalDaysPeriodForChart) {
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