import download from "downloadjs";
import moment from 'moment';
import {Datetime} from 'vue-datetime';
import Vue from "vue";
import {globalloadingMutations} from '@store/helpers'

Vue.use(Datetime)

export default {
    data() {
        return {
            files: [],
            currentFileInfoNum: 0,
            isFilesUploadedOnPreApproval: false,
            isLastFileProcessed: false,
            experimentId: null,
            dateFormat: 'DDMMYY',
            localization: 'ru',
            filenameParameters: null,
            filenameDelimiter: '_',
            recordingDepthDelimiter: '-',
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

            baseUrl: process.env.MIX_MICROSERVICE_GEO_DATA,
            isLoading: false
        }
    },
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        handleFileUpload() {
            this.files = this.$refs.file.files;
        },
        submitFiles() {
            let formData = new FormData();
            this.resetInternalVariablesOfFileUpload();
            for (let i = 0; i < this.files.length; i++) {
                formData.append('files', this.files[i])
            }

            this.SET_LOADING(true)
            this.axios.post(this.baseUrl + 'upload/', formData, {
                responseType: 'json',
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                if (response.data) {
                    this.filenameParameters = response.data
                    this.setExperimentFileParameters()
                    this.isFilesUploadedOnPreApproval = true
                }
            }).catch((error) => console.log(error)
            ).finally(() => this.SET_LOADING(false));
        },
        resetInternalVariablesOfFileUpload() {
            this.isLastFileProcessed = false
            this.currentFileInfoNum = 0
            this.isFilesUploadedOnPreApproval = false
            this.filenameParameters = null
        },
        async submitFileParams() {
            this.SET_LOADING(true)

            let jsonData = JSON.stringify({
                well: this.input.well,
                field: this.input.field,
                comment: this.input.comment,
                filename: this.filenameByParameters,
                provenanceId: this.input.provenanceId,
                experimentIdToApprove: this.filenameParameters.specific[this.currentFileInfoNum]['futureExperimentId'],
            })
            this.setExperimentUserFileName()
            return this.axios.post(this.baseUrl + 'approve-upload/', jsonData, {
                responseType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                if (response.data) {
                    this.setExperimentId(response.data.experimentId)
                    this.resetFileUploadFields()
                    this.setNextExperimentInfo()
                    return {
                        id: response.data.experimentId,
                        filename: this.filenameByParameters
                    }
                }
            }).catch((error) => console.log(error)
            ).finally(() => this.SET_LOADING(false));
        },
        setExperimentId(experimentId) {
            this.filenameParameters.specific[this.currentFileInfoNum]['experimentId'] = experimentId
        },
        resetFileUploadFields() {
            this.input.filename.mnemonics = []
            this.input.filename.well = ''
        },
        setExperimentUserFileName() {
            this.filenameParameters.specific[this.currentFileInfoNum]['userFilename'] = this.filenameByParameters
        },
        setNextExperimentInfo() {
            if (this.currentFileInfoNum >= this.files.length - 1) {
                this.isLastFileProcessed = true
                return
            }
            this.currentFileInfoNum += 1
            this.setExperimentFileParameters()
        },
        setExperimentFileParameters() {
            let experiment = this.filenameParameters.specific[this.currentFileInfoNum]
            if ('experimentId' in experiment && experiment['experimentId'] !== null) {
                this.setNextExperimentInfo()
                return
            }
            this.input.filename.recordingDepth = experiment.recordingDepths[0] + this.recordingDepthDelimiter + experiment.recordingDepths[1]
            this.input.field = experiment.field
            this.input.well = experiment.well
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
            ).finally(() => this.SET_LOADING(false));
        },
        getInputForFilename(field) {
            let content = this.input.filename[field]
            if (field === 'date') {
                return this.formatDate(content)
            }
            if ((_.isArray(content) && content.length === 0) || (content === '')) {
                return this.input.defaultsForFilename[field]
            }
            if (field === 'recordingDepth') {
                return this.input.filename.recordingDepth.replaceAll(
                    this.recordingDepthDelimiter, this.filenameDelimiter
                )
            }
            return content
        },
        formatDate(date) {
            if (date === '') {
                return date
            }
            return moment.parseZone(this.input.filename['date']).format(this.dateFormat)
        },
        getDelimeterForFilename(index) {
            if (index !== 0 && index !== (this.filenameParametersForName.length - 1)) {
                return this.filenameDelimiter
            }
            if (index == (this.filenameParametersForName.length - 1)) {
                return '.'
            }
            return ''
        },
        getLocalizedParameterName(parameter) {
            if (parameter[this.localization] !== '') {
                return parameter[this.localization]
            }
            if (parameter['ru'] !== '') {
                return parameter['ru']
            }
            return parameter['value']
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
        },
        isInputFilledFieldsForFileUpload() {
            for (let i = 0; i < this.filenameParametersForName.length; i++) {
                let inputField = this.filenameParametersForName[i]
                let inputContent = this.input.filename[inputField]
                if (_.isArray(inputContent) && inputContent.length === 0) {
                    return false
                }
                if (inputContent === '') {
                    return false
                }
            }
            return true
        },
        refreshGenericUploadParams() {

            let uri = this.baseUrl + "generic_upload_params/";
            this.SET_LOADING(true)
            this.axios.get(uri, {
                responseType: 'json',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then((response) => {
                if (response.data) {
                    this.filenameParameters.generic = response.data
                    this.setExperimentFileParameters()
                }
            }).catch((error) => console.log(error)
            ).finally(() => this.SET_LOADING(false));
        }
    }
}