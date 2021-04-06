import moment from "moment";

export default {
    data: function () {
        return {
            opecDataSummMonth: 0,
            opecDataSumm: 0,
            opecData: 0,
            opec: 'утв.',
            kmgParticipationPercent: {
                'АО "Каражанбасмунай"': 0.5,
                'ТОО "Казгермунай"': 0.5,
                'АО ПетроКазахстан Кумколь Ресорсиз': 0.33,
                'ПетроКазахстан Инк.': 0.33,
                'АО "Тургай-Петролеум"': 0.5 * 0.33,
                "ТОО «Тенгизшевройл»": 0.2,
                'АО "Мангистаумунайгаз"': 0.5,
                'ТОО "Казахойл Актобе"': 0.5,
                "«Карачаганак Петролеум Оперейтинг б.в.»": 0.1,
                "«Норт Каспиан Оперейтинг Компани н.в.»": 0.1688
            },
            opecFieldNameForChart: '',
        };
    },
    methods: {
        changeOilProductionFilters() {
            if (this.isOpecFilterActive) {
                this.planFieldName = 'oil_opek_plan';
                this.opec = this.trans("visualcenter.dzoOpec");
                this.opecFieldNameForChart = 'oil_plan';
                this.chartSecondaryName = this.trans("visualcenter.getoil");
            } else {
                this.opec = this.trans("visualcenter.utv");
                this.planFieldName = 'oil_plan';
                this.dzoCompaniesAssets['isOpecRestriction'] = false;
            }
        },

        calculateKmgParticipationFilter(planAndFactSummary, dzoFieldName,factFieldName,planFieldName) {
            return planAndFactSummary.map(item => {
                if (typeof this.kmgParticipationPercent[this.getNameDzoFull(item[dzoFieldName])] !== 'undefined') {
                    item[factFieldName] = item[factFieldName] * this.kmgParticipationPercent[this.getNameDzoFull(item[dzoFieldName])]
                    item[planFieldName] = item[planFieldName] * this.kmgParticipationPercent[this.getNameDzoFull(item[dzoFieldName])]
                }
                return item;
            });
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
                    this.opecDataSumm = opecDataSumm;

                } else {
                    console.log('Not opec data');
                }
            });
        },

        getOpecMonth(data) {

            let dataWithMay = _.filter(data, _.iteratee({date: (this.year + '-' + this.pad(this.month) + '-01' + ' 00:00:00')}));
            if (dataWithMay.length === 0) {
                let dateFormat = 'YYYY-MM-DD HH:mm:ss';
                let lastWorkingDay = this.getPreviousWorkday();
                let lastSynchronizeDay = moment(lastWorkingDay).startOf('day').add(1, "days").format(dateFormat);
                dataWithMay = _.filter(data, _.iteratee({date: lastSynchronizeDay}));
            }
            let oil;
            if (this.opec === "ОПЕК+") {
                oil = 'oil_opek_plan';
            } else {
                oil = 'oil_plan';
            }

            let SummFromRange = _(dataWithMay)
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

            this.opecDataSummMonth = opecDataSumm;

            return SummFromRange;
        },

        disableOilFilters() {
            this.isOpecFilterActive = false;
            this.changeOilProductionFilters();
            this.isKmgParticipationFilterActive = false;
        },
    },
}