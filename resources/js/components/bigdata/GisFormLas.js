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
                'file_format',
                'file_status',
                'recording_state'
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
            this.axios.get(this.localeUrl(`/api/bigdata/wells/${this.wellId}`)).then(response => {
                console.log(response)
            })
        }
    },
}