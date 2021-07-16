import moment from "moment";

export default {
    data: function () {
        return {
            opecData: 0,
            opec: 'утв.',
        };
    },
    methods: {
        changeOilProductionFilters() {
            if (this.isOpecFilterActive && this.oilCondensateProductionButton.length === 0) {
                this.planFieldName = 'oil_opek_plan';
                this.opec = this.trans("visualcenter.dzoOpec");
                this.chartSecondaryName = this.trans("visualcenter.getoil");
            } else {
                this.opec = this.trans("visualcenter.utv");
                this.planFieldName = 'oil_plan';
                this.dzoCompaniesAssets['isOpecRestriction'] = false;
            }
        },

        addOpecToDzoSummary(inputData, mainTableData) {
            let opecData = _.cloneDeep(this.opecData);
            let self = this;
            if (this.buttonMonthlyTab) {
                opecData = this.getOpecMonth(inputData);
            }

            opecData = _.orderBy(
                opecData,
                ["dzoMonth"],
                ["asc"]
            );

            _.forEach(opecData, function(dzoOpec, i) {
                let opecDzoName = dzoOpec.dzoMonth;
                let opecDzoPeriodPlan = dzoOpec.periodPlan;
                self.addPeriodPlanData(mainTableData, opecDzoName, opecDzoPeriodPlan);
            });
        },

        getOpecDataForYear() {
            let uri = this.localeUrl("/visualcenter3GetDataOpec");

            this.axios.get(uri).then((response) => {
                let data = response.data;
                if (data) {
                    let SummFromRange = _(data)
                        .groupBy("dzo")
                        .map((dzo, id) => ({
                            dzoMonth: id,
                            periodPlan: _.round(_.sumBy(dzo, 'oil_plan'), 0),
                        }))

                        .value();
                    let opecDataSumm = _.reduce(
                        SummFromRange,
                        function (memo, item) {
                            return memo + item.periodPlan;
                        },
                        0
                    );

                    this.opecData = SummFromRange;

                } else {
                    console.log('Not opec data');
                }
            });
        },

        getOpecMonth(data) {
            let filteredByOneDay = _.filter(data, _.iteratee({date: moment().startOf('month').valueOf()}));

            if (filteredByOneDay.length === 0) {
                let dateFormat = 'YYYY-MM-DD HH:mm:ss';
                let lastWorkingDay = this.getPreviousWorkday();
                let lastSynchronizeDay = moment(lastWorkingDay).startOf('day').add(1, "days").format(dateFormat);
                filteredByOneDay = _.filter(data, _.iteratee({date: lastSynchronizeDay}));
            }
            let oil;
            if (this.opec === "ОПЕК+") {
                oil = 'oil_opek_plan';
            } else {
                oil = 'oil_plan';
            }

            let SummFromRange = _(filteredByOneDay)
                .groupBy("dzo")
                .map((dzo, id) => ({
                    dzoMonth: id,
                    periodPlan: (_.sumBy(dzo, oil)) * moment().daysInMonth(),
                }))
                .value();


            let opecDataSumm = _.reduce(
                SummFromRange,
                function (memo, item) {
                    return memo + item.periodPlan;
                },
                0
            );

            return SummFromRange;
        },

        disableOilFilters() {
            this.isOpecFilterActive = false;
            this.changeOilProductionFilters();
        },

        disableTargetCompanyFilter() {
            this.$refs.targetPlan.classList.remove('show');
            this.isFilterTargetPlanActive = false;
            this.buttonTargetPlan = "";
        },
    },
}