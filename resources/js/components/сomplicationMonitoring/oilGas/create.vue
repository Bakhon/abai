<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label >Прочие объекты</label>
        <div class="form-label-group">
            <select class="form-control"  name="other_objects_id" v-model="otherObject" v-show="otherObjects.length > 0">
            <option v-for="row in otherObjects" v-bind:value="row.id">{{ row.name }}</option>
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
        <label>Вязкость нефти при 40С, мм2/с</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="oil_viscosity_at_40" class="form-control" placeholder="">
        </div>
        <label>H2S в газе, ppm</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="hydrogen_sulfide_in_gas" class="form-control" placeholder="">
        </div>
        <label>Плотность газа при 20°С, кг/м3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="gas_density_at_20" class="form-control" placeholder="">
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
        <label>Плотность нефти при 20°С, кг/м3 </label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="water_density_at_20" class="form-control" placeholder="">
        </div>
        <label>Вязкость нефти при 50С, мм2/с</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="oil_viscosity_at_50" class="form-control" placeholder="">
        </div>
        <label>О2 в газе, %</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="oxygen_in_gas" class="form-control" placeholder="">
        </div>
        <label>Вязкость газа при 20С, сП</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="gas_viscosity_at_20" class="form-control" placeholder="">
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
        <label>Вязкость нефти при 20С, мм2/с</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="oil_viscosity_at_20" class="form-control" placeholder="">
        </div>
        <label>Вязкость нефти при 60С, мм2/с</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="oil_viscosity_at_60" class="form-control" placeholder="">
        </div>
        <label>CO2 в газе, %</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="carbon_dioxide_in_gas" class="form-control" placeholder="">
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
        chooseGu(event){
            this.axios.post("/ru/getzu", {
                gu_id: event.target.value,
            }).then((response) => {
                let data = response.data;
                if(data) {
                    this.zus = data.data;
                    this.well = null
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
        },
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
        otherObject: null,
        ngdu: null,
        cdng: null,
        gu: null,
        zu: null,
        well: null,
        datetimeEmpty: null,
        wbsmodel: null,
        srbmodel: null,
        hobmodel: null,
        hbmodel: null
    }
  },
  beforeCreate: function () {
    this.axios.get("/ru/getotherobjects").then((response) => {
        let data = response.data;
        if(data) {
            this.otherObjects = data.data;
        }
        else {
            console.log('No data');
        }
    });

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
