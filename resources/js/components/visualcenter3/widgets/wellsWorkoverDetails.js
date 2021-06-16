import moment from "moment";

export default {
    data: function () {
        return {
            wellsWorkoverSelectedCompany: 'all',
            wellsWorkoverPeriodStartMonth: moment().format('MMMM YYYY'),
            wellsWorkoverPeriodEndMonth: moment().format('MMMM YYYY'),
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
            wellsWorkoverSelectedRow: 'underground_workover',
            wellsWorkoverChartData: [],
        };
    },
    methods: {
        async getOtmByMonth() {
            let queryOptions = {
                'startPeriod': moment(this.wellsWorkoverPeriodStartMonth,'MMMM YYYY').month(),
                'endPeriod': moment(this.wellsWorkoverPeriodEndMonth,'MMMM YYYY').month()
            };
            let uri = this.localeUrl("/get-otm-details");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status === 200) {
                console.log('otm');
                console.log(response.data)
                return response.data;
            }
            return {};
        },

        updateWellsWorkoverWidget() {
            let temporaryWellsWorkoverDetails = _.cloneDeep(this.otmDetails);
            if (this.wellsWorkoverSelectedCompany !== 'all') {
                temporaryOtmDetails = this.getChemistryFilteredByDzo(temporaryWellsWorkoverDetails,this.wellsWorkoverSelectedCompany);
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
            console.log('36 temporaryWellsWorkoverDetails ')
            console.log(temporaryWellsWorkoverDetails)
            this.updateWellsWorkoverWidgetTable(temporaryWellsWorkoverDetails);
            this.wellsWorkoverChartData = this.getWellsWorkoverWidgetChartData(temporaryWellsWorkoverDetails);
            console.log('-otmChartData')
            console.log(this.wellsWorkoverChartData)
        },

        updateWellsWorkoverWidgetTable(temporaryWellsWorkoverDetails) {
            let tableData = _(temporaryWellsWorkoverDetails)
                .groupBy("data")
                .map((item) => ({
                    workover: _.sumBy(item, 'otm_well_workover_fact'),
                    workover_plan: _.sumBy(item, 'workover_plan'),
                    underground_workover: _.sumBy(item, 'otm_underground_workover'),
                    underground_workover_plan: _.sumBy(item, 'undeground_workover_plan'),
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
                        workover: _.sumBy(groupedForChart[i], 'otm_well_workover_fact'),
                        underground_workover: _.sumBy(groupedForChart[i], 'otm_underground_workover'),
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