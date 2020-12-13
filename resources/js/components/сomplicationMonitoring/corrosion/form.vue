<template>
    <div class="col-xs-12 col-sm-12 col-md-12 row">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>ГУ</label>
            <div class="form-label-group">
                <select class="form-control" name="gu_id" v-model="formFields.gu_id">
                    <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
                </select>
            </div>
            <label>Дата начала</label>
            <div class="form-label-group">
                <datetime
                    type="date"
                    v-model="formFields.start_date_of_background_corrosion"
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
                <input type="hidden" name="start_date_of_background_corrosion" v-bind:value="formatDate(formFields.start_date_of_background_corrosion)"
                       class="form-control" placeholder="">
            </div>
            <label>Дата начало замера скорости коррозии с реагентом</label>
            <div class="form-label-group">
                <datetime
                    type="date"
                    v-model="formFields.start_date_of_corrosion_velocity_with_inhibitor_measure"
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
                <input type="hidden" name="start_date_of_corrosion_velocity_with_inhibitor_measure"
                       v-bind:value="formatDate(formFields.start_date_of_corrosion_velocity_with_inhibitor_measure)" class="form-control" placeholder="">
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>НГДУ</label>
            <div class="form-label-group">
                <select class="form-control" name="ngdu_id" v-model="formFields.ngdu_id">
                    <option v-for="row in ngdus" v-bind:value="row.id">{{ row.name }}</option>
                </select>
            </div>
            <label>Дата окончания</label>
            <div class="form-label-group">
                <datetime
                    type="date"
                    v-model="formFields.final_date_of_background_corrosion"
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
                <input type="hidden" name="final_date_of_background_corrosion" v-bind:value="formatDate(formFields.final_date_of_background_corrosion)"
                       class="form-control" placeholder="">
            </div>
            <label>Дата окончания замера скорости коррозии с реагентом</label>
            <div class="form-label-group">
                <datetime
                    type="date"
                    v-model="formFields.final_date_of_corrosion_velocity_with_inhibitor_measure"
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
                <input type="hidden" name="final_date_of_corrosion_velocity_with_inhibitor_measure"
                       v-bind:value="formatDate(formFields.final_date_of_corrosion_velocity_with_inhibitor_measure)" class="form-control" placeholder="">
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>ЦДНГ</label>
            <div class="form-label-group">
                <select class="form-control" name="cdng_id" v-model="formFields.cdng_id">
                    <option v-for="row in cndgs" v-bind:value="row.id">{{ row.name }}</option>
                </select>
            </div>
            <label>Фоновая скорость</label>
            <div class="form-label-group">
                <input v-model="formFields.background_corrosion_velocity" type="number" step="0.0001"
                       name="background_corrosion_velocity" class="form-control" placeholder="">
            </div>
            <label>Скорость коррозии</label>
            <div class="form-label-group">
                <input v-model="formFields.corrosion_velocity_with_inhibitor" type="number" step="0.0001"
                       name="corrosion_velocity_with_inhibitor" class="form-control" placeholder="">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" :disabled="!formFields.start_date_of_background_corrosion" class="btn btn-success">Сохранить</button>
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
    name: "corrosion-form",
    props: [
        'corrosion'
    ],
    data: function () {
        return {
            ngdus: {},
            cndgs: {},
            gus: {},
            formFields: {
                gu_id: null,
                start_date_of_background_corrosion: null,
                start_date_of_corrosion_velocity_with_inhibitor_measure: null,
                ngdu_id: null,
                final_date_of_background_corrosion: null,
                final_date_of_corrosion_velocity_with_inhibitor_measure: null,
                cdng_id: null,
                background_corrosion_velocity: null,
                corrosion_velocity_with_inhibitor: null,
            }
        }
    },
    beforeCreate: function () {

        this.axios.get("/ru/getngdu").then((response) => {
            let data = response.data;
            if (data) {
                this.ngdus = data.data;
            } else {
                console.log('No data');
            }
        });

        this.axios.get("/ru/getcdng").then((response) => {
            let data = response.data;
            if (data) {
                this.cndgs = data.data;
            } else {
                console.log('No data');
            }
        });

        this.axios.get("/ru/getallgus").then((response) => {
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

        if (this.corrosion) {
            this.formFields = {
                gu_id: this.corrosion.gu_id,
                start_date_of_background_corrosion: this.corrosion.start_date_of_background_corrosion,
                start_date_of_corrosion_velocity_with_inhibitor_measure: this.corrosion.start_date_of_corrosion_velocity_with_inhibitor_measure,
                ngdu_id: this.corrosion.ngdu_id,
                final_date_of_background_corrosion: this.corrosion.final_date_of_background_corrosion,
                final_date_of_corrosion_velocity_with_inhibitor_measure: this.corrosion.final_date_of_corrosion_velocity_with_inhibitor_measure,
                cdng_id: this.corrosion.cdng_id,
                background_corrosion_velocity: this.corrosion.background_corrosion_velocity,
                corrosion_velocity_with_inhibitor: this.corrosion.corrosion_velocity_with_inhibitor,
            }
        }

    },
    methods: {
        formatDate(date) {
            if (date) {
                return moment(date).format('YYYY-MM-DD HH:mm')
            }
            return null
        }
    },
};
</script>
<style scoped>
.form-label-group {
    padding-bottom: 30px;
}
</style>
