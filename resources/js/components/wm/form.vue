<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>Прочие объекты</label>
      <div class="form-label-group">
        <select class="form-control" name="other_objects_id" v-model="formFields.other_objects_id"
                v-show="otherObjects.length > 0">
          <option v-for="row in otherObjects" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>ГУ</label>
      <div class="form-label-group">
        <select class="form-control" name="gu_id" v-model="formFields.gu_id" @change="chooseGu()">
          <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>Дата и время</label>
      <div class="form-label-group">
        <datetime
            type="datetime"
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
      <label>SO42-</label>
      <div class="form-label-group">
        <input
            v-model="formFields.sulphate_ion"
            type="number"
            step="0.0001"
            :min="validationParams.sulphate_ion.min"
            :max="validationParams.sulphate_ion.max"
            name="sulphate_ion"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Mg2+</label>
      <div class="form-label-group">
        <input
            v-model="formFields.magnesium_ion"
            type="number"
            step="0.0001"
            :min="validationParams.magnesium_ion.min"
            :max="validationParams.magnesium_ion.max"
            name="magnesium_ion"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>рН</label>
      <div class="form-label-group">
        <input
            v-model="formFields.ph"
            type="number"
            step="0.0001"
            :min="validationParams.ph.min"
            :max="validationParams.ph.max"
            name="ph"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Тип воды по Сулину</label>
      <div class="form-label-group">
        <select class="form-control" name="water_type_by_sulin_id" v-model="formFields.water_type_by_sulin_id">
          <option v-for="row in wbs" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>Cодержание стронция, мг/дм³</label>
      <div class="form-label-group">
        <input
            v-model="formFields.strontium_content"
            type="number"
            step="0.0001"
            :min="validationParams.strontium_content.min"
            :max="validationParams.strontium_content.max"
            name="strontium_content"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Содержание трехвалентного железа мг/дм3</label>
      <div class="form-label-group">
        <input
            v-model="formFields.ferric_iron_content"
            type="number"
            step="0.0001"
            :min="validationParams.ferric_iron_content.min"
            :max="validationParams.ferric_iron_content.max"
            name="ferric_iron_content"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>О2, мг/дм3</label>
      <div class="form-label-group">
        <input
            v-model="formFields.oxygen"
            type="number"
            step="0.0001"
            :min="validationParams.oxygen.min"
            :max="validationParams.oxygen.max"
            name="oxygen"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>УОБ, кл/см3</label>
      <div class="form-label-group">
        <select class="form-control" name="hydrocarbon_oxidizing_bacteria_id"
                v-model="formFields.hydrocarbon_oxidizing_bacteria_id">
          <option v-for="row in hob" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>НГДУ</label>
      <div class="form-label-group">
        <select class="form-control" name="ngdu_id" v-model="formFields.ngdu_id">
          <option v-for="row in ngdus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>ЗУ</label>
      <div class="form-label-group">
        <select class="form-control" name="zu_id" v-model="formFields.zu_id" @change="chooseZu()">
          <option v-for="row in zus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>НСО3</label>
      <div class="form-label-group">
        <input
            v-model="formFields.hydrocarbonate_ion"
            type="number"
            step="0.0001"
            :min="validationParams.hydrocarbonate_ion.min"
            :max="validationParams.hydrocarbonate_ion.max"
            name="hydrocarbonate_ion"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Cl-</label>
      <div class="form-label-group">
        <input
            v-model="formFields.chlorum_ion"
            type="number"
            step="0.0001"
            :min="validationParams.chlorum_ion.min"
            :max="validationParams.chlorum_ion.max"
            name="chlorum_ion"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Na+K+</label>
      <div class="form-label-group">
        <input
            v-model="formFields.potassium_ion_sodium_ion"
            type="number"
            step="0.0001"
            :min="validationParams.potassium_ion_sodium_ion.min"
            :max="validationParams.potassium_ion_sodium_ion.max"
            name="potassium_ion_sodium_ion"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Общая минерализация, мг/дм3</label>
      <div class="form-label-group">
        <input
            v-model="formFields.mineralization"
            type="number"
            step="0.0001"
            :min="validationParams.mineralization.min"
            :max="validationParams.mineralization.max"
            name="mineralization"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Содержание нефтепродуктов, мг/дм3</label>
      <div class="form-label-group">
        <input
            v-model="formFields.content_of_petrolium_products"
            type="number"
            step="0.0001"
            :min="validationParams.content_of_petrolium_products.min"
            :max="validationParams.content_of_petrolium_products.max"
            name="content_of_petrolium_products"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Содержание бария, мг/дм³</label>
      <div class="form-label-group">
        <input
            v-model="formFields.barium_content"
            type="number"
            step="0.0001"
            :min="validationParams.barium_content.min"
            :max="validationParams.barium_content.max"
            name="barium_content"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Содержание двухвалентного железа мг/дм3</label>
      <div class="form-label-group">
        <input
            v-model="formFields.ferrous_iron_content"
            type="number"
            step="0.0001"
            :min="validationParams.ferrous_iron_content.min"
            :max="validationParams.ferrous_iron_content.max"
            name="ferrous_iron_content"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>CO2, мг/дм3 (после буферной емкости)</label>
      <div class="form-label-group">
        <input
            v-model="formFields.carbon_dioxide"
            type="number"
            step="0.0001"
            :min="validationParams.carbon_dioxide.min"
            :max="validationParams.carbon_dioxide.max"
            name="carbon_dioxide"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>ТБ, кл/см3</label>
      <div class="form-label-group">
        <select class="form-control" name="thionic_bacteria_id" v-model="formFields.thionic_bacteria_id">
          <option v-for="row in hb" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>ЦДНГ</label>
      <div class="form-label-group">
        <select class="form-control" name="cdng_id" v-model="formFields.cdng_id">
          <option v-for="row in cndgs" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>Скважина</label>
      <div class="form-label-group">
        <select class="form-control" name="well_id" v-model="formFields.well_id">
          <option v-for="row in wells" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>СО32-</label>
      <div class="form-label-group">
        <input
            v-model="formFields.carbonate_ion"
            type="number"
            step="0.0001"
            :min="validationParams.carbonate_ion.min"
            :max="validationParams.carbonate_ion.max"
            name="carbonate_ion"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Ca2+</label>
      <div class="form-label-group">
        <input
            v-model="formFields.calcium_ion"
            type="number"
            step="0.0001"
            :min="validationParams.calcium_ion.min"
            :max="validationParams.calcium_ion.max"
            name="calcium_ion"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Плотность при 20°С, г/см3</label>
      <div class="form-label-group">
        <input
            v-model="formFields.density"
            type="number"
            step="0.0001"
            :min="validationParams.density.min"
            :max="validationParams.density.max"
            name="density"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Общая жесткость, мг-экв/дм3</label>
      <div class="form-label-group">
        <input
            v-model="formFields.total_hardness"
            type="number"
            step="0.0001"
            :min="validationParams.total_hardness.min"
            :max="validationParams.total_hardness.max"
            name="total_hardness"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Механические примеси, мг/дм3</label>
      <div class="form-label-group">
        <input
            v-model="formFields.mechanical_impurities"
            type="number"
            step="0.0001"
            :min="validationParams.mechanical_impurities.min"
            :max="validationParams.mechanical_impurities.max"
            name="mechanical_impurities"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Содержание общего железа мг/дм3</label>
      <div class="form-label-group">
        <input
            v-model="formFields.total_iron_content"
            type="number"
            step="0.0001"
            :min="validationParams.total_iron_content.min"
            :max="validationParams.total_iron_content.max"
            name="total_iron_content"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>H2S, мг/дм3 (после буферной емкости)</label>
      <div class="form-label-group">
        <input
            v-model="formFields.hydrogen_sulfide"
            type="number"
            step="0.0001"
            :min="validationParams.hydrogen_sulfide.min"
            :max="validationParams.hydrogen_sulfide.max"
            name="hydrogen_sulfide"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>СВБ, кл/см3</label>
      <div class="form-label-group">
        <select class="form-control" name="sulphate_reducing_bacteria_id"
                v-model="formFields.sulphate_reducing_bacteria_id">
          <option v-for="row in srb" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" :disabled="!formFields.date" class="btn btn-success">Сохранить</button>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import {Datetime} from 'vue-datetime'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'
import {Settings} from 'luxon'
import moment from "moment"

Settings.defaultLocale = 'ru'

Vue.use(Datetime)

export default {
  name: "wm-form",
  props: [
    'wm',
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
      otherObject: null,
      gu: null,
      datetimeEmpty: null,
      formFields: {
        other_objects_id: null,
        gu_id: null,
        date: null,
        sulphate_ion: null,
        magnesium_ion: null,
        ph: null,
        water_type_by_sulin_id: null,
        strontium_content: null,
        ferric_iron_content: null,
        oxygen: null,
        hydrocarbon_oxidizing_bacteria_id: null,
        ngdu_id: null,
        zu_id: null,
        hydrocarbonate_ion: null,
        chlorum_ion: null,
        potassium_ion_sodium_ion: null,
        mineralization: null,
        content_of_petrolium_products: null,
        barium_content: null,
        ferrous_iron_content: null,
        carbon_dioxide: null,
        thionic_bacteria_id: null,
        cdng_id: null,
        well_id: null,
        carbonate_ion: null,
        calcium_ion: null,
        density: null,
        total_hardness: null,
        mechanical_impurities: null,
        total_iron_content: null,
        hydrogen_sulfide: null,
        sulphate_reducing_bacteria_id: null,
      }
    }
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
    if (this.wm) {
      this.formFields = {
        other_objects_id: this.wm.other_objects_id,
        gu_id: this.wm.gu_id,
        date: moment(this.wm.date).format('YYYY-MM-DD'),
        sulphate_ion: this.wm.sulphate_ion,
        magnesium_ion: this.wm.magnesium_ion,
        ph: this.wm.ph,
        water_type_by_sulin_id: this.wm.water_type_by_sulin_id,
        strontium_content: this.wm.strontium_content,
        ferric_iron_content: this.wm.ferric_iron_content,
        oxygen: this.wm.oxygen,
        hydrocarbon_oxidizing_bacteria_id: this.wm.hydrocarbon_oxidizing_bacteria_id,
        ngdu_id: this.wm.ngdu_id,
        zu_id: this.wm.zu_id,
        hydrocarbonate_ion: this.wm.hydrocarbonate_ion,
        chlorum_ion: this.wm.chlorum_ion,
        potassium_ion_sodium_ion: this.wm.potassium_ion_sodium_ion,
        mineralization: this.wm.mineralization,
        content_of_petrolium_products: this.wm.content_of_petrolium_products,
        barium_content: this.wm.barium_content,
        ferrous_iron_content: this.wm.ferrous_iron_content,
        carbon_dioxide: this.wm.carbon_dioxide,
        thionic_bacteria_id: this.wm.thionic_bacteria_id,
        cdng_id: this.wm.cdng_id,
        well_id: this.wm.well_id,
        carbonate_ion: this.wm.carbonate_ion,
        calcium_ion: this.wm.calcium_ion,
        density: this.wm.density,
        total_hardness: this.wm.total_hardness,
        mechanical_impurities: this.wm.mechanical_impurities,
        total_iron_content: this.wm.total_iron_content,
        hydrogen_sulfide: this.wm.hydrogen_sulfide,
        sulphate_reducing_bacteria_id: this.wm.sulphate_reducing_bacteria_id,
      }
      if (this.wm.gu_id) {
        this.chooseGu(true)
      }
      if (this.wm.zu_id) {
        this.chooseZu()
      }
    }
  },
  methods: {
    chooseGu(init = false) {
      this.axios.post("/ru/getzu", {
        gu_id: this.formFields.gu_id,
      }).then((response) => {
        let data = response.data;
        if (data) {
          this.zus = data.data;
          if (!init) {
            this.formFields.well_id = null
          }
        } else {
          console.log('No data');
        }
      });

      this.axios.post("/ru/getgucdngngdufield", {
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
      this.axios.post("/ru/getwell", {
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
  beforeCreate: function () {
    this.axios.get("/ru/getotherobjects").then((response) => {
      let data = response.data;
      if (data) {
        this.otherObjects = data.data;
      } else {
        console.log('No data');
      }
    });

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

    this.axios.get("/ru/getwbs").then((response) => {
      let data = response.data;
      if (data) {
        this.wbs = data.data;
      } else {
        console.log('No data');
      }
    });

    this.axios.get("/ru/getsrb").then((response) => {
      let data = response.data;
      if (data) {
        this.srb = data.data;
      } else {
        console.log('No data');
      }
    });

    this.axios.get("/ru/gethob").then((response) => {
      let data = response.data;
      if (data) {
        this.hob = data.data;
      } else {
        console.log('No data');
      }
    });

    this.axios.get("/ru/gethb").then((response) => {
      let data = response.data;
      if (data) {
        this.hb = data.data;
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

  }
};
</script>
<style scoped>
.form-label-group {
  padding-bottom: 30px;
}
</style>
