import {pgnoMapState, pgnoMapGetters, pgnoMapMutations, pgnoMapActions} from '@store/helpers';

export default {
    data: function () {
        return {
            case1: null,
            case2: null,
            settings: {},
            options: [
                {value: null, text: 'Выберите параметр', unit: " "},
                {value: 'tub_ID', text: this.trans('pgno.nkt'), unit: this.trans('measurements.mm')},
                {value: 'whp', text: this.trans('pgno.p_buf'), unit: this.trans('measurements.atm')},
                {value: 'wct', text: this.trans('pgno.obvodnenost'), unit: this.trans('measurements.percent')},
                {value: 'gor', text: this.trans('pgno.gf_s'), unit: this.trans('measurements.m3/t')},
                {value: 'p_res', text: this.trans('pgno.p_pl'), unit: this.trans('measurements.atm')},
                {value: 'pi', text: this.trans('pgno.k_prod'), unit: this.trans('measurements.m3/d/atm')},
            ],

        }
    },
    computed: {
        ...pgnoMapState([
            'sensetiveSettings',
        ]),
        filterFirstOptions() {
            return this.options.filter((obj, i) => {
                return obj.value !== this.settings.option1.name
            });
        },
        filterSecondOptions() {
            var result1 = this.options.filter((obj, i) => {
                return obj.value !== this.settings.option1.name
            });
            return result1.filter((obj, i) => {
                return obj.value !== this.settings.option2.name
            });
        }
    },
    methods: {
        ...pgnoMapActions([
            'setSensetiveSettings'
        ]),
        setNotify(message, title, type) {
            this.$bvToast.toast(message, {
                title: title,
                variant: type,
                solid: true,
                toaster: "b-toaster-top-center",
                autoHideDelay: 8000,
            });
        },
        checkCase(val) {
            if (val === 1 && !this.settings.option1.name) {
                this.settings.option1 = {
                    name: null,
                    value1: null,
                    value2: null,
                    value3: null,
                },
                    this.settings.option2 = {
                        name: null,
                        value1: null,
                        value2: null,
                        value3: null,
                    },
                    this.settings.option3 = {
                        name: null,
                        value1: null,
                        value2: null,
                        value3: null,
                    }
            } else if (val === 2 && !this.settings.option2.name) {
                this.settings.option2 = {
                    name: null,
                    value1: null,
                    value2: null,
                    value3: null,
                },
                    this.settings.option3 = {
                        name: null,
                        value1: null,
                        value2: null,
                        value3: null,
                    }
            } else if (val === 3 && !this.settings.option3.name) {
                this.settings.option3 = {
                    name: null,
                    value1: null,
                    value2: null,
                    value3: null,
                }
            }
        },
        getUnit(value) {
            var result = this.options.find(obj => {
                return obj.value === value
            })
            return result.unit
        },
        postSelectedValues() {
            if (!this.settings.option1.name) {
                this.setNotify("Выберите хотя бы 1 параметр", "Error", "danger")
                return
            }
            this.setSensetiveSettings(this.settings)
            this.$emit('clicked', "settings")
        }
    },
    created: function () {
        this.settings = _.cloneDeep(this.sensetiveSettings)
    }
}