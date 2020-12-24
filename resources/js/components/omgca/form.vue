<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <notifications></notifications>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('app.year') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="date" v-model="fields.year" @change="checkDublicate"
                v-show="years.length > 0">
          <option v-for="row in years" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('monitoring.omgca.fields.q_v') }}</label>
      <div class="form-label-group">
        <input
            type="number"
            step="0.0001"
            :min="validationParams.q_v.min"
            :max="validationParams.q_v.max"
            name="q_v"
            v-model="fields.q_v"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.gu') }}</label>
      <div class="form-label-group">
        <select class="form-control" v-model="gu" @change="checkDublicate">
          <option v-if="type && type === 'create'" value="all">{{ trans('monitoring.all_gus') }}</option>
          <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
        <input type="hidden" name="gu_id" v-bind:value="fields.gu">
        <input type="hidden" name="all_gus" v-bind:value="fields.all_gus ? 1 : 0">
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.omgca.fields.plan_dosage') }}</label>
      <div class="form-label-group">
        <input
            type="number"
            step="0.0001"
            :min="validationParams.plan_dosage.min"
            :max="validationParams.plan_dosage.max"
            name="plan_dosage"
            v-model="fields.plan_dosage"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" :disabled="!fields.year || (!fields.gu && !fields.all_gus) || dublicate"
              class="btn btn-success">
        {{ trans('app.save') }}
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
    'omgca',
    'type',
    'validationParams'
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
        plan_dosage: null,
        all_gus: false
      }
    }
  },
  watch: {
    gu(value) {
      if (value === 'all') {
        this.fields.gu = null
        this.fields.all_gus = true
      } else {
        this.fields.gu = value
        this.fields.all_gus = false
      }
    }
  },
  beforeCreate: function () {
    this.axios.get(this.localeUrl("/getallgus")).then((response) => {
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
        gu: this.omgca.gu_id,
        q_v: this.omgca.q_v,
        plan_dosage: this.omgca.plan_dosage
      }
      this.gu = this.omgca.gu_id
    }

    for (let i = 0; i < 5; i++) {
      let year = moment().startOf('year').add(i, 'years')
      this.years.push(
          {"id": year.format('YYYY-MM-DD'), "name": year.format('YYYY')}
      )
    }
  },
  methods: {
    checkDublicate() {
      if (this.gu === 'all') {
        this.dublicate = false
        return
      }

      if (this.gu != null && this.fields.year != null) {
        this.axios.post(this.localeUrl("/checkdublicateomgddng"), {
          id: this.omgca ? this.omgca.id : null,
          gu: this.gu,
          dt: this.fields.year,
        }).then((response) => {
          let data = response.data;
          if (data) {
            this.dublicate = false;
          } else {
            this.$notifyInfo(this.trans('monitoring.omgca.have_info_about_gu'));
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
