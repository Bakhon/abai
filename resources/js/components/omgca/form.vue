<template>
    <div class="col-xs-12 col-sm-12 col-md-12 row">
        <notifications></notifications>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>Год</label>
            <div class="form-label-group">
                <select class="form-control" name="date" v-model="fields.year" @change="checkDublicate"
                        v-show="years.length > 0">
                    <option v-for="row in years" v-bind:value="row.id">{{ row.name }}</option>
                </select>
            </div>
            <label>Qв, тыс.м³/год</label>
            <div class="form-label-group">
                <input type="number" step="0.0001" name="q_v" v-model="fields.q_v" class="form-control" placeholder="">
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>ГУ</label>
            <div class="form-label-group">
                <select class="form-control" name="gu_id" v-model="fields.gu" @change="checkDublicate">
                    <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>Планируемая дозировка, г/м3</label>
            <div class="form-label-group">
                <input type="number" step="0.0001" name="plan_dosage" v-model="fields.plan_dosage" class="form-control"
                       placeholder="">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" :disabled="!fields.year || !fields.gu || dublicate" class="btn btn-success">
                Сохранить
            </button>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import moment from "moment";

// You need a specific loader for CSS files
import {Settings} from 'luxon'
import NotifyPlugin from "vue-easy-notify";

Settings.defaultLocale = 'ru'


Vue.use(NotifyPlugin)

export default {
    name: "omgca-form",
    props: [
        'omgca'
    ],
    data: function () {
        return {
            otherObjects: {},
            gus: {},
            years: [],
            gu: null,
            dublicate: false,
            fields: {
                year: null,
                q_v: null,
                gu: null,
                plan_dosage: null
            }
        }
    },
    beforeCreate: function () {
        this.axios.get("/ru/getallgus").then((response) => {
            let data = response.data;
            if (data) {
                this.gus = data.data;
            } else {
                console.log('No data');
            }
        });
    },
    mounted() {
        if (this.omgca) {
            this.fields = {
                year: this.omgca.date,
                q_v: this.omgca.q_v,
                gu: this.omgca.gu_id,
                plan_dosage: this.omgca.plan_dosage
            }
        }

        for(let i = 0; i < 5; i++) {
            let year = moment().startOf('year').add(i, 'years')
            this.years.push(
                {"id": year.format('YYYY-MM-DD'), "name": year.format('YYYY')}
            )
        }
    },
    methods: {
        checkDublicate() {
            if (this.fields.gu != null && this.fields.year != null) {
                this.axios.post("/ru/checkdublicateomgddng", {
                    id: this.omgca.id || null,
                    gu: this.fields.gu,
                    dt: this.fields.year,
                }).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.dublicate = false;
                    } else {
                        this.$notifyInfo("На эту дату по этому ГУ уже есть информация!");
                        this.dublicate = true;
                    }
                });
            }
        }
    },
};
</script>
<style scoped>
.form-label-group {
    padding-bottom: 30px;
}

.form-label-group2 {
    padding-bottom: 39px;
}
</style>
