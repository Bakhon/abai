<template>
  <div class="row">
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label>{{ trans('monitoring.field') }}</label>
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
        <label>{{ trans('monitoring.gu.gu') }}</label>
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
        <label> {{ trans('app.date_time') }} </label>
        <div class="form-label-group">
          <datetime
              type="datetime"
              v-model="formFields.date"
              input-class="form-control date"
              value-zone="Asia/Almaty"
              zone="Asia/Almaty"
              :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
              :phrases="{ok: this.trans('app.choose'), cancel: this.trans('app.cancel')}"
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
          <input
              @change="onChangeServiceDosing"
              type="checkbox"
              class="form-check-input"
              name="out_of_service_of_dosing"
              id="out_of_service_of_dosing"
              value="1"
              v-model="formFields.out_of_service_of_dosing"
          />
          <label class="form-check-label" for="out_of_service_of_dosing"
          >{{ trans('monitoring.omguhe.fields.dosator_idle') }}</label
          >
        </div>
        <div class="form-label-group" v-show="formFields.out_of_service_of_dosing">
          <label>{{ trans('monitoring.omguhe.fields.reason') }}</label>
          <textarea v-model="formFields.reason" type="text" name="reason" class="form-control" placeholder="">
        </textarea>
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-4">
        <label>{{ trans('monitoring.ngdu') }}</label>
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

        <label>{{ trans('monitoring.level') }} {{ trans('measurements.liter') }}</label>
        <div class="form-label-group">
          <input
              :disabled="(!formFields.gu_id && !formFields.date) || formFields.out_of_service_of_dosing"
              @input="inputLevel"
              v-model="formFields.level"
              type="number"
              step="0.0001"
              :min="validationParams.level.min"
              :max="prevData ? prevData : validationParams.level.max"
              name="level"
              class="form-control"
              placeholder=""
          />
        </div>

        <label>{{ trans('monitoring.omguhe.fields.fact_dosage') }}</label>
        <div class="form-label-group">
          <input
              :disabled="true"
              type="number"
              step="0.0001"
              name="current_dosage"
              class="form-control"
              v-model="formFields.current_dosage"
              placeholder=""
          />
        </div>

        <label>{{ trans('monitoring.fields.consumption') }} {{ trans('measurements.liter') }}</label>
        <div class="form-label-group">
          <input
              :disabled="true"
              type="number"
              step="0.0001"
              name="consumption"
              class="form-control"
              v-model="formFields.consumption"
              placeholder=""
          />
        </div>

        <label>{{ trans('monitoring.omguhe.fields.inhibitor_rate') }}</label>
        <div class="form-label-group">
          <input
              :disabled="true"
              type="number"
              step="0.0001"
              name="daily_inhibitor_flowrate"
              class="form-control"
              v-model="formFields.daily_inhibitor_flowrate"
              placeholder=""
          />
        </div>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-4">
        <label>{{ trans('monitoring.cdng') }}</label>
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
        <label>{{ trans('monitoring.well.well') }}</label>
        <div class="form-label-group">
          <select class="form-control" name="well_id" v-model="formFields.well_id">
            <option v-for="row in wells" v-bind:value="row.id">
              {{ row.name }}
            </option>
          </select>
        </div>
        <label>{{ trans('monitoring.omguhe.fields.inhibitor') }}</label>
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
              @change="onChangeFillStatus()"
          />
          <label class="form-check-label" for="fill_status">{{ trans('monitoring.omguhe.fields.fill') }} {{ trans('measurements.liter') }}</label>
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
          <label class="form-check-label" for="fill">{{ trans('monitoring.omguhe.fields.fill') }}</label>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" :disabled="!formFields.date" @click.prevent="submitForm" class="btn btn-success">
          {{ trans('app.save') }}
        </button>
      </div>
    </div>
</template>

<script>
import Vue from "vue";
import {Datetime} from "vue-datetime";
import "vue-datetime/dist/vue-datetime.css";
import moment from "moment";


Vue.use(Datetime);

export default {
  name: "omguhe-form",
  props: {
    omguhe: {
      type: Object,
      default: null
    },
    validationParams: {
      type: Object,
      required: true,
    },
    isEditing: {
      type: Boolean,
      default: false
    },
  },
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
      out_of_service_of_dosing: false,
      prevData: null,
      qv: null,
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
        out_of_service_of_dosing: false,
        current_dosage: null,
        reason: null,
        fill_status: null,
        consumption: null,
        daily_inhibitor_flowrate: null
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
        out_of_service_of_dosing: this.omguhe.out_of_service_of_dosing,
        current_dosage: this.omguhe.current_dosage,
        reason: this.omguhe.reason,
        fill_status: !!this.omguhe.fill,
        consumption: this.omguhe.consumption,
        daily_inhibitor_flowrate: null
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

      this.pick();
    }
  },
  methods: {
    chooseNgdu() {
      this.axios
          .get(this.localeUrl("/getcdng"), {
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
          .post(this.localeUrl("/getgu"), {
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
          .post(this.localeUrl("/get-gu-cdng-ngdu-field"), {
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
          .post(this.localeUrl("/getwell"), {
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
          .post(this.localeUrl("/get-prev-day-level"), {
            gu_id: this.formFields.gu_id,
            date: this.formFields.date,
          })
          .then((response) => {
            let data = response.data;

            if (data.status == 'success') {
              this.prevData = data.level;
              this.qv = (data.qv * 1000) / 365;
            } else {
              this.showToast(data.message, this.trans('app.error'), 'danger');
              this.prevData = null;
            }

            this.inputLevel();
          });
    },
    inputLevel() {
      if (this.prevData != null) {
        this.formFields.level = this.formFields.level > this.prevData ? this.prevData : this.formFields.level;

        this.formFields.consumption = this.prevData - this.formFields.level;
        let currentDosage = (this.formFields.consumption / this.qv) * 946;

        this.formFields.current_dosage = currentDosage > 0 ? currentDosage.toFixed(2) : 0;
        this.formFields.daily_inhibitor_flowrate = (this.formFields.current_dosage * this.qv/1000).toFixed(2);
      } else {
        this.formFields.consumption = this.formFields.current_dosage = 0;
      }
    },
    formatDate(date) {
      return moment.parseZone(date).format('YYYY-MM-DD HH:MM:SS')
    },
    onChangeFillStatus () {
      this.formFields.fill = this.fill_status ? this.formFields.fill : null;
    },
    onChangeServiceDosing (){
      this.formFields.level = this.formFields.out_of_service_of_dosing ? this.prevData : 0;
      this.inputLevel();
    },
    submitForm () {
      this.formFields.out_of_service_of_dosing = this.formFields.out_of_service_of_dosing ? 1 : 0;

      this.axios
          [this.requestMethod](this.requestUrl, this.formFields)
          .then((response) => {
            if (response.data.status == 'success') {
              window.location.replace(this.localeUrl("/omguhe"));
            }
          });
    }
  },
  computed: {
    requestUrl () {
      return this.isEditing ? this.localeUrl("/omguhe/" + this.omguhe.id) : this.localeUrl("/omguhe");
    },
    requestMethod () {
      return this.isEditing ? "put" : "post";
    }
  },
  beforeCreate: function () {
    this.axios.get(this.localeUrl("/getfields")).then((response) => {
      let data = response.data;
      if (data) {
        this.fields = data.data;
      } else {
        console.log('No data');
      }
    });

    this.axios.get(this.localeUrl("/getngdu")).then((response) => {
      let data = response.data;
      if (data) {
        this.ngdus = data.data;
      } else {
        console.log("No data");
      }
    });

    this.axios.get(this.localeUrl("/getcdng")).then((response) => {
      let data = response.data;
      if (data) {
        this.cndgs = data.data;
      } else {
        console.log("No data");
      }
    });

    this.axios.get(this.localeUrl("/getallgus")).then((response) => {
      let data = response.data;
      if (data) {
        this.gus = data.data;
      } else {
        console.log("No data");
      }
    });

    this.axios.get(this.localeUrl("/getinhibitors")).then((response) => {
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
