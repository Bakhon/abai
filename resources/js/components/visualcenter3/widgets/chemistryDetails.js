import moment from "moment";

export default {
    data: function () {
        return {
            isProductionDetailsActive: true,
            otmDetails: [],
            chemistryDetails: [],
            chemistryPeriodStartMonth: moment().format('MMMM YYYY'),
            chemistryPeriodEndMonth: moment().format('MMMM YYYY'),
            chemistryMonthlyPeriod: 'button-tab-highlighted',
            chemistryYearlyPeriod: '',
            chemistryPeriod: '',
            isChemistryPeriodSelected: false,
            chemistryRange: {
                'start': new Date(),
                'end': new Date(),
            },
            chemistryPeriodMapping: {
                chemistryMonthlyPeriod: {
                    'periodStart': moment().format('MMMM YYYY'),
                    'periodEnd': moment().format('MMMM YYYY'),
                },
                chemistryYearlyPeriod: {
                    'periodStart': moment().startOf('year').format('MMMM YYYY'),
                    'periodEnd': moment().format('MMMM YYYY'),
                },
                chemistryPeriod: {
                   'periodStart': moment().format('MMMM YYYY'),
                   'periodEnd': moment().format('MMMM YYYY'),
                },
            },
            chemistrySelectedCompany: 'all',
        };
    },
    methods: {
        async getChemistryByMonth() {
            let queryOptions = {
                'startPeriod': moment(this.chemistryPeriodStartMonth,'MMMM YYYY').month(),
                'endPeriod': moment(this.chemistryPeriodEndMonth,'MMMM YYYY').month()
            };
            let uri = this.localeUrl("/get-chemistry-details");
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status === 200) {
                return response.data;
            }
            return {};
        },

        async switchChemistryPeriod(buttonType) {
            this.chemistryMonthlyPeriod = "";
            this.chemistryYearlyPeriod = "";
            this.chemistryPeriod = "";
            this[buttonType] = this.highlightedButton;
            this.chemistryPeriodStartMonth = this.chemistryPeriodMapping[buttonType].periodStart;
            this.chemistryPeriodEndMonth = this.chemistryPeriodMapping[buttonType].periodEnd;
            this.isChemistryPeriodSelected = this.isChemistryFewMonthsSelected();
            this.chemistryDetails = await this.getChemistryByMonth();
            this.updateChemistryWidget();
        },

        isChemistryFewMonthsSelected() {
            let startDate =  moment(this.chemistryPeriodStartMonth, 'MMMM YYYY');
            let endDate = moment(this.chemistryPeriodEndMonth, 'MMMM YYYY');
            return endDate.diff(startDate, 'months') > 0;
        },

        switchPeriodRange() {
            this.switchChemistryPeriod('chemistryPeriod');
        },

        updateChemistryWidget() {
            let temporaryChemistryDetails = _.cloneDeep(this.chemistryDetails);
            if (this.chemistrySelectedCompany !== 'all') {
                temporaryChemistryDetails = this.getChemistryFilteredByDzo(temporaryChemistryDetails,this.chemistrySelectedCompany);
            }
            let self = this;
            _.forEach(temporaryChemistryDetails, function(item) {
                let dateOption = [moment(item.date).month(),moment(item.date).year()];
                let planIndex = self.dzoMonthlyPlans.findIndex(element => self.isChemistryRecordsSimple(dateOption,element,item.dzo_name));
                if (planIndex !== -1) {
                    item['bactericide_plan'] = self.dzoMonthlyPlans[planIndex].plan_chem_prod_zakacka_bakteracid * moment(item.date).daysInMonth();
                    item['corrosion_inhibitor_plan'] = self.dzoMonthlyPlans[planIndex].plan_chem_prod_zakacka_ingibator_korrozin * moment(item.date).daysInMonth();
                    item['demulsifier_plan'] = self.dzoMonthlyPlans[planIndex].plan_chem_prod_zakacka_demulg * moment(item.date).daysInMonth();
                    item['scale_inhibitor_plan'] = self.dzoMonthlyPlans[planIndex].plan_chem_prod_zakacka_ingibator_soleotloj * moment(item.date).daysInMonth();
                }
            });
            this.updateChemistryWidgetTable(temporaryChemistryDetails);
            this.chemistryChartData = this.getChemistryWidgetChartData(temporaryChemistryDetails);
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
            this.chemistryDataFactSumm = this.getChemistryFactSum(tableData);
        },

        getChemistryFactSum(tableData) {
            let totalChemistryFact = 0;
            if (tableData.length > 0) {
                _.forEach(this.chemistryData, function(item) {
                    item.plan = tableData[0][item.code + '_plan'];
                    item.fact = tableData[0][item.code];
                });
                _.forEach(Object.keys(tableData[0]), function(key) {
                    totalChemistryFact += tableData[0][key];
                });
            }
            return totalChemistryFact;
        },

        isChemistryRecordsSimple(inputDateOption,planItem,inputDzoName) {
            return inputDateOption[0] === moment(planItem.date).month() &&
                inputDateOption[1] === moment(planItem.date).year() &&
                planItem.dzo === inputDzoName;
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
}