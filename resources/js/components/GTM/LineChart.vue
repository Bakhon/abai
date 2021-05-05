<script>
import { Line } from 'vue-chartjs'

export default {
    extends: Line,
    props: {
        chartdata: {
            type: Object,
            default: null
        },
        options: {
            type: Object,
            default: null
        }
    },
    methods: {
        renderLineChart: function () {
            this.renderChart(this.chartdata, this.options);
        }
    },
    watch: {
        chartdata: function () {
            this.renderLineChart();
        }
    },
    mounted () {
        this.renderLineChart();
    },
}
</script>