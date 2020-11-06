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
        type="datetime" v-model="datetimeEmpty" input-class="date"
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
        <label>SO42-</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="sulphate_ion" class="form-control" placeholder="">
        </div>
        <label>Mg2+</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="magnesium_ion" class="form-control" placeholder="">
        </div>
        <label>рН</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="ph" class="form-control" placeholder="">
        </div>
        <label>Тип воды по Сулину</label>
        <div class="form-label-group">
            <select class="form-control"  name="water_type_by_sulin_id" v-model="wbsmodel">
            <option v-for="row in wbs" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>Cодержание стронция, мг/дм³</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="strontium_content" class="form-control" placeholder="">
        </div>
        <label>Содержание трехвалентного железа мг/дм3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="ferric_iron_content" class="form-control" placeholder="">
        </div>
        <label>О2, мг/дм3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="oxygen" class="form-control" placeholder="">
        </div>
        <label>УОБ, кл/см3</label>
        <div class="form-label-group">
            <select class="form-control"  name="hydrocarbon_oxidizing_bacteria_id" v-model="hobmodel">
            <option v-for="row in hob" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label>НГДУ</label>
        <div class="form-label-group">
            <select class="form-control"  name="ngdu_id" v-model="ngdu" @change="chooseNgdu($event)" disabled>
            <option v-for="row in ngdus" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>ЗУ</label>
        <div class="form-label-group">
            <select class="form-control"  name="zu_id" v-model="zu" @change="chooseZu($event)">
            <option v-for="row in zus" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>НСО3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="hydrocarbonate_ion" class="form-control" placeholder="">
        </div>
        <label>Cl-</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="chlorum_ion" class="form-control" placeholder="">
        </div>
        <label>Na+K+</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="potassium_ion_sodium_ion" class="form-control" placeholder="">
        </div>
        <label>Общая минерализация, мг/дм3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="mineralization" class="form-control" placeholder="">
        </div>
        <label>Содержание нефтепродуктов, мг/дм3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="content_of_petrolium_products" class="form-control" placeholder="">
        </div>
        <label>Содержание бария, мг/дм³</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="barium_content" class="form-control" placeholder="">
        </div>
        <label>Содержание двухвалентного железа мг/дм3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="ferrous_iron_content" class="form-control" placeholder="">
        </div>
        <label>CO2, мг/дм3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="carbon_dioxide" class="form-control" placeholder="">
        </div>
        <label>ТБ, кл/см3</label>
        <div class="form-label-group">
            <select class="form-control"  name="thionic_bacteria_id" v-model="hbmodel">
            <option v-for="row in hb" v-bind:value="row.id">{{ row.name }}</option>
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
        <label>СО32-</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="carbonate_ion" class="form-control" placeholder="">
        </div>
        <label>Ca2+</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="calcium_ion" class="form-control" placeholder="">
        </div>
        <label>Плотность при 20°С, г/см3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="density" class="form-control" placeholder="">
        </div>
        <label>Общая жесткость, мг-экв/дм3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="total_hardness" class="form-control" placeholder="">
        </div>
        <label>Механические примеси, мг/дм3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="mechanical_impurities" class="form-control" placeholder="">
        </div>
        <label>Содержание общего железа мг/дм3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="total_iron_content" class="form-control" placeholder="">
        </div>
        <label>H2S, мг/дм3</label>
        <div class="form-label-group">
            <input type="number" step="0.0001" name="hydrogen_sulfide" class="form-control" placeholder="">
        </div>
        <label>СВБ, кл/см3</label>
        <div class="form-label-group">
            <select class="form-control"  name="sulphate_reducing_bacteria_id" v-model="srbmodel">
            <option v-for="row in srb" v-bind:value="row.id">{{ row.name }}</option>
            </select>
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
