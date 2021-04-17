export const chartInitMixin = {
    props: {
        data: {
            required: true,
            type: Object
        }
    },
    data: () => ({
        series: [],
    }),
    mounted() {
        this.init()
    },
    methods: {
        init() {
            this.series = [
                {
                    name: 'Рентабельные скважины',
                    data: this.data.profitable
                }, {
                    name: 'Условно-рентабельные скважины',
                    data: this.data.profitless_cat_2
                }, {
                    name: 'Нерентабельные скважины',
                    data: this.data.profitless_cat_1
                }
            ];

            this.chartOptions = {labels: this.data.dt};
        },
    },
}