import moment from "moment";

export default {
    data: function () {
        return {
            prod_wells_workPercent: 0,
            prod_wells_idlePercent: 0,
            innerWells2SelectedRow: 'fond_neftedob_ef',
            innerWells2ChartData: [],
            prod_wells_work: 0,
            prod_wells_idle: 0,
            productionWells: '',
            productionFonds: [
                'fond_neftedob_ef',
                'fond_neftedob_df',
                'fond_neftedob_bd',
                'fond_neftedob_osvoenie',
                'fond_neftedob_ofls',
                'fond_neftedob_prs',
                'fond_neftedob_oprs',
                'fond_neftedob_krs',
                'fond_neftedob_okrs',
                'fond_neftedob_well_survey',
                'fond_neftedob_nrs',
                'fond_neftedob_others'
            ],
        };
    },
    methods: {
        calculateProductionWellsData() {
            this.wellStockIdleButtons.isProductionIdleButtonActive = !this.wellStockIdleButtons.isProductionIdleButtonActive;
            this.updateProductionData(this.planFieldName, this.factFieldName, this.chartHeadName, this.metricName, this.chartSecondaryName);
        },

        updateWellsWidgetPercentData(data) {
            let periodStartTimestamp = this.timestampToday - this.quantityRange * 86400000;
            let filteredDataByPeriod = this.getProductionDataInPeriodRange(data,periodStartTimestamp,this.timestampToday);
            let groupedWellsData = this.getGroupedWellsData(filteredDataByPeriod);

            this.inj_wells_idlePercent = groupedWellsData[0]['inj_wells_idle'];
            this.inj_wells_workPercent = groupedWellsData[0]['inj_wells_work'];
            this.prod_wells_workPercent = groupedWellsData[0]['prod_wells_work'];
            this.prod_wells_idlePercent = groupedWellsData[0]['prod_wells_idle'];
        },

    },
    computed: {
        innerWellsProd2DataForChart() {
            let series = []
            let labels = []
            for (let i in this.innerWells2ChartData) {
                series.push(this.innerWells2SelectedRow ? this.innerWells2ChartData[i][this.innerWells2SelectedRow] : this.innerWells2ChartData[i]['fond_neftedob_ef'])
                labels.push(i)
            }
            return {
                series: series,
                labels: labels
            }
        },
    },
}