import moment from "moment";

export default {
    data: function () {
        return {
            drillingDetails: [],
            drillingPeriodStart: moment().subtract(1, 'days').startOf('day').format('DD.MM.YYYY'),
            drillingPeriodEnd: moment().subtract(1, 'days').endOf('day').format('DD.MM.YYYY'),
            drillingDailyPeriod: 'button-tab-highlighted',
            drillingMonthlyPeriod: '',
            drillingYearlyPeriod: '',
            drillingPeriod: '',
            isDrillingPeriodSelected: false,
            drillingPeriodMapping: {
                drillingDailyPeriod: {
                    'start': moment().subtract(1, 'days').startOf('day').format('DD.MM.YYYY'),
                    'end': moment().subtract(1, 'days').endOf('day').format('DD.MM.YYYY'),
                },
                drillingMonthlyPeriod: {
                    'start': moment().startOf('month').format('DD.MM.YYYY'),
                    'end': moment().format('DD.MM.YYYY'),
                },
                drillingYearlyPeriod: {
                    'start': moment().startOf('year').format('DD.MM.YYYY'),
                    'end': moment().format('DD.MM.YYYY'),
                },
                drillingPeriod: {
                    'start': moment().format('DD.MM.YYYY'),
                    'end': moment().format('DD.MM.YYYY')
                },
            },
            drillingSelectedCompany: 'all',
            drillingSelectedRow: 'otm_wells_commissioning_from_drilling_fact',
            drillingData: [
                {
                    name: this.trans("visualcenter.otmIzBurenia"),
                    code: 'otm_wells_commissioning_from_drilling_fact',
                    plan: 0,
                    fact: 0,
                    difference: 0,
                    metricSystem: this.trans("visualcenter.otmMetricSystemWells"),
                },
                {
                    name: this.trans("visualcenter.otmBurenieProhodka"),
                    code: 'otm_drilling_fact',
                    plan: 0,
                    fact: 0,
                    difference: 0,
                    metricSystem: this.trans("visualcenter.otmMetricSystemMeter"),
                },
            ],
            drillingChartData: [],
            drillingWidgetFactSum: 0,
        };
    },
    methods: {
        async getDrillingByMonth() {
            let queryOptions = {
                'startPeriod': this.drillingPeriodStart,
                'endPeriod': this.drillingPeriodEnd
            };

            let uri = this.localeUrl("/get-drilling-details");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status === 200) {
                return response.data;
            }
            return {};
        },

        async switchDrillingPeriod(buttonType) {
            this.$store.commit('globalloading/SET_LOADING', true);
            this.drillingDailyPeriod = "";
            this.drillingMonthlyPeriod = "";
            this.drillingYearlyPeriod = "";
            this.drillingPeriod = "";
            this[buttonType] = this.highlightedButton;
            this.drillingPeriodStart = this.drillingPeriodMapping[buttonType].start;
            this.drillingPeriodEnd = this.drillingPeriodMapping[buttonType].end;
            this.isDrillingPeriodSelected = this.isDrillingFewDaysSelected();
            this.drillingDetails = await this.getDrillingByMonth();
            this.updateDrillingWidget();
            this.$store.commit('globalloading/SET_LOADING', false);
        },

        isDrillingFewDaysSelected() {
            let startDate =  moment(this.drillingPeriodStart,'DD.MM.YYYY');
            let endDate = moment(this.drillingPeriodEnd,'DD.MM.YYYY');
            return endDate.diff(startDate, 'days') > 0;
        },

        switchDrillingPeriodRange() {
            this.switchDrillingPeriod('drillingPeriod');
        },

        async updateDrillingWidget() {
            let temporaryDrillingDetails = _.cloneDeep(this.drillingDetails);
            console.log('this.drillingSelectedCompany')
            console.log(this.drillingSelectedCompany)
            if (this.drillingSelectedCompany !== 'all') {
                temporaryDrillingDetails = this.getDrillingFilteredByDzo(temporaryDrillingDetails,this.drillingSelectedCompany);
            }

            let self = this;

            _.forEach(temporaryDrillingDetails, function(item) {
                let dateOption = [moment(item.date).month(),moment(item.date).year()];
                let planIndex = self.dzoMonthlyPlans.findIndex(element => self.isRecordsSimple(dateOption,element,item.dzo_name));
                if (planIndex !== -1) {
                    let plan = self.dzoMonthlyPlans[planIndex].plan_otm_iz_burenia_skv;
                    let planByDay = plan / moment().daysInMonth();
                    item['otm_wells_commissioning_from_drilling_plan'] = planByDay;
                    item['otm_drilling_plan'] = self.dzoMonthlyPlans[planIndex].plan_otm_burenie_prohodka;
                }
            });

            this.updateDrillingWidgetTable(temporaryDrillingDetails);
            this.drillingChartData = this.getDrillingWidgetChartData(temporaryDrillingDetails);
        },

        getDrillingWidgetChartData(temporaryDrillingDetails) {
            let groupedForChart =  _.groupBy(temporaryDrillingDetails, item => {
                return moment(item.date).startOf('day').format();
            });

            let chartData = {};
            if (groupedForChart) {
                for (let i in groupedForChart) {
                    chartData[i] = {
                        otm_wells_commissioning_from_drilling_fact: _.round(_.sumBy(groupedForChart[i], 'otm_wells_commissioning_from_drilling_fact'), 0),
                        otm_drilling_fact: _.round(_.sumBy(groupedForChart[i], 'otm_drilling_fact'), 0),
                        otm_wells_commissioning_from_drilling_plan: _.round(_.sumBy(groupedForChart[i], 'otm_wells_commissioning_from_drilling_plan'), 0),
                        otm_drilling_plan: _.round(_.sumBy(groupedForChart[i], 'otm_drilling_plan'), 0),
                    }
                }
            }

            return chartData;
        },

        updateDrillingWidgetTable(temporaryDrillingDetails) {
            let tableData = _(temporaryDrillingDetails)
                .groupBy("data")
                .map((item) => ({
                    otm_wells_commissioning_from_drilling_fact: _.round(_.sumBy(item, 'otm_wells_commissioning_from_drilling_fact'), 0),
                    otm_wells_commissioning_from_drilling_fact_plan: _.round(_.sumBy(item, 'otm_wells_commissioning_from_drilling_plan'), 0),
                    otm_drilling_fact: _.round(_.sumBy(item, 'otm_drilling_fact'), 0),
                    otm_drilling_fact_plan: _.round(_.sumBy(item, 'otm_drilling_plan'), 0),
                })).value();

            this.drillingWidgetFactSum = this.getDrillingFactSum(tableData,'otm_wells_commissioning_from_drilling_fact');
        },

        getDrillingFactSum(tableData,workoverType) {
            let totalDrillingFact = 0;
            if (tableData.length > 0) {
                _.forEach(this.drillingData, function(item) {
                    item.plan = tableData[0][item.code + '_plan'];
                    item.fact = tableData[0][item.code];
                    item.difference = item.plan - item.fact;
                });
                totalDrillingFact += tableData[0][workoverType];
            }

            return totalDrillingFact;
        },

        changeSelectedDrillingCompanies(e) {
            this.drillingSelectedCompany = e.target.value;
            this.updateDrillingWidget();
        },

        getDrillingFilteredByDzo(inputData,dzoName) {
            return _.filter(inputData, function (item) {
                return (item.dzo_name === dzoName);
            })
        },
    },
    computed: {
        drillingDataForChart() {
            let series = []
            let labels = []
            for (let i in this.drillingChartData) {
                series.push(this.drillingChartData[i][this.drillingSelectedRow])
                labels.push(i)
            }
            return {
                series: series,
                labels: labels
            }
        },
    },
}