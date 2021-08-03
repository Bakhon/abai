<template>
  <div class="row">
    <div class="col-xs-12 col-sm-4 col-md-4">
        <label>{{ trans('monitoring.zu.zu') }}</label>
        <div class="form-label-group">
          <select
              class="form-control"
              name="zu_id"
              v-model="formFields.zu_id"
              @change="chooseZu($event)"
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
        <div class="form-label-group">
          <label>{{ trans('monitoring.zu_cleanings.number_of_failures') }}</label>
          <textarea v-model="formFields.reason" type="text" name="reason" class="form-control" placeholder="">
        </textarea>
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
  name: "zu-cleanings-form",
  props: {
    zuCleanings: {
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
      zus: {},
      wells: {},
      prevData: null,
      formFields: {
        zu_id: null,
        well_id: null,
        date: null,
        number_of_failures: null,
      }
    };
  },
  mounted() {
    if (this.zuCleanings) {
      this.formFields = {
        zu_id: this.omguhe.zu_id,
        well_id: this.omguhe.well_id,
        date: moment(new Date(this.omguhe.date)).toISOString(),
        number_of_failures: this.zuCleanings.number_of_failures,
        
      }
      if (this.formFields.zu_id) {
        this.chooseZu()
      }

      this.pick();
    }
  },
  methods: {
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
    formatDate(date) {
      return moment.parseZone(date).format('YYYY-MM-DD HH:MM:SS')
    },
    submitForm () {
      this.axios
          [this.requestMethod](this.requestUrl, this.formFields)
          .then((response) => {
            if (response.data.status == 'success') {
              window.location.replace(this.localeUrl("/zu-cleanings"));
            }
          });
    }
  },
  computed: {
    requestUrl () {
      return this.isEditing ? this.localeUrl("/zu-cleanings/" + this.zuCleanings.id) : this.localeUrl("/zu-cleanings");
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

    this.axios.get(this.localeUrl("/getzus")).then((response) => {
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
