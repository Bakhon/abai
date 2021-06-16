import moment from "moment";

export default {
    data: function () {
        return {
            wellsWorkoverDetails: [],
            wellsWorkoverSelectedCompany: 'all',
            wellsWorkoverPeriodStartMonth: moment().format('MMMM YYYY'),
            wellsWorkoverPeriodEndMonth: moment().format('MMMM YYYY'),
            wellsWorkoverMonthlyPeriod: 'button-tab-highlighted',
            wellsWorkoverYearlyPeriod: '',
            wellsWorkoverPeriod: '',
            isWellsWorkoverPeriodSelected: false,
            wellsWorkoverRange: {
                'start': new Date(),
                'end': new Date(),
            },
            wellsWorkoverData: [
                {
                    name: this.trans("visualcenter.otmPrsSkv"),
                    code: 'underground_workover',
                    plan: 0,
                    fact: 0,
                    metricSystem: this.trans("visualcenter.otmMetricSystemWells"),
                },
                {
                    name: this.trans("visualcenter.otmKrsSkv"),
                    code: 'workover',
                    plan: 0,
                    fact: 0,
                    metricSystem: this.trans("visualcenter.otmMetricSystemMeter"),
                },
            ],
            wellsWorkoverPeriodMapping: {
                wellsWorkoverMonthlyPeriod: {
                    'periodStart': moment().format('MMMM YYYY'),
                    'periodEnd': moment().format('MMMM YYYY'),
                },
                wellsWorkoverYearlyPeriod: {
                    'periodStart': moment().startOf('year').format('MMMM YYYY'),
                    'periodEnd': moment().format('MMMM YYYY'),
                },
                wellsWorkoverPeriod: {
                    'periodStart': moment().format('MMMM YYYY'),
                    'periodEnd': moment().format('MMMM YYYY'),
                },
            },
            wellsWorkoverSelectedRow: 'underground_workover',
            wellsWorkoverChartData: [],

        };
    },
    methods: {
        async getWellsWorkoverByMonth() {
            let queryOptions = {
                'startPeriod': moment(this.wellsWorkoverPeriodStartMonth,'MMMM YYYY').month(),
                'endPeriod': moment(this.wellsWorkoverPeriodEndMonth,'MMMM YYYY').month()
            };
            let uri = this.localeUrl("/get-otm-details");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status === 200) {
                return response.data;
            }
            return {};
        },

        async switchWellsWorkoverPeriod(buttonType) {
            this.wellsWorkoverMonthlyPeriod = "";
            this.wellsWorkoverYearlyPeriod = "";
            this.wellsWorkoverPeriod = "";
            this[buttonType] = this.highlightedButton;
            this.wellsWorkoverPeriodStartMonth = this.wellsWorkoverPeriodMapping[buttonType].periodStart;
            this.wellsWorkoverPeriodEndMonth = this.wellsWorkoverPeriodMapping[buttonType].periodEnd;
            this.isWellsWorkoverPeriodSelected = this.isWellsWorkoverFewMonthsSelected();
            this.wellsWorkoverDetails = await this.getWellsWorkoverByMonth();
            this.updateWellsWorkoverWidget();
        },

        iswellsWorkoverFewMonthsSelected() {
            let startDate =  moment(this.wellsWorkoverPeriodStartMonth, 'MMMM YYYY');
            let endDate = moment(this.wellsWorkoverPeriodEndMonth, 'MMMM YYYY');
            return endDate.diff(startDate, 'months') > 0;
        },

        updateWellsWorkoverWidget() {
            let temporaryWellsWorkoverDetails = _.cloneDeep(this.wellsWorkoverDetails);
            if (this.wellsWorkoverSelectedCompany !== 'all') {
                temporaryWellsWorkoverDetails = this.getChemistryFilteredByDzo(temporaryWellsWorkoverDetails,this.wellsWorkoverSelectedCompany);
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
            this.wellsWorkoverChartData = this.getWellsWorkoverWidgetChartData(temporaryWellsWorkoverDetails);
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

            this.otmWidgetData.krsWells = this.getWellsWorkoverFactSum(tableData,'workover');
            this.otmWidgetData.prsWells = this.getWellsWorkoverFactSum(tableData,'underground_workover');
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
            console.log('-this.wellsWorkoverData')
            console.log(this.wellsWorkoverData)
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
                        underground_workover: _.round(_.sumBy(groupedForChart[i], 'otm_underground_workover'), 0),
                    }
                }
            }
            return chartData;
        },
    },
    computed: {
        wellsWorkoverDataForChart() {
            let series = []
            let labels = []
            for (let i in this.wellsWorkoverChartData) {
                series.push(this.wellsWorkoverSelectedRow ? this.wellsWorkoverChartData[i][this.wellsWorkoverSelectedRow] : this.wellsWorkoverChartData[i]['underground_workover']);
                labels.push(i);
            }
            return {
                series: series,
                labels: labels
            }
        },
    },
}