<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label >Месторождение</label>
        <div class="form-label-group">
            <select class="form-control"  name="field" v-model="field" v-show="fields.length > 0">
            <option v-for="row in fields" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>ГУ</label>
        <div class="form-label-group">
            <select class="form-control"  name="gu_id" v-model="gu" @change="chooseGu($event)">
            <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>
            Дата и время

        </label>
        <div class="form-label-group2">
        <datetime
        type="date" v-model="datetimeEmpty" input-class="date"
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
        <input type="hidden" name="date" v-model="datetimeEmpty" class="form-control" placeholder="">

        </div>
        <label>Давление на выходе насоса в ГУ, бар</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="pump_discharge_pressure" class="form-control" placeholder="">
        </div>
        <label>Обводненность в ГУ, %</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="bsw" class="form-control" placeholder="">
        </div>
        <label>Суточная добыча жидкости в кормассе, м3/сут</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="daily_fluid_production_kormass" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label>НГДУ</label>
        <div class="form-label-group">
            <select class="form-control"  name="ngdu_id" v-model="ngdu" @change="chooseNgdu($event)">
            <option v-for="row in ngdus" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>ЗУ</label>
        <div class="form-label-group">
            <select class="form-control"  name="zu_id" v-model="zu" @change="chooseZu($event)">
            <option v-for="row in zus" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>Суточная добыча  жидкости в ГУ, м3/сут</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="daily_fluid_production" class="form-control" placeholder="">
        </div>
        <label>Температура на входе в печь в ГУ, С</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="heater_inlet_pressure" class="form-control" placeholder="">
        </div>
        <label>Давление в кормассе, бар</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="pressure" class="form-control" placeholder="">
        </div>
        <label>Кормасс</label>
        <div class="form-label-group">
            <select class="form-control"  name="kormass_number" v-model="kormass_id">
            <option v-for="row in kormass" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label>ЦДНГ</label>
        <div class="form-label-group">
            <select class="form-control"  name="cdng_id" v-model="cdng" @change="chooseCdng($event)">
            <option v-for="row in cndgs" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>Скважина</label>
        <div class="form-label-group">
            <select class="form-control"  name="well_id" v-model="well">
            <option v-for="row in wells" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>Давление в буферной емкости в ГУ, бар</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="surge_tank_pressure" class="form-control" placeholder="">
        </div>
        <label>Температура на выходе из печи в ГУ, С</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="heater_output_pressure" class="form-control" placeholder="">
        </div>
        <label>Температура в кормассе</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="temperature" class="form-control" placeholder="">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" :disabled="!datetimeEmpty" class="btn btn-success">Сохранить</button>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import { Datetime } from 'vue-datetime'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'
import { Settings } from 'luxon'

Settings.defaultLocale = 'ru'

Vue.use(Datetime)

export default {
    name: "wm-create",
    methods: {
        chooseNgdu(event){
            this.axios.post("/ru/getcdng", {
                ngdu_id: event.target.value,
            }).then((response) => {
                let data = response.data;
                if(data) {
                    this.cndgs = data.data;
                }
                else {
                    console.log('No data');
                }
            });
        },
        chooseCdng(event){
            this.axios.post("/ru/getgu", {
                cdng_id: event.target.value,
            }).then((response) => {
                let data = response.data;
                if(data) {
                    this.gus = data.data;
                }
                else {
                    console.log('No data');
                }
            });
        },
        chooseGu(event){
            this.well = null,
            this.axios.post("/ru/getzu", {
                gu_id: event.target.value,
            }).then((response) => {
                let data = response.data;
                if(data) {
                    this.zus = data.data;
                }
                else {
                    console.log('No data');
                }
            });

            this.axios.post("/ru/getgucdngngdufield", {
                gu_id: event.target.value,
            }).then((response) => {
                let data = response.data;
                if(data) {
                    this.cdng = data.cdng;
                    this.ngdu = data.ngdu;
                    this.kormass_id = data.kormass;
                }
                else {
                    console.log('No data');
                }
            });
        },
        chooseZu(event){
            this.axios.post("/ru/getwell", {
                zu_id: event.target.value,
            }).then((response) => {
                let data = response.data;
                if(data) {
                    this.wells = data.data;
                }
                else {
                    console.log('No data');
                }
            });
        }
  },
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
        fields: [
            {"id":"1", "name" : "Узень"},
            {"id":"2", "name" : "Карамандыбас"}
        ],
        ngdu: null,
        cdng: null,
        gu: null,
        zu: null,
        well: null,
        datetimeEmpty: null,
        wbsmodel: null,
        srbmodel: null,
        hobmodel: null,
        hbmodel: null,
        kormass: null,
        kormass_id: null,
        field: null
    }
  },
  beforeCreate: function () {

    this.axios.get("/ru/getngdu").then((response) => {
        let data = response.data;
        if(data) {
            this.ngdus = data.data;
        }
        else {
            console.log('No data');
        }
    });

    this.axios.get("/ru/getcdng").then((response) => {
        let data = response.data;
        if(data) {
            this.cndgs = data.data;
        }
        else {
            console.log('No data');
        }
    });

    this.axios.get("/ru/getwbs").then((response) => {
        let data = response.data;
        if(data) {
            this.wbs = data.data;
        }
        else {
            console.log('No data');
        }
    });

    this.axios.get("/ru/getsrb").then((response) => {
        let data = response.data;
        if(data) {
            this.srb = data.data;
        }
        else {
            console.log('No data');
        }
    });

    this.axios.get("/ru/gethob").then((response) => {
        let data = response.data;
        if(data) {
            this.hob = data.data;
        }
        else {
            console.log('No data');
        }
    });

    this.axios.get("/ru/gethb").then((response) => {
        let data = response.data;
        if(data) {
            this.hb = data.data;
        }
        else {
            console.log('No data');
        }
    });

    this.axios.get("/ru/getallgus").then((response) => {
        let data = response.data;
        if(data) {
            this.gus = data.data;
        }
        else {
            console.log('No data');
        }
    });

    this.axios.get("/ru/getallkormasses").then((response) => {
        let data = response.data;
        if(data) {
            this.kormass = data.data;
        }
        else {
            console.log('No data');
        }
    });

  }
};
</script>
<style scoped>
    .form-label-group{
        padding-bottom: 30px;
    }
    .form-label-group2{
        padding-bottom: 39px;
    }
</style>
