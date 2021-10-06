import moment from "moment";

export default {
    data: function () {
        return {
            wellsWorkoverDetails: [],
            wellsWorkoverSelectedCompany: 'all',
            wellsWorkoverPeriodStartMonth: moment().subtract(1, 'months').format('MMMM YYYY'),
            wellsWorkoverPeriodEndMonth: moment().subtract(1, 'months').format('MMMM YYYY'),
            wellsWorkoverMonthlyPeriod: 'button-tab-highlighted',
            wellsWorkoverYearlyPeriod: '',
            wellsWorkoverPeriod: '',
            isWellsWorkoverPeriodSelected: false,
            wellsWorkoverData: [
                {
                    name: this.trans("visualcenter.otmPrsSkv"),
                    code: 'underground_workover',
                    plan: 0,
                    fact: 0,
                    metricSystem: this.trans("visualcenter.skv"),
                },
                {
                    name: this.trans("visualcenter.otmKrsSkv"),
                    code: 'workover',
                    plan: 0,
                    fact: 0,
                    metricSystem: this.trans("visualcenter.skv"),
                },
            ],
            wellsWorkoverPeriodMapping: {
                wellsWorkoverMonthlyPeriod: [
                    moment().subtract(1, 'months').format("MMMM yyyy"),
                    moment().subtract(1, 'months').format("MMMM yyyy"),
                ],
                wellsWorkoverYearlyPeriod: [
                    moment().startOf('year').format('MMMM YYYY'),
                    moment().format('MMMM yyyy'),
                ],
                wellsWorkoverPeriod: [
                    moment().subtract(1, 'months').format("MMMM yyyy"),
                    moment().subtract(1, 'months').format("MMMM yyyy"),
                ],
            },
            wellsWorkoverSelectedRow: 'underground_workover',
            wellsWorkoverChartData: [],
            wellsWorkoverSummary: {
                'krs': 0,
                'prs': 0
            },
            wellsWorkoverDailyChart: {
                series: [],
                labels: [
                    this.trans("visualcenter.Plan"),
                    this.trans("visualcenter.Fact"),
                    this.trans("visualcenter.Plan"),
                    this.trans("visualcenter.Fact")
                ]
            },
            wellsWorkoverDzo: ['КБМ','КОА','ММГ','КГМ','ОМГ','ЭМГ','КТМ'],
            wellsWorkoverTemplate: {
                'date': moment().subtract(1,'months').format('YYYY-MM-DD'),
                'dzo_name': '',
                'otm_underground_workover': 0,
                'otm_well_workover_fact': 0
            }
        };
    },
    methods: {
        async getWellsWorkoverByMonth() {
            let queryOptions = {
                'startPeriod': moment(this.wellsWorkoverPeriodStartMonth,'MMMM YYYY').month() + 1,
                'endPeriod': moment(this.wellsWorkoverPeriodEndMonth,'MMMM YYYY').month() + 1
            };
            let uri = this.localeUrl("/get-otm-details");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status !== 200) {
                return [];
            }
            let wellsWorkoverData = response.data;

            if (wellsWorkoverData && wellsWorkoverData.length !== this.wellsWorkoverDzo.length) {
                let presentCompanies = wellsWorkoverData.map(a => a.dzo_name);
                let difference = this.wellsWorkoverDzo.filter(dzoName => !presentCompanies.includes(dzoName));
                for (let dzo of difference) {
                    let template = this.wellsWorkoverTemplate;
                    template['dzo_name'] = dzo;
                    wellsWorkoverData.push(template);
                }
            }
            return wellsWorkoverData;
        },

        async switchWellsWorkoverPeriod(buttonType) {
            this.SET_LOADING(true);
            this.wellsWorkoverMonthlyPeriod = "";
            this.wellsWorkoverYearlyPeriod = "";
            this.wellsWorkoverPeriod = "";
            this[buttonType] = this.highlightedButton;
            this.wellsWorkoverPeriodStartMonth = this.wellsWorkoverPeriodMapping[buttonType][0];
            this.wellsWorkoverPeriodEndMonth = this.wellsWorkoverPeriodMapping[buttonType][1];
            this.isWellsWorkoverPeriodSelected = this.isWellsWorkoverFewMonthsSelected();
            this.wellsWorkoverDetails = await this.getWellsWorkoverByMonth();
            await this.updateWellsWorkoverWidget();
            this.SET_LOADING(false);
        },

        isWellsWorkoverFewMonthsSelected() {
            let startDate =  moment(this.wellsWorkoverPeriodStartMonth, 'MMMM YYYY');
            let endDate = moment(this.wellsWorkoverPeriodEndMonth, 'MMMM YYYY');
            return endDate.diff(startDate, 'months') > 0;
        },

        switchWellsWorkoverPeriodRange() {
            this.switchWellsWorkoverPeriod('wellsWorkoverPeriod');
        },

        updateWellsWorkoverWidget() {
            let temporaryWellsWorkoverDetails = _.cloneDeep(this.wellsWorkoverDetails);
            if (this.wellsWorkoverSelectedCompany !== 'all') {
                temporaryWellsWorkoverDetails = this.getWellsWorkoverFilteredByDzo(temporaryWellsWorkoverDetails,this.wellsWorkoverSelectedCompany);
            }
            let self = this;
            _.forEach(temporaryWellsWorkoverDetails, function(item) {
                let dateOption = [moment(item.date).month(),moment(item.date).year()];
                let planIndex = self.dzoMonthlyPlans.findIndex(element => self.isRecordsSimple(dateOption,element,item.dzo_name));
                if (planIndex !== -1) {
                    item['workover_plan'] = self.dzoMonthlyPlans[planIndex].plan_otm_krs_skv_plan;
                    item['undeground_workover_plan'] = self.dzoMonthlyPlans[planIndex].plan_otm_prs_skv_plan;
                }
            });

            this.updateWellsWorkoverWidgetTable(temporaryWellsWorkoverDetails);
            if (this.wellsWorkoverMonthlyPeriod.length > 0) {
                this.wellsWorkoverDailyChart.series = [];
                for (let wellsWorkover of this.wellsWorkoverData) {
                    this.wellsWorkoverDailyChart.series.push(wellsWorkover.plan,wellsWorkover.fact);
                }
            } else {
                this.wellsWorkoverChartData = this.getWellsWorkoverWidgetChartData(temporaryWellsWorkoverDetails);
            }
        },

        updateWellsWorkoverWidgetTable(temporaryWellsWorkoverDetails) {
            let tableData = _(temporaryWellsWorkoverDetails)
                .groupBy("data")
                .map((item) => ({
                    workover: _.round(_.sumBy(item, 'otm_well_workover_fact'), 0),
                    workover_plan: _.round(_.sumBy(item, 'workover_plan'), 0),
                    underground_workover: _.round(_.sumBy(item, 'otm_underground_workover'), 0),
                    underground_workover_plan: _.round(_.sumBy(item, 'undeground_workover_plan'), 0),
                })).value();
            this.wellsWorkoverSummary.krs = this.getWellsWorkoverFactSum(tableData,'workover');
            this.wellsWorkoverSummary.prs = this.getWellsWorkoverFactSum(tableData,'underground_workover');
        },

        getWellsWorkoverFactSum(tableData,workoverType) {
            let totalFact = 0;
            if (tableData.length > 0) {
                _.forEach(this.wellsWorkoverData, function(item) {
                    item.plan = tableData[0][item.code + '_plan'];
                    item.fact = tableData[0][item.code];
                    item.difference = item.fact - item.plan;
                });
                totalFact += tableData[0][workoverType];
            }
            return totalFact;
        },

        getWellsWorkoverWidgetChartData(temporaryWellsWorkoverDetails) {
            let groupedForChart =  _.groupBy(temporaryWellsWorkoverDetails, item => {
                return moment(item.date).startOf('day').format("YYYY-MM");
            });
            let chartData = {};
            if (groupedForChart) {
                for (let i in groupedForChart) {
                    chartData[i] = {
                        workover: _.round(_.sumBy(groupedForChart[i], 'otm_well_workover_fact'), 0),
                        workover_plan: _.round(_.sumBy(groupedForChart[i], 'workover_plan'), 0),
                        underground_workover: _.round(_.sumBy(groupedForChart[i], 'otm_underground_workover'), 0),
                        underground_workover_plan: _.round(_.sumBy(groupedForChart[i], 'undeground_workover_plan'), 0),
                    }
                }
            }
            return chartData;
        },

        changeSelectedWellsWorkoverCompanies(e) {
            this.wellsWorkoverSelectedCompany = e.target.value;
            this.updateWellsWorkoverWidget();
        },

        getWellsWorkoverFilteredByDzo(inputData,dzoName) {
            return _.filter(inputData, function (item) {
                return (item.dzo_name === dzoName);
            })
        },
    },
    computed: {
        wellsWorkoverDataForChart() {
            let series = {
                plan: [],
                fact: []
            }
            let labels = []
            let planFieldName = this.wellsWorkoverSelectedRow + '_plan';
            for (let i in this.wellsWorkoverChartData) {
                series.fact.push(Math.round(this.wellsWorkoverChartData[i][this.wellsWorkoverSelectedRow]));
                series.plan.push(Math.round(this.wellsWorkoverChartData[i][planFieldName]));
                labels.push(i);
            }
            return {
                series: series,
                labels: labels
            }
        },
    },
}