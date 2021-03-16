import moment from "moment";

export default {
    data: function () {
        return {
            WellsDataAll: '',
            inj_wells_idlePercent: 0,
            inj_wells_workPercent: 0,
            innerWellsSelectedRow: 'fond_nagnetat_ef',
            innerWellsChartData: [],
            inj_wells_idle: 0,
            inj_wells_work: 0,
            injectionWells: [
                {name: "ЭФ", value: 603, value2: 101},
                {name: "ДФ", value: 98, value2: 56},
                {name: "В работе добывающие скважины", value: 45, value2: 31},
                {name: "БД", value: 121, value2: 108},
                {name: "Освоение", value: 143, value2: 114},
                {name: "ОФЛС", value: 98, value2: 36},
                {name: "Простой добывающих скважин", value: 86, value2: 54}
            ],
            waterInjectionButton: "",
            wellStockIdleButtons: {
                isProductionIdleButtonActive: false,
                isInjectionIdleButtonActive: false,
            },
            injectionFonds: [
                'fond_nagnetat_ef',
                'fond_nagnetat_df',
                'fond_nagnetat_bd',
                'fond_nagnetat_osvoenie',
                'fond_nagnetat_ofls',
                'fond_nagnetat_konv',
                'fond_nagnetat_prs',
                'fond_nagnetat_oprs',
                'fond_nagnetat_krs',
                'fond_nagnetat_okrs',
                'fond_nagnetat_well_survey',
                'fond_nagnetat_others'
            ],
            injectionWellsOptions: [
                {ticker: 'all', name: this.trans("visualcenter.allCompany")},
                {ticker: 'ОМГ', name: this.trans("visualcenter.omg")},
                {ticker: 'ММГ', name: this.trans("visualcenter.mmg")},
                {ticker: 'КГМ', name: this.trans("visualcenter.kgm")},
                {ticker: 'КОА', name: this.trans("visualcenter.koa")},
                {ticker: 'КГМ', name: this.trans("visualcenter.kgm")},
                {ticker: 'КБМ', name: this.trans("visualcenter.kbm")},
                {ticker: 'ЭМГ', name: this.trans("visualcenter.emg")},
            ],
        };
    },
    methods: {
        calculateInjectionWellsData() {
            this.wellStockIdleButtons.isInjectionIdleButtonActive = !this.wellStockIdleButtons.isInjectionIdleButtonActive;
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.chartSecondaryName);
        },

        getSummaryInjectionWellsForChart(inputData) {
            let innerWells = _.groupBy(inputData, item => {
                return moment(parseInt(item.__time)).format("YYYY-MM-DD");
            });

            let result = {};

            if (typeof innerWells !== 'undefined') {
                for (let i in innerWells) {
                    result[i] = {
                        fond_nagnetat_ef: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_ef'), 0),
                        fond_nagnetat_df: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_df'), 0),
                        fond_nagnetat_bd: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_bd'), 0),
                        fond_nagnetat_osvoenie: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_osvoenie'), 0),
                        fond_nagnetat_ofls: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_ofls'), 0),
                        fond_nagnetat_konv: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_konv'), 0),
                        fond_nagnetat_prs: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_prs'), 0),
                        fond_nagnetat_oprs: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_oprs'), 0),
                        fond_nagnetat_krs: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_krs'), 0),
                        fond_nagnetat_okrs: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_okrs'), 0),
                        fond_nagnetat_well_survey: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_well_survey'), 0),
                        fond_nagnetat_others: _.round(_.sumBy(innerWells[i], 'fond_nagnetat_others'), 0),
                    }
                }
            }
            return result;
        },

        innerWellsNagMetOnChange($event) {
            this.company = $event.target.value;
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.chartSecondaryName);
        },

        innerWellsProdMetOnChange($event) {
            this.company = $event.target.value;
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.chartSecondaryName);
        },
    },
    computed: {
        innerWellsNagDataForChart() {
            let series = []
            let labels = []
            for (let i in this.innerWellsChartData) {
                series.push(this.innerWellsSelectedRow ? this.innerWellsChartData[i][this.innerWellsSelectedRow] : this.innerWellsChartData[i]['fond_nagnetat_ef'])
                labels.push(i)
            }
            return {
                series: series,
                labels: labels
            }
        },
    },
}