import las from './mixins/las'

export default {
    mixins: [las],
    props: [
        'params'
    ],
    components: {},
    data() {
        return {
            statisticsInput: {
                experimentId: null,
                mnemonics: [],
            },
            experimentStatistics: null,
            wellId: null,
            experimentInfo: null,
            selectedExperimentsInfo: null,
            loadProvenance: null,
            provenances: null,
            permissionName: 'bigdata load_las',
            hasPermission: false,
        }
    },
    mounted: function () {
        this.$nextTick(function () {
            this.$store.commit('globalloading/SET_LOADING', false);
        });
        this.loadProvenances();
    },
    methods: {
        loadProvenances() {
            let uri = this.baseUrl + "origins/";
            this.isLoading = true
            this.axios.get(uri, {
                responseType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                if (response.data) {
                    this.provenances = response.data
                } else {
                    console.log("No data");
                }
                this.isLoading = false;
            }).catch((error) => {
                console.log(error)
                this.isLoading = false
            });
        },
        fetchStatistics() {
            this.$store.commit('globalloading/SET_LOADING', true);
            this.experimentStatistics = null;
            this.axios.get(
                this.baseUrl + 'experiment_stats/' + this.statisticsInput.experimentId
            ).then((response) => {
                if (response.data) {
                    this.experimentStatistics = response.data;
                }
            }).catch((error) => console.log(error)
            ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));

        },
        fetchExperiments() {
            this.$store.commit('globalloading/SET_LOADING', true);
            this.experimentInfo = null;
            this.axios.get(
                this.baseUrl + 'experiment/' + this.experimentId
            ).then((response) => {
                if (response.data) {
                    this.experimentInfo = response.data;
                    this.formatCurveValues();
                }
            }).catch((error) => console.log(error)
            ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));

        },
        formatCurveValues() {
            let content = this.experimentInfo.curves;

            for(let i = 0; i < content.length; i++) {
                for(let j = 0; j < content[i].curve.length; j++) {
                    // Check string value is a number
                    if(isNaN(content[i].curve[j]) || content[i].curve[j].indexOf('.') == -1) continue;

                    // Precision up to 3 digits after the dot
                    content[i].curve[j] = parseFloat(content[i].curve[j]).toFixed(3);
                }
            }

            this.experimentInfo.curves = content;
        },
        selectExperiments() {
            this.$store.commit('globalloading/SET_LOADING', true);
            this.selectedExperimentsInfo = null;
            this.axios.get(
                this.baseUrl + 'experiments/well/' + this.wellId,
            ).then((response) => {
                if (response.data) {
                    this.selectedExperimentsInfo = response.data;
                }
            }).catch((error) => console.log(error)
            ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));
        }
    },
    created() {
        this.hasPermission = this.params.includes(this.permissionName);
    }
}
