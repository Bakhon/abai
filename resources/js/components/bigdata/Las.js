import download from "downloadjs";
import {Datetime} from 'vue-datetime';
import Vue from "vue";

Vue.use(Datetime)

export default {
    components: {},
    data() {
        return {
            files: [],
            currentFileInfo: 0,
            isFilesUploadedOnPreApproval: false,

            experimentId: null,
            experimentIds: [],
            statisticsInput: {
                experimentId: null,
                mnemonics: [],
            },
            experimentStatistics: null,
            experimentsId: null,
            wellId: null,
            filenameParameters: {
                generic: {
                    fields: ['Месторождение1', 'Месторождение2', 'Месторождение3'],
                    wells: ['Скважина1', 'Скважина2', 'Скважина3', 'Скважина4'],
                    extensions: ['las', 'lis', 'dlis', 'ascii', 'txt'],
                    stemTypes: ['ST1', 'ST2'],
                    stemSections: ['OH', 'CH', 'NON'],
                    recordingMethods: ['LWD', 'WL'],
                    fileStatuses: ['RAW', 'FIN', 'INT', 'UNK'],
                    recordingStates: ['MAIN', 'RPT'],
                },
                specific: [{
                    mnemonics: ['DEPTH', 'AUS', 'TOX'],
                    recordingDepths: [100, 1500],
                }, {
                    mnemonics: ['DEPTH', 'AUS', 'TOX'],
                    recordingDepths: [100, 1500],
                }, {
                    mnemonics: ['DEPTH', 'AUS', 'TOX'],
                    recordingDepths: [100, 1500],
                }


                ]
            },
            filenameDelimiter: '_',
            filenameParametersForName: [
                'field', 'well', 'stemType', 'stemSection', 'recordingMethod',
                'mnemonics', 'date', 'fileStatus', 'recordingDepth',
                'recordingState', 'extension'
            ],
            input: {
                well: null,
                field: null,
                comment: null,
                provenanceId: '',
                filename: {
                    name: '',
                    field: '',
                    well: '',
                    stemType: '',
                    stemSection: '',
                    recordingMethod: '',
                    mnemonics: [],
                    date: '',
                    fileStatus: '',
                    recordingDepth: '',
                    extension: '',
                    recordingState: '',
                },
                defaultsForFilename: {
                    field: '<Месторождение>',
                    well: '<Скважина>',
                    stemType: '<Наименование Ствола>',
                    stemSection: '<Секция Ствола>',
                    recordingMethod: '<Технология Записи>',
                    mnemonics: '<Мнемоники>',
                    date: '<Дата>',
                    fileStatus: '<Статус Обработки>',
                    recordingDepth: '<Глубина Записи>',
                    recordingState: '<Тип Записи>',
                    extension: '<Расширение>',
                },
            },

            // baseUrl: 'http://172.20.103.187:8083/',
            baseUrl: 'http://127.0.0.1:8091/',
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
            }).catch((error) => {
                console.log(error)
                this.provenances = [{'id': 0, 'origin': 'fake1'}, {'id': 1, 'origin': 'fake2'},]
                this.isLoading = false

            });
        },
        handleFileUpload() {
            this.files = this.$refs.file.files;
            console.log(this.files);
        },
        submitFile() {
            let formData = new FormData();
            for (let i = 0; i < this.files.length; i++) {
                formData.append('files', this.files[i])
            }

            this.$store.commit('globalloading/SET_LOADING', true);
            this.experimentsId = null;
            this.axios.post(this.baseUrl + 'upload/', formData, {
                responseType: 'json',
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                if (response.data) {
                    this.experimentsId = response.data.experiments_id
                    this.setExperimentFileParameters()
                    this.isFilesUploadedOnPreApproval = true
                }
            }).catch((error) => console.log(error)
            ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));
        },
        submitFileParams() {
            this.$store.commit('globalloading/SET_LOADING', true);

            let jsonData = JSON.stringify({
                well: this.input.well,
                field: this.input.field,
                comment: this.input.comment,
                filename: this.input.filename,
                provenance_id: this.input.provenanceId
            });
            this.axios.post(this.baseUrl + 'approve-upload/', jsonData, {
                responseType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                if (response.data) {
                    this.experimentIds.push(response.data.experiments_id);
                    this.updateExperimentInfo()
                }
            }).catch((error) => console.log(error)
            ).finally(() => this.$store.commit('globalloading/SET_LOADING', false));
        },
        updateExperimentInfo() {
            if (this.currentFileInfo > this.files.length - 1) {
                return
            }
            this.currentFileInfo += 1
            this.setExperimentFileParameters()
        },
        setExperimentFileParameters() {
            let experiment = this.filenameParameters.specific[this.currentFileInfo]
            this.input.filename.recordingDepth = experiment.recordingDepths[0] + this.filenameDelimiter + experiment.recordingDepths[1]
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
        },
        getInputForFilename(field) {
            let content = this.input.filename[field]
            if ((_.isArray(content) && content.length === 0) || (content === '')) {
                return this.input.defaultsForFilename[field]
            }
            return content
        },
        getDelimeterForFilename(index) {
            if (index !== 0 && index !== (this.filenameParametersForName.length - 1)) {
                return this.filenameDelimiter
            }
            if (index == (this.filenameParametersForName.length - 1)) {
                return '.'
            }
            return ''
        }
    },
    computed: {
        filenameByParameters() {
            let filename = ''
            for (let i = 0; i < this.filenameParametersForName.length; i++) {
                filename += this.getDelimeterForFilename(i)
                let inputField = this.filenameParametersForName[i]
                let inputContent = this.getInputForFilename(inputField)
                if (_.isArray(inputContent)) {
                    filename += inputContent.join(this.filenameDelimiter)
                    continue
                }
                filename += inputContent
            }
            return filename
        }
    }
}
