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
            <input type="number" name="sulphate_ion" v-model="sulphate_ion" class="form-control" placeholder="">
        </div>
        <label>Mg2+</label>
        <div class="form-label-group">
            <input type="number" name="magnesium_ion" v-model="magnesium_ion"  class="form-control" placeholder="">
        </div>
        <label>рН</label>
        <div class="form-label-group">
            <input type="number" name="ph"  v-model="ph" class="form-control" placeholder="">
        </div>
        <label>Тип воды по Сулину</label>
        <div class="form-label-group">
            <select class="form-control"  name="water_type_by_sulin_id" v-model="wbsmodel">
            <option v-for="row in wbs" v-bind:value="row.id">{{ row.name }}</option>
            </select>
        </div>
        <label>Cодержание стронция, мг/дм³</label>
        <div class="form-label-group">
            <input type="number" name="strontium_content" v-model="strontium_content" class="form-control" placeholder="">
        </div>
        <label>Содержание трехвалентного железа мг/дм3</label>
        <div class="form-label-group">
            <input type="number" name="ferric_iron_content" v-model="ferric_iron_content" class="form-control" placeholder="">
        </div>
        <label>О2, мг/дм3</label>
        <div class="form-label-group">
            <input type="number" name="oxygen" v-model="oxygen" class="form-control" placeholder="">
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
        <label>НСО3</label>
        <div class="form-label-group">
            <input type="number" name="hydrocarbonate_ion" v-model="hydrocarbonate_ion" class="form-control" placeholder="">
        </div>
        <label>Cl-</label>
        <div class="form-label-group">
            <input type="number" name="chlorum_ion" v-model="chlorum_ion" class="form-control" placeholder="">
        </div>
        <label>Na+K+</label>
        <div class="form-label-group">
            <input type="number" name="potassium_ion_sodium_ion" v-model="potassium_ion_sodium_ion" class="form-control" placeholder="">
        </div>
        <label>Общая минерализация, мг/дм3</label>
        <div class="form-label-group">
            <input type="number" name="mineralization" v-model="mineralization" class="form-control" placeholder="">
        </div>
        <label>Содержание нефтепродуктов, мг/дм3</label>
        <div class="form-label-group">
            <input type="number" name="content_of_petrolium_products" v-model="content_of_petrolium_products" class="form-control" placeholder="">
        </div>
        <label>Содержание бария, мг/дм³</label>
        <div class="form-label-group">
            <input type="number" name="barium_content" v-model="barium_content" class="form-control" placeholder="">
        </div>
        <label>Содержание двухвалентного железа мг/дм3</label>
        <div class="form-label-group">
            <input type="number" name="ferrous_iron_content" v-model="ferrous_iron_content" class="form-control" placeholder="">
        </div>
        <label>CO2, мг/дм3</label>
        <div class="form-label-group">
            <input type="number" name="carbon_dioxide" v-model="carbon_dioxide" class="form-control" placeholder="">
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
            <input type="number" name="carbonate_ion" v-model="carbonate_ion" class="form-control" placeholder="">
            <input type="hidden" name="id" v-model="id" class="form-control" placeholder="">
        </div>
        <label>Ca2+</label>
        <div class="form-label-group">
            <input type="number" name="calcium_ion" v-model="calcium_ion" class="form-control" placeholder="">
        </div>
        <label>Плотность при 20°С, г/см3</label>
        <div class="form-label-group">
            <input type="number" name="density" v-model="density" class="form-control" placeholder="">
        </div>
        <label>Общая жесткость, мг-экв/дм3</label>
        <div class="form-label-group">
            <input type="number" name="total_hardness" v-model="total_hardness" class="form-control" placeholder="">
        </div>
        <label>Механические примеси, мг/дм3</label>
        <div class="form-label-group">
            <input type="number" name="mechanical_impurities" v-model="mechanical_impurities" class="form-control" placeholder="">
        </div>
        <label>Содержание общего железа мг/дм3</label>
        <div class="form-label-group">
            <input type="number" name="total_iron_content" v-model="total_iron_content" class="form-control" placeholder="">
        </div>
        <label>H2S, мг/дм3</label>
        <div class="form-label-group">
            <input type="number" name="hydrogen_sulfide" v-model="hydrogen_sulfide" class="form-control" placeholder="">
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
    name: "wm-edit",
    props: ['id'],
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
        hbmodel: null,
        barium_content: null,
        calcium_ion: null,
        carbon_dioxide: null,
        carbonate_ion: null,
        chlorum_ion: null,
        content_of_petrolium_products: null,
        density: null,
        ferric_iron_content: null,
        ferrous_iron_content: null,
        hydrocarbonate_ion: null,
        hydrogen_sulfide: null,
        magnesium_ion: null,
        mechanical_impurities: null,
        mineralization: null,
        ph: null,
        potassium_ion_sodium_ion: null,
        strontium_content: null,
        sulphate_ion: null,
        total_hardness: null,
        total_iron_content: null,
        oxygen: null
    }
  },
  mounted() {
    this.axios.post("/ru/getwm", {
        id: this.id,
    }).then((response) => {
        let data = response.data.data;
        if(data) {
            console.log(data);
            var dt = data.date.split(' ');
            this.otherObject = data.other_objects_id,
            this.ngdu = data.ngdu_id,
            this.cdng = data.cdng_id,
            this.gu = data.gu_id,
            this.zu = data.zu_id,
            this.well = data.well_id,
            this.datetimeEmpty = dt[0] + "T" + dt[1] + ".000+06:00",
            this.wbsmodel = data.water_type_by_sulin_id,
            this.srbmodel = data.sulphate_reducing_bacteria_id,
            this.hobmodel = data.hydrocarbon_oxidizing_bacteria_id,
            this.hbmodel = data.thionic_bacteria_id,
            this.barium_content = data.barium_content,
            this.calcium_ion = data.calcium_ion,
            this.carbon_dioxide = data.carbon_dioxide,
            this.carbonate_ion = data.thicarbonate_iononic_bacteria_id,
            this.chlorum_ion = data.chlorum_ion,
            this.content_of_petrolium_products = data.content_of_petrolium_products,
            this.density = data.density,
            this.ferric_iron_content = data.ferric_iron_content,
            this.ferrous_iron_content = data.ferrous_iron_content,
            this.hydrocarbonate_ion = data.hydrocarbonate_ion,
            this.hydrogen_sulfide = data.hydrogen_sulfide,
            this.magnesium_ion = data.magnesium_ion,
            this.mechanical_impurities = data.mechanical_impurities,
            this.mineralization = data.mineralization,
            this.ph = data.ph,
            this.potassium_ion_sodium_ion = data.potassium_ion_sodium_ion,
            this.strontium_content = data.strontium_content,
            this.sulphate_ion = data.sulphate_ion,
            this.total_hardness = data.total_hardness,
            this.total_iron_content = data.total_iron_content,
            this.oxygen = data.oxygen
        }
        else {
            console.log('No data');
        }
    });

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
