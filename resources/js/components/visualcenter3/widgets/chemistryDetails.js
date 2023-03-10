import moment from "moment";

export default {
    data: function () {
        return {
            chemistryDetails: [],
            chemistryPeriodStartMonth: moment().subtract(1, 'months').format('MMMM YYYY'),
            chemistryPeriodEndMonth: moment().subtract(1, 'months').format('MMMM YYYY'),
            chemistryMonthlyPeriod: 'button-tab-highlighted',
            chemistryYearlyPeriod: '',
            chemistryPeriod: '',
            isChemistryPeriodSelected: false,
            chemistryPeriodMapping: {
                chemistryMonthlyPeriod: [
                    moment().subtract(1, 'months').format("MMMM yyyy"),
                    moment().subtract(1, 'months').format("MMMM yyyy"),
                ],
                chemistryYearlyPeriod: [
                    moment().startOf('year').format("MMMM yyyy"),
                    moment().format('MMMM yyyy'),
                ],
                chemistryPeriod: [
                    moment().subtract(1, 'months').format("MMMM yyyy"),
                    moment().subtract(1, 'months').format("MMMM yyyy")
                ],
            },
            chemistrySelectedCompany: 'all',
            chemistrySelectedRow: 'demulsifier',
            chemistryData: [
                {
                    name: this.trans("visualcenter.chemProdZakackaDemulg"),
                    code: 'demulsifier',
                    plan: 0,
                    fact: 0,
                    metricSystem: this.trans("visualcenter.chemistryMetricTon"),
                },
                {
                    name: this.trans("visualcenter.chemProdZakackaBakteracid"),
                    code: 'bactericide',
                    plan: 0,
                    fact: 0,
                    metricSystem: this.trans("visualcenter.chemistryMetricTon"),
                },
                {
                    name: this.trans("visualcenter.chemProdZakackaIngibatorKorrozin"),
                    code: 'corrosion_inhibitor',
                    plan: 0,
                    fact: 0,
                    metricSystem: this.trans("visualcenter.chemistryMetricTon"),
                },
                {
                    name: this.trans("visualcenter.chemProdZakackaIngibatorSoleotloj"),
                    code: 'scale_inhibitor',
                    plan: 0,
                    fact: 0,
                    metricSystem: this.trans("visualcenter.chemistryMetricTon"),
                },
            ],
            chemistryChartData: [],
            chemistryWidgetFactSum: 0,
            chemistryDailyChart: {
                series: [],
                labels: []
            },
        };
    },
    methods: {
        async getChemistryByMonth() {
            let queryOptions = {
                'startPeriod': moment(this.chemistryPeriodStartMonth,'MMMM YYYY').month() + 1,
                'endPeriod': moment(this.chemistryPeriodEndMonth,'MMMM YYYY').month() + 1
            };
            let uri = this.localeUrl("/get-chemistry-details");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.data && response.data.length === 0) {
                this.chemistryPeriodStartMonth = moment(this.chemistryPeriodStartMonth,'MMMM YYYY').subtract(1,'months').format('MMMM YYYY');
                this.chemistryPeriodEndMonth = moment(this.chemistryPeriodEndMonth,'MMMM YYYY').subtract(1,'months').format('MMMM YYYY');
                return await this.getChemistryByMonth();
            }
            if (response.status === 200) {
                return response.data;
            }
            return {};
        },

        async switchChemistryPeriod(buttonType) {
            this.SET_LOADING(true);
            this.chemistryMonthlyPeriod = "";
            this.chemistryYearlyPeriod = "";
            this.chemistryPeriod = "";
            this[buttonType] = this.highlightedButton;
            this.chemistryPeriodStartMonth = this.chemistryPeriodMapping[buttonType][0];
            this.chemistryPeriodEndMonth = this.chemistryPeriodMapping[buttonType][1];
            if (buttonType === 'chemistryMonthlyPeriod' && moment().date() < 11) {
                this.chemistryPeriodStartMonth = moment(this.chemistryPeriodStartMonth,'MMMM YYYY').subtract(1,'months').format('MMMM YYYY');
                this.chemistryPeriodEndMonth = moment(this.chemistryPeriodEndMonth,'MMMM YYYY').subtract(1,'months').format('MMMM YYYY');
            }
            this.isChemistryPeriodSelected = this.isChemistryFewMonthsSelected();
            this.chemistryDetails = await this.getChemistryByMonth();
            this.updateChemistryWidget();
            this.SET_LOADING(false);
        },

        isChemistryFewMonthsSelected() {
            let startDate =  moment(this.chemistryPeriodStartMonth, 'MMMM YYYY');
            let endDate = moment(this.chemistryPeriodEndMonth, 'MMMM YYYY');
            return endDate.diff(startDate, 'months') > 0;
        },

        switchChemistryPeriodRange() {
            this.switchChemistryPeriod('chemistryPeriod');
        },

        async updateChemistryWidget() {
            let temporaryChemistryDetails = _.cloneDeep(this.chemistryDetails);
            if (this.chemistrySelectedCompany !== 'all') {
                temporaryChemistryDetails = this.getChemistryFilteredByDzo(temporaryChemistryDetails,this.chemistrySelectedCompany);
            }
            let self = this;
            _.forEach(temporaryChemistryDetails, function(item) {
                let dateOption = [moment(item.date).month(),moment(item.date).year()];
                let planIndex = self.dzoMonthlyPlans.findIndex(element => self.isRecordsSimple(dateOption,element,item.dzo_name));
                if (planIndex !== -1) {
                    item['bactericide_plan'] = self.dzoMonthlyPlans[planIndex].plan_chem_prod_zakacka_bakteracid;
                    item['corrosion_inhibitor_plan'] = self.dzoMonthlyPlans[planIndex].plan_chem_prod_zakacka_ingibator_korrozin;
                    item['demulsifier_plan'] = self.dzoMonthlyPlans[planIndex].plan_chem_prod_zakacka_demulg;
                    item['scale_inhibitor_plan'] = self.dzoMonthlyPlans[planIndex].plan_chem_prod_zakacka_ingibator_soleotloj;
                }
            });

            this.updateChemistryWidgetTable(temporaryChemistryDetails);
            if (this.chemistryMonthlyPeriod.length > 0) {
                this.chemistryDailyChart.series = this.chemistryData.map(field => field.fact);
                this.chemistryDailyChart.labels = this.chemistryData.map(field => field.code);
            } else {
                this.chemistryChartData = this.getChemistryWidgetChartData(temporaryChemistryDetails);
            }
        },

        getChemistryWidgetChartData(temporaryChemistryDetails) {
            let groupedForChart =  _.groupBy(temporaryChemistryDetails, item => {
                return moment(item.date).startOf('day').format("YYYY-MM");
            });
            let chartData = {};
            if (groupedForChart) {
                for (let i in groupedForChart) {
                    chartData[i] = {
                        demulsifier: _.round(_.sumBy(groupedForChart[i], 'demulsifier'), 0),
                        bactericide: _.round(_.sumBy(groupedForChart[i], 'bactericide'), 0),
                        corrosion_inhibitor: _.round(_.sumBy(groupedForChart[i], 'corrosion_inhibitor'), 0),
                        scale_inhibitor: _.round(_.sumBy(groupedForChart[i], 'scale_inhibitor'), 0),
                    }
                }
            }
            return chartData;
        },

        updateChemistryWidgetTable(temporaryChemistryDetails) {
            let tableData = _(temporaryChemistryDetails)
                .groupBy("data")
                .map((item) => ({
                    bactericide: _.round(_.sumBy(item, 'bactericide'), 0),
                    bactericide_plan: _.round(_.sumBy(item, 'bactericide_plan'), 0),
                    corrosion_inhibitor: _.round(_.sumBy(item, 'corrosion_inhibitor'), 0),
                    corrosion_inhibitor_plan: _.round(_.sumBy(item, 'corrosion_inhibitor_plan'), 0),
                    demulsifier: _.round(_.sumBy(item, 'demulsifier'), 0),
                    demulsifier_plan: _.round(_.sumBy(item, 'demulsifier_plan'), 0),
                    scale_inhibitor: _.round(_.sumBy(item, 'scale_inhibitor'), 0),
                    scale_inhibitor_plan: _.round(_.sumBy(item, 'scale_inhibitor_plan'), 0),
                })).value();
            this.chemistryWidgetFactSum = this.getChemistryFactSum(tableData);
        },

        getChemistryFactSum(tableData) {
            let totalChemistryFact = 0;
            if (tableData.length > 0) {
                _.forEach(this.chemistryData, function(item) {
                    item.plan = tableData[0][item.code + '_plan'];
                    item.fact = tableData[0][item.code];
                });
                _.forEach(Object.keys(tableData[0]), function(key) {
                    if (!key.includes('_plan')) {
                        totalChemistryFact += tableData[0][key];
                    }
                });
            }

            return totalChemistryFact;
        },

        changeSelectedChemistryCompanies(e) {
            this.chemistrySelectedCompany = e.target.value;
            this.updateChemistryWidget();
        },

        getChemistryFilteredByDzo(inputData,dzoName) {
            return _.filter(inputData, function (item) {
                return (item.dzo_name === dzoName);
            })
        },
    },
    computed: {
        chemistryDataForChart() {
            let series = {
                fact: []
            }
            let labels = []
            for (let i in this.chemistryChartData) {
                series.fact.push(this.chemistryChartData[i][this.chemistrySelectedRow]);
                labels.push(i);
            }
            return {
                series: series,
                labels: labels
            }
        },
    },
}