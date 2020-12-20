<template>
    <div class="col-xs-12 col-sm-12 col-md-12 row">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>Месторождение</label>
            <div class="form-label-group">
                <select
                    class="form-control"
                    name="field_id"
                    v-model="formFields.field_id"
                >
                    <option v-for="row in fields" v-bind:value="row.id">
                        {{ row.name }}
                    </option>
                </select>
            </div>
            <label>ГУ</label>
            <div class="form-label-group">
                <select
                    class="form-control"
                    name="gu_id"
                    v-model="formFields.gu_id"
                    @change="chooseGu($event)"
                >
                    <option v-for="row in gus" v-bind:value="row.id">
                        {{ row.name }}
                    </option>
                </select>
            </div>
            <label> Дата и время </label>
            <div class="form-label-group">
                <datetime
                    type="datetime"
                    v-model="formFields.date"
                    input-class="form-control date"
                    value-zone="Asia/Almaty"
                    zone="Asia/Almaty"
                    :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
                    :phrases="{ok: 'Выбрать', cancel: 'Выход'}"
                    :hour-step="1"
                    :minute-step="5"
                    :week-start="1"
                    use24-hour
                    auto
                    @close="pick"
                >
                </datetime>
                <input type="hidden" name="date" v-bind:value="formatDate(formFields.date)">
            </div>
            <div class="form-label-group form-check">
                <input type="hidden" name="out_of_service_оf_dosing" value="0">
                <input
                    type="checkbox"
                    class="form-check-input"
                    name="out_of_service_оf_dosing"
                    id="out_of_service_оf_dosing"
                    value="1"
                    v-model="formFields.out_of_service_оf_dosing"
                />
                <label class="form-check-label" for="out_of_service_оf_dosing"
                >Простой дозатора, сутки</label
                >
            </div>
            <div class="form-label-group" v-show="formFields.out_of_service_оf_dosing">
                <label>Причина</label>
                <textarea v-model="formFields.reason" type="text" name="reason" class="form-control" placeholder="">
        </textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>НГДУ</label>
            <div class="form-label-group">
                <select
                    class="form-control"
                    name="ngdu_id"
                    v-model="formFields.ngdu_id"
                    @change="chooseNgdu($event)"
                >
                    <option v-for="row in ngdus" v-bind:value="row.id">
                        {{ row.name }}
                    </option>
                </select>
            </div>
            <label>ЗУ</label>
            <div class="form-label-group">
                <select
                    class="form-control"
                    name="zu_id"
                    v-model="formFields.zu_id"
                    @change="chooseZu($event)"
                >
                    <option v-for="row in zus" v-bind:value="row.id">
                        {{ row.name }}
                    </option>
                </select>
            </div>
            <label>Уровень</label>
            <div class="form-label-group">
                <input
                    type="hidden"
                    step="0.0001"
                    name="current_dosage"
                    class="form-control"
                    v-model="formFields.current_dosage"
                    placeholder="current dosage"
                />
                <input
                    :disabled="!formFields.gu_id && !formFields.date"
                    @change="inputLevel"
                    v-model="formFields.level"
                    type="number"
                    step="0.0001"
                    :min="validationParams.level.min"
                    :max="validationParams.level.max"
                    name="level"
                    class="form-control"
                    placeholder=""
                />
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>ЦДНГ</label>
            <div class="form-label-group">
                <select
                    class="form-control"
                    name="cdng_id"
                    v-model="formFields.cdng_id"
                    @change="chooseCdng($event)"
                >
                    <option v-for="row in cndgs" v-bind:value="row.id">
                        {{ row.name }}
                    </option>
                </select>
            </div>
            <label>Скважина</label>
            <div class="form-label-group">
                <select class="form-control" name="well_id" v-model="formFields.well_id">
                    <option v-for="row in wells" v-bind:value="row.id">
                        {{ row.name }}
                    </option>
                </select>
            </div>
            <label>Ингибитор</label>
            <div class="form-label-group">
                <select
                    class="form-control"
                    name="inhibitor_id"
                    v-model="formFields.inhibitor_id"
                >
                    <option v-for="row in inhibitors" v-bind:value="row.id">
                        {{ row.name }}
                    </option>
                </select>
            </div>
            <div class="form-label-group form-check">
                <input
                type="checkbox"
                class="form-check-input"
                name="fill_status"
                id="fill_status"
                v-model="formFields.fill_status"
                />
                <label class="form-check-label" for="fill_status">Заправка</label>
            </div>
            <div class="form-label-group" v-show="formFields.fill_status">
                <input
                type="number"
                step="0.0001"
                :min="validationParams.fill.min"
                :max="validationParams.fill.max"
                name="fill"
                v-model="formFields.fill"
                class="form-control"
                id="fill"
                placeholder=""
                />
                <label class="form-check-label" for="fill">Заправка</label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" :disabled="!formFields.date" class="btn btn-success">
                Сохранить
            </button>
        </div>
    </div>
</template>

<script>
import Vue from "vue";
import {Datetime} from "vue-datetime";
import "vue-datetime/dist/vue-datetime.css";
import {Settings} from "luxon";
import moment from "moment";

Settings.defaultLocale = "ru";

Vue.use(Datetime);

export default {
    name: "omguhe-form",
    props: [
        'omguhe',
        'validationParams'
    ],
    components: {
        Datetime
    },
    data: function () {
        return {
            ngdus: {},
            cndgs: {},
            gus: {},
            zus: {},
            wells: {},
            fields: {},
            inhibitors: {},
            out_of_service_оf_dosing: false,
            prevData: null,
            formFields: {
                field_id: null,
                ngdu_id: null,
                cdng_id: null,
                gu_id: null,
                zu_id: null,
                well_id: null,
                date: null,
                inhibitor_id: null,
                fill: null,
                level: null,
                out_of_service_оf_dosing: null,
                current_dosage: null,
                reason: null,
                fill_status: null
            }
        };
    },
    mounted() {
        if (this.omguhe) {
            this.formFields = {
                field_id: this.omguhe.field_id,
                ngdu_id: this.omguhe.ngdu_id,
                cdng_id: this.omguhe.cdng_id,
                gu_id: this.omguhe.gu_id,
                zu_id: this.omguhe.zu_id,
                well_id: this.omguhe.well_id,
                date: moment(new Date(this.omguhe.date)).toISOString(),
                inhibitor_id: this.omguhe.inhibitor_id,
                fill: this.omguhe.fill,
                level: this.omguhe.level,
                out_of_service_оf_dosing: this.omguhe.out_of_service_оf_dosing,
                current_dosage: this.omguhe.current_dosage,
                reason: this.omguhe.reason,
                fill_status: !!this.omguhe.fill,
            }
            if (this.formFields.ngdu_id) {
                this.chooseNgdu()
            }
            if (this.formFields.cdng_id) {
                this.chooseCdng()
            }
            if (this.formFields.gu_id) {
                this.chooseGu()
            }
            if (this.formFields.zu_id) {
                this.chooseZu()
            }
        }
    },
    methods: {
        chooseNgdu() {
            this.axios
                .get("/ru/getcdng", {
                    ngdu_id: this.formFields.ngdu_id,
                })
                .then((response) => {
                    let data = response.data;
                    if (data) {
                        this.cndgs = data.data;
                    } else {
                        console.log("No data");
                    }
                });
        },
        chooseCdng() {
            this.axios
                .post("/ru/getgu", {
                    cdng_id: this.formFields.cdng_id,
                })
                .then((response) => {
                    let data = response.data;
                    if (data) {
                        this.gus = data.data;
                    } else {
                        console.log("No data");
                    }
                });
        },
        chooseGu() {
            this.axios
                .post("/ru/getzu", {
                    gu_id: this.formFields.gu_id,
                })
                .then((response) => {
                    let data = response.data;
                    if (data) {
                        this.zus = data.data;
                    } else {
                        console.log("No data");
                    }
                });

            this.axios
                .post("/ru/getgucdngngdufield", {
                    gu_id: this.formFields.gu_id,
                })
                .then((response) => {
                    let data = response.data;
                    if (data) {
                        this.formFields.cdng_id = data.cdng;
                        this.formFields.ngdu_id = data.ngdu;
                    } else {
                        console.log("No data");
                    }
                });
        },
        chooseZu() {
            this.axios
                .post("/ru/getwell", {
                    zu_id: this.formFields.zu_id,
                })
                .then((response) => {
                    let data = response.data;
                    if (data) {
                        this.wells = data.data;
                    } else {
                        console.log("No data");
                    }
                });
        },
        pick() {
            this.axios
                .post("/ru/getprevdaylevel", {
                    gu_id: this.formFields.gu_id,
                    date: this.formFields.date,
                })
                .then((response) => {
                    let data = response.data;
                    if (data) {
                        this.prevData = data;
                    } else {
                        this.prevData = null;
                    }
                });
        },
        inputLevel() {
            if (this.prevData != null) {
                this.formFields.current_dosage = this.prevData - this.formFields.level;
            }
        },
        formatDate(date) {
            return moment(date).format('YYYY-MM-DD HH:MM:SS')
        }
    },
    beforeCreate: function () {
        this.axios.get("/ru/getfields").then((response) => {
            let data = response.data;
            if (data) {
                this.fields = data.data;
            } else {
                console.log('No data');
            }
        });

        this.axios.get("/ru/getngdu").then((response) => {
            let data = response.data;
            if (data) {
                this.ngdus = data.data;
            } else {
                console.log("No data");
            }
        });

        this.axios.get("/ru/getcdng").then((response) => {
            let data = response.data;
            if (data) {
                this.cndgs = data.data;
            } else {
                console.log("No data");
            }
        });

        this.axios.get("/ru/getallgus").then((response) => {
            let data = response.data;
            if (data) {
                this.gus = data.data;
            } else {
                console.log("No data");
            }
        });

        this.axios.get("/ru/getinhibitors").then((response) => {
            let data = response.data;
            if (data) {
                this.inhibitors = data.data;
            } else {
                console.log("No data");
            }
        });
    },
};
</script>
<style scoped>
.form-label-group {
    padding-bottom: 30px;
}
</style>
