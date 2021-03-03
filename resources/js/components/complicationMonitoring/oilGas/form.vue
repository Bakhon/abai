<template>
    <div class="col-xs-12 col-sm-12 col-md-12 row">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>{{ trans('monitoring.other_objects') }}</label>
            <div class="form-label-group">
                <select class="form-control" name="other_objects_id" v-model="formFields.other_objects_id"
                        v-show="otherObjects.length > 0">
                    <option v-for="row in otherObjects" v-bind:value="row.id">{{ row.name }}</option>
                </select>
            </div>
            <label>{{ trans('monitoring.gu.gu') }}</label>
            <div class="form-label-group">
                <select class="form-control" name="gu_id" v-model="formFields.gu_id" @change="chooseGu()">
                    <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
                </select>
            </div>
            <label>{{ trans('app.date_time') }}</label>
            <div class="form-label-group">
                <datetime
                    type="date"
                    v-model="formFields.date"
                    input-class="date form-control"
                    value-zone="Asia/Almaty"
                    zone="Asia/Almaty"
                    :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
                    :phrases="{ok: 'Выбрать', cancel: 'Выход'}"
                    :hour-step="1"
                    :minute-step="5"
                    :week-start="1"
                    use24-hour
                    auto
                >
                </datetime>
                <input type="hidden" name="date" v-model="formatedDate" class="form-control" placeholder="">

            </div>
            <label>{{ trans('monitoring.oil.fields.oil_viscosity_at_40') }}</label>
            <div class="form-label-group">
                <input
                    v-model="formFields.oil_viscosity_at_40"
                    type="number"
                    step="0.0001"
                    :min="validationParams.oil_viscosity_at_40.min"
                    :max="validationParams.oil_viscosity_at_40.max"
                    name="oil_viscosity_at_40"
                    class="form-control"
                    placeholder=""
                >
            </div>
            <label>{{ trans('monitoring.oil.fields.hydrogen_sulfide_in_gas') }}</label>
            <div class="form-label-group">
                <input
                    v-model="formFields.hydrogen_sulfide_in_gas"
                    type="number"
                    step="0.0001"
                    :min="validationParams.hydrogen_sulfide_in_gas.min"
                    :max="validationParams.hydrogen_sulfide_in_gas.max"
                    name="hydrogen_sulfide_in_gas"
                    class="form-control"
                    placeholder=""
                >
            </div>
            <label>{{ trans('monitoring.oil.fields.gas_density_at_20') }}</label>
            <div class="form-label-group">
                <input
                    v-model="formFields.gas_density_at_20"
                    type="number"
                    step="0.0001"
                    :min="validationParams.gas_density_at_20.min"
                    :max="validationParams.gas_density_at_20.max"
                    name="gas_density_at_20"
                    class="form-control"
                    placeholder=""
                >
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>{{ trans('monitoring.ngdu') }}</label>
            <div class="form-label-group">
                <select class="form-control" name="ngdu_id" v-model="formFields.ngdu_id" @change="chooseNgdu($event)">
                    <option v-for="row in ngdus" v-bind:value="row.id">{{ row.name }}</option>
                </select>
            </div>
            <label>{{ trans('monitoring.zu.zu') }}</label>
            <div class="form-label-group">
                <select class="form-control" name="zu_id" v-model="formFields.zu_id" @change="chooseZu()">
                    <option v-for="row in zus" v-bind:value="row.id">{{ row.name }}</option>
                </select>
            </div>
            <label>{{ trans('monitoring.oil.fields.water_density_at_20') }}</label>
            <div class="form-label-group">
                <input
                    v-model="formFields.water_density_at_20"
                    type="number"
                    step="0.0001"
                    :min="validationParams.water_density_at_20.min"
                    :max="validationParams.water_density_at_20.max"
                    name="water_density_at_20"
                    class="form-control"
                    placeholder=""
                >
            </div>
            <label>{{ trans('monitoring.oil.fields.oil_viscosity_at_50') }}</label>
            <div class="form-label-group">
                <input
                    v-model="formFields.oil_viscosity_at_50"
                    type="number"
                    step="0.0001"
                    :min="validationParams.oil_viscosity_at_50.min"
                    :max="validationParams.oil_viscosity_at_50.max"
                    name="oil_viscosity_at_50"
                    class="form-control"
                    placeholder=""
                >
            </div>
            <label>{{ trans('monitoring.oil.fields.oxygen_in_gas') }}</label>
            <div class="form-label-group">
                <input
                    v-model="formFields.oxygen_in_gas"
                    type="number"
                    step="0.0001"
                    :min="validationParams.oxygen_in_gas.min"
                    :max="validationParams.oxygen_in_gas.max"
                    name="oxygen_in_gas"
                    class="form-control"
                    placeholder=""
                >
            </div>
            <label>{{ trans('monitoring.oil.fields.gas_viscosity_at_20') }}</label>
            <div class="form-label-group">
                <input
                    v-model="formFields.gas_viscosity_at_20"
                    type="number"
                    step="0.0001"
                    :min="validationParams.gas_viscosity_at_20.min"
                    :max="validationParams.gas_viscosity_at_20.max"
                    name="gas_viscosity_at_20"
                    class="form-control"
                    placeholder=""
                >
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>{{ trans('monitoring.cdng') }}</label>
            <div class="form-label-group">
                <select class="form-control" name="cdng_id" v-model="formFields.cdng_id" @change="chooseCdng($event)">
                    <option v-for="row in cndgs" v-bind:value="row.id">{{ row.name }}</option>
                </select>
            </div>
            <label>{{ trans('monitoring.well.well') }}</label>
            <div class="form-label-group">
                <select class="form-control" name="well_id" v-model="formFields.well_id">
                    <option v-for="row in wells" v-bind:value="row.id">{{ row.name }}</option>
                </select>
            </div>
            <label>{{ trans('monitoring.oil.fields.oil_viscosity_at_20') }}</label>
            <div class="form-label-group">
                <input
                    v-model="formFields.oil_viscosity_at_20"
                    type="number"
                    step="0.0001"
                    :min="validationParams.oil_viscosity_at_20.min"
                    :max="validationParams.oil_viscosity_at_20.max"
                    name="oil_viscosity_at_20"
                    class="form-control"
                    placeholder=""
                >
            </div>
            <label>{{ trans('monitoring.oil.fields.oil_viscosity_at_60') }}</label>
            <div class="form-label-group">
                <input
                    v-model="formFields.oil_viscosity_at_60"
                    type="number"
                    step="0.0001"
                    :min="validationParams.oil_viscosity_at_60.min"
                    :max="validationParams.oil_viscosity_at_60.max"
                    name="oil_viscosity_at_60"
                    class="form-control"
                    placeholder=""
                >
            </div>
            <label>{{ trans('monitoring.oil.fields.carbon_dioxide_in_gas') }}</label>
            <div class="form-label-group">
                <input
                    v-model="formFields.carbon_dioxide_in_gas"
                    type="number"
                    step="0.0001"
                    :min="validationParams.carbon_dioxide_in_gas.min"
                    :max="validationParams.carbon_dioxide_in_gas.max"
                    name="carbon_dioxide_in_gas"
                    class="form-control"
                    placeholder=""
                >
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" :disabled="!formFields.date" class="btn btn-success">{{ trans('app.save') }}</button>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import {Datetime} from 'vue-datetime'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'
import {Settings} from 'luxon'
import moment from "moment";

Settings.defaultLocale = 'ru'

Vue.use(Datetime)

export default {
    name: "oilgas-form",
    props: [
        'oilgas',
        'validationParams'
    ],
    data: function () {
        return {
            otherObjects: {},
            ngdus: {},
            cndgs: {},
            gus: {},
            zus: {},
            wells: {},
            wbs: {},
            srb: {},
            hob: {},
            hb: {},
            datetimeEmpty: null,
            wbsmodel: null,
            srbmodel: null,
            hobmodel: null,
            hbmodel: null,
            formFields: {
                other_objects_id: null,
                gu_id: null,
                date: null,
                oil_viscosity_at_40: null,
                hydrogen_sulfide_in_gas: null,
                gas_density_at_20: null,
                ngdu_id: null,
                zu_id: null,
                water_density_at_20: null,
                oil_viscosity_at_50: null,
                oxygen_in_gas: null,
                gas_viscosity_at_20: null,
                cdng_id: null,
                well_id: null,
                oil_viscosity_at_20: null,
                oil_viscosity_at_60: null,
                carbon_dioxide_in_gas: null,
            }
        }
    },
    beforeCreate: function () {
        this.axios.get(this.localeUrl("/getotherobjects")).then((response) => {
            let data = response.data;
            if (data) {
                this.otherObjects = data.data;
            } else {
                console.log('No data');
            }
        });

        this.axios.get(this.localeUrl("/getngdu")).then((response) => {
            let data = response.data;
            if (data) {
                this.ngdus = data.data;
            } else {
                console.log('No data');
            }
        });

        this.axios.get(this.localeUrl("/getcdng")).then((response) => {
            let data = response.data;
            if (data) {
                this.cndgs = data.data;
            } else {
                console.log('No data');
            }
        });

        this.axios.get(this.localeUrl("/getwbs")).then((response) => {
            let data = response.data;
            if (data) {
                this.wbs = data.data;
            } else {
                console.log('No data');
            }
        });

        this.axios.get(this.localeUrl("/getsrb")).then((response) => {
            let data = response.data;
            if (data) {
                this.srb = data.data;
            } else {
                console.log('No data');
            }
        });

        this.axios.get(this.localeUrl("/gethob")).then((response) => {
            let data = response.data;
            if (data) {
                this.hob = data.data;
            } else {
                console.log('No data');
            }
        });

        this.axios.get(this.localeUrl("/gethb")).then((response) => {
            let data = response.data;
            if (data) {
                this.hb = data.data;
            } else {
                console.log('No data');
            }
        });

        this.axios.get(this.localeUrl("/getallgus")).then((response) => {
            let data = response.data;
            if (data) {
                this.gus = data.data;
            } else {
                console.log('No data');
            }
        });
    },
    computed: {
        formatedDate() {
            if (this.formFields.date) {
                return moment(this.formFields.date).format('YYYY-MM-DD HH:mm')
            }
            return null
        }
    },
    mounted() {

        if (this.oilgas) {
            this.formFields = {
                other_objects_id: this.oilgas.other_objects_id,
                gu_id: this.oilgas.gu_id,
                date: this.oilgas.date,
                oil_viscosity_at_40: this.oilgas.oil_viscosity_at_40,
                hydrogen_sulfide_in_gas: this.oilgas.hydrogen_sulfide_in_gas,
                gas_density_at_20: this.oilgas.gas_density_at_20,
                ngdu_id: this.oilgas.ngdu_id,
                zu_id: this.oilgas.zu_id,
                water_density_at_20: this.oilgas.water_density_at_20,
                oil_viscosity_at_50: this.oilgas.oil_viscosity_at_50,
                oxygen_in_gas: this.oilgas.oxygen_in_gas,
                gas_viscosity_at_20: this.oilgas.gas_viscosity_at_20,
                cdng_id: this.oilgas.cdng_id,
                well_id: this.oilgas.well_id,
                oil_viscosity_at_20: this.oilgas.oil_viscosity_at_20,
                oil_viscosity_at_60: this.oilgas.oil_viscosity_at_60,
                carbon_dioxide_in_gas: this.oilgas.carbon_dioxide_in_gas,
            }
            if(this.oilgas.gu_id) {
                this.chooseGu(true)
            }
            if(this.oilgas.zu_id) {
                this.chooseZu()
            }
        }

    },
    methods: {
        chooseGu(init = false) {
            this.axios.post(this.localeUrl("/getzu"), {
                gu_id: this.formFields.gu_id,
            }).then((response) => {
                let data = response.data;
                if (data) {
                    this.zus = data.data;
                    if(!init) {
                        this.formFields.well_id = null
                    }
                } else {
                    console.log('No data');
                }
            });

            this.axios.post(this.localeUrl("/getgucdngngdufield"), {
                gu_id: this.formFields.gu_id,
            }).then((response) => {
                let data = response.data;
                if (data) {
                    this.formFields.cdng_id = data.cdng;
                    this.formFields.ngdu_id = data.ngdu;
                } else {
                    console.log('No data');
                }
            });
        },
        chooseZu() {
            this.axios.post(this.localeUrl("/getwell"), {
                zu_id: this.formFields.zu_id,
            }).then((response) => {
                let data = response.data;
                if (data) {
                    this.wells = data.data;
                } else {
                    console.log('No data');
                }
            });
        },
    },
};
</script>
<style scoped>
.form-label-group {
    padding-bottom: 30px;
}
</style>
