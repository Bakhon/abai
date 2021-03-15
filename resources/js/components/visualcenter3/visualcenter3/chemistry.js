import moment from "moment";

export default {
    data: function () {
        return {
            chemistryData: [],
            chemistrySelectedRow: 'chem_prod_zakacka_demulg_fact',
            chemistryChartData: [],
        };
    },
    methods: {
        getChemistryData(arr) {
            let chemistryData = _(arr)
                .groupBy("data")
                .map((__time, id) => ({
                    __time: id,
                    chem_prod_zakacka_demulg_plan: _.round(_.sumBy(__time, 'chem_prod_zakacka_demulg_plan'), 0),
                    chem_prod_zakacka_demulg_fact: _.round(_.sumBy(__time, 'chem_prod_zakacka_demulg_fact'), 0),
                    chem_prod_zakacka_bakteracid_plan: _.round(_.sumBy(__time, 'chem_prod_zakacka_bakteracid_plan'), 0),
                    chem_prod_zakacka_bakteracid_fact: _.round(_.sumBy(__time, 'chem_prod_zakacka_bakteracid_fact'), 0),
                    chem_prod_zakacka_ingibator_korrozin_plan: _.round(_.sumBy(__time, 'chem_prod_zakacka_ingibator_korrozin_plan'), 0),
                    chem_prod_zakacka_ingibator_korrozin_fact: _.round(_.sumBy(__time, 'chem_prod_zakacka_ingibator_korrozin_fact'), 0),
                    chem_prod_zakacka_ingibator_soleotloj_plan: _.round(_.sumBy(__time, 'chem_prod_zakacka_ingibator_soleotloj_plan'), 0),
                    chem_prod_zakacka_ingibator_soleotloj_fact: _.round(_.sumBy(__time, 'chem_prod_zakacka_ingibator_soleotloj_fact'), 0),
                }))
                .value();

            let result = [];

            result.push(
                {
                    name:
                    // 'Деэмульгатор',
                        this.trans("visualcenter.chem_prod_zakacka_demulg_fact"),
                    code: 'chem_prod_zakacka_demulg_fact',
                    plan: chemistryData[0]['chem_prod_zakacka_demulg_plan'],
                    fact: chemistryData[0]['chem_prod_zakacka_demulg_fact'],
                    metricSystem: this.trans("visualcenter.chemistryMetricTon"),
                },
                {
                    name:
                    // 'Бактерицид',
                        this.trans("visualcenter.chem_prod_zakacka_bakteracid_fact"),
                    code: 'chem_prod_zakacka_bakteracid_fact',
                    plan: chemistryData[0]['chem_prod_zakacka_bakteracid_plan'],
                    fact: chemistryData[0]['chem_prod_zakacka_bakteracid_fact'],
                    metricSystem: this.trans("visualcenter.chemistryMetricTon"),
                },
                {
                    name:
                    // 'Ингибитор коррозии',
                        this.trans("visualcenter.chem_prod_zakacka_ingibator_korrozin_fact"),
                    code: 'chem_prod_zakacka_ingibator_korrozin_fact',
                    plan: chemistryData[0]['chem_prod_zakacka_ingibator_korrozin_plan'],
                    fact: chemistryData[0]['chem_prod_zakacka_ingibator_korrozin_fact'],
                    metricSystem: this.trans("visualcenter.chemistryMetricTon"),
                },
                {
                    name:
                    // 'Ингибитор солеотложения',
                        this.trans("visualcenter.chem_prod_zakacka_ingibator_soleotloj_fact"),
                    code: 'chem_prod_zakacka_ingibator_soleotloj_fact',
                    plan: chemistryData[0]['chem_prod_zakacka_ingibator_soleotloj_plan'],
                    fact: chemistryData[0]['chem_prod_zakacka_ingibator_soleotloj_fact'],
                    metricSystem: this.trans("visualcenter.chemistryMetricTon"),
                },
            )

            return result
        },

        getChemistryChartData(arr) {
            let chemistryData = _.groupBy(arr, item => {
                return moment(parseInt(item.__time)).format("YYYY-MM-DD")//.format('D')
            })

            let result = {}

            if (typeof chemistryData !== 'undefined') {
                for (let i in chemistryData) {
                    result[i] = {
                        chem_prod_zakacka_demulg_fact: _.round(_.sumBy(chemistryData[i], 'chem_prod_zakacka_demulg_fact'), 0),
                        chem_prod_zakacka_bakteracid_fact: _.round(_.sumBy(chemistryData[i], 'chem_prod_zakacka_bakteracid_fact'), 0),
                        chem_prod_zakacka_ingibator_korrozin_fact: _.round(_.sumBy(chemistryData[i], 'chem_prod_zakacka_ingibator_korrozin_fact'), 0),
                        chem_prod_zakacka_ingibator_soleotloj_fact: _.round(_.sumBy(chemistryData[i], 'chem_prod_zakacka_ingibator_soleotloj_fact'), 0),
                    }
                }
            }

            return result
        },
    },
    computed: {
        chemistryDataForChart() {
            let series = []
            let labels = []
            for (let i in this.chemistryChartData) {
                series.push(this.chemistrySelectedRow ? this.chemistryChartData[i][this.chemistrySelectedRow] : this.chemistryChartData[i]['chem_prod_zakacka_demulg_fact'])
                labels.push(i)
            }
            return {
                series: series,
                labels: labels
            }
        },
    },
}