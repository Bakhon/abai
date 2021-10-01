import las from './mixins/las'
import {bdFormActions} from '@store/helpers'

export default {
    mixins: [las],
    props: [
        'formParams',
        'wellId'
    ],
    components: {},
    data() {
        return {
            input: {
                well: this.wellId,
                filename: {
                    stemSection: 'OH',
                },
            },
            dictionaries: [
                'file_origin',
                'geo_type_field',
                'stem_type',
                'recording_method',
                'file_type',
                'file_status',
                'recording_state',
                'las_mnemonics'
            ],
            well: null
        }
    },
    mounted() {
        this.loadDictionaries()
        this.loadWell()
    },
    methods: {
        ...bdFormActions([
            'loadDict'
        ]),
        async loadDictionaries() {
            this.SET_LOADING(true)
            let promises = this.dictionaries.map(async (code) => {
                if (this.getDict(code)) return
                this.loadDict(code).then(() => {
                    this.$forceUpdate()
                })
            })

            await Promise.all(promises).then(() => {
                this.SET_LOADING(false)
            })
        },
        getDict(code) {
            return this.$store.getters['bdform/dict'](code);
        },
        loadWell() {
            this.axios.get(this.localeUrl(`/api/bigdata/las/wells/${this.wellId}`)).then(response => {
                this.well = response.data.well
                this.input.filename.well = this.well.uwi
                this.input.filename.field = response.data.field.name_ru
            })
        },
        saveExperiment() {
            this.submitFileParams().then(result => {
                this.axios.post(this.localeUrl('/api/bigdata/las/gis'), {
                    experiment_id: result.id,
                    filename: result.filename,
                    well_id: this.well.id
                })
            })
        }
    },
}