import moment from "moment";

export default {
    data: function () {
        return {
            otmData: [],
            otmSelectedRow: 'otm_iz_burenia_skv_fact',
            otmChartData: [],
        };
    },
    methods: {
        getOtmData(arr) {
            let otmData = _(arr)
                .groupBy("data")
                .map((__time, id) => ({
                    __time: id,
                    otm_iz_burenia_skv_plan: _.round(_.sumBy(__time, 'otm_iz_burenia_skv_plan'), 0),
                    otm_iz_burenia_skv_fact: _.round(_.sumBy(__time, 'otm_iz_burenia_skv_fact'), 0),
                    otm_burenie_prohodka_plan: _.round(_.sumBy(__time, 'otm_burenie_prohodka_plan'), 0),
                    otm_burenie_prohodka_fact: _.round(_.sumBy(__time, 'otm_burenie_prohodka_fact'), 0),
                    otm_krs_skv_plan: _.round(_.sumBy(__time, 'otm_krs_skv_plan'), 0),
                    otm_krs_skv_fact: _.round(_.sumBy(__time, 'otm_krs_skv_fact'), 0),
                    otm_prs_skv_plan: _.round(_.sumBy(__time, 'otm_prs_skv_plan'), 0),
                    otm_prs_skv_fact: _.round(_.sumBy(__time, 'otm_prs_skv_fact'), 0),
                }))
                .value();

            let result = [];

            result.push(
                {
                    name: this.trans("visualcenter.otmIzBurenia"),
                    code: 'otm_iz_burenia_skv_fact',
                    plan: otmData[0]['otm_iz_burenia_skv_plan'],
                    fact: otmData[0]['otm_iz_burenia_skv_fact'],
                    metricSystem: this.trans("visualcenter.otmMetricSystemWells"),
                },
                {
                    name: this.trans("visualcenter.otmBurenieProhodka"),
                    code: 'otm_burenie_prohodka_fact',
                    plan: otmData[0]['otm_burenie_prohodka_plan'],
                    fact: otmData[0]['otm_burenie_prohodka_fact'],
                    metricSystem: this.trans("visualcenter.otmMetricSystemMeter"),
                },
                {
                    name: this.trans("visualcenter.otmKrsSkv"),
                    code: 'otm_krs_skv_fact',
                    plan: otmData[0]['otm_krs_skv_plan'],
                    fact: otmData[0]['otm_krs_skv_fact'],
                    metricSystem: this.trans("visualcenter.otmMetricSystemWells"),
                },
                {
                    name: this.trans("visualcenter.otmPrsSkv"),
                    code: 'otm_prs_skv_fact',
                    plan: otmData[0]['otm_prs_skv_plan'],
                    fact: otmData[0]['otm_prs_skv_fact'],
                    metricSystem: this.trans("visualcenter.otmMetricSystemWells"),
                },
            )

            return result
        },

        getOtmChartData(arr) {
            let otmData
            otmData = _.groupBy(arr, item => {
                return moment(parseInt(item.__time)).format("YYYY-MM-DD");
            })

            let result = {}

            if (typeof otmData !== 'undefined') {
                for (let i in otmData) {
                    result[i] = {
                        otm_iz_burenia_skv_fact: _.round(_.sumBy(otmData[i], 'otm_iz_burenia_skv_fact'), 0),
                        otm_burenie_prohodka_fact: _.round(_.sumBy(otmData[i], 'otm_burenie_prohodka_fact'), 0),
                        otm_krs_skv_fact: _.round(_.sumBy(otmData[i], 'otm_krs_skv_fact'), 0),
                        otm_prs_skv_fact: _.round(_.sumBy(otmData[i], 'otm_prs_skv_fact'), 0),
                    }
                }
            }


            return result
        },

    },
    computed: {
        otmDataForChart() {
            let series = []
            let labels = []
            for (let i in this.otmChartData) {
                series.push(this.otmSelectedRow ? this.otmChartData[i][this.otmSelectedRow] : this.otmChartData[i]['otm_iz_burenia_skv_fact'])
                labels.push(i)
            }
            return {
                series: series,
                labels: labels
            }
        },
    },
}