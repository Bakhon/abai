import download from "downloadjs";

export default {
    components: {},
    data() {
        return {
            file: '',
            experimentId: null,
            statisticsInput: {
                experimentId: null,
                mnemonics: [],
            },
            experimentStatistics: null,
            experimentsId: null,
            wellId: null,
            input: {
                well: null,
                field: null,
                comment: null,
                filename: null,
                provenanceId: null,
            },
            baseUrl: 'http://172.20.103.187:8083/',
            experimentInfo: null,
            selectedExperimentsInfo: null,
            loadProvenance: null,
            provenances: null,
            isLoading: false,
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
            }).catch((error) => console.log(error));
        },
        handleFileUpload() {
            this.file = this.$refs.file.files[0];
        },
        submitFile() {
            let formData = new FormData();
            formData.append('file', this.file)

            this.$store.commit('globalloading/SET_LOADING', true);
            this.experimentsId = null;
            this.axios.post(this.baseUrl + 'upload/', formData, {
                responseType: 'json',
                params: {
                    well: this.input.well,
                    field: this.input.field,
                    comment: this.input.comment,
                    filename: this.input.filename,
                    provenance_id: this.input.provenanceId
                },
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                if (response.data) {
                    this.experimentsId = response.data.experiments_id
                }
            }).catch((error) => console.log(error)
            ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));


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
                }
            }).catch((error) => console.log(error)
            ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));

        },
        getOriginalLas(experimentsInfo) {
            let content = JSON.stringify({
                experiments_id: experimentsInfo.id,
                filename: experimentsInfo.filename
            })
            this.axios.post(
                this.baseUrl + 'static/experiment_input_file/',
                content,
                {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
            ).then((response) => {
                if (response.data) {
                    let content = response.headers['content-type']
                    download(response.data, experimentsInfo.filename, content)
                }
            }).catch((error) => console.log(error)
            ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));
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
    }
}
