<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.inhibitor.fields.title') }}</label>
      <div class="form-label-group">
        <input v-model="formFields.name" type="text" name="name" class="form-control" placeholder="">
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.inhibitor.fields.density') }}</label>
      <div class="form-label-group">
        <input v-model="formFields.density" type="text" name="density" class="form-control" placeholder="">
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <a href="#" @click.prevent="showPriceChange = !showPriceChange">{{
            trans('monitoring.inhibitor.change_price')
          }}</a>
      </div>
      <template v-if="showPriceChange">
        <div class="col-xs-12 col-sm-4 col-md-4">
          <label>{{ trans('monitoring.inhibitor.fields.price') }}</label>
          <div class="form-label-group">
            <input
                v-model="formFields.price"
                type="number"
                step="0.01"
                :min="validationParams.price.min"
                :max="validationParams.price.max"
                name="price"
                class="form-control"
            >
          </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
          <label>{{ trans('monitoring.fields.price_date') }}</label>
          <div class="form-label-group">
            <datetime
                type="date"
                v-model="formFields.date_from"
                input-class="form-control date"
                value-zone="Asia/Almaty"
                zone="Asia/Almaty"
                :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
                :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
                :hour-step="1"
                :minute-step="5"
                :week-start="1"
                :min-datetime="minDate"
                :max-datetime="formatDate()"
                use24-hour
                auto
            >
            </datetime>
            <input type="hidden" name="date_from" v-bind:value="formatDate(formFields.date_from)">
          </div>
        </div>
      </template>
      <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" :disabled="!formFields.name" class="btn btn-success">??????????????????</button>
      </div>
    </div>
  </div>
</template>

<script>
import {Settings} from 'luxon'
import {Datetime} from 'vue-datetime'
import moment from 'moment'

Settings.defaultLocale = 'ru'

export default {
  name: "inhibitor-edit",
  components: {
    Datetime
  },
  props: [
    'inhibitor',
    'validationParams'
  ],
  data: function () {
    return {
      minDate: null,
      showPriceChange: false,
      formFields: {
        name: null,
        price: null,
        date_from: null,
        density: null,
      },
      requiredFields: [
        'name',
        'density'
      ]
    }
  },
  computed: {
    valid() {
      let valid = true
      this.requiredFields.forEach(field => {
        if (!this.formFields[field]) {
          valid = false
        }
      })
      return valid
    }
  },
  mounted() {
    if (this.inhibitor) {
      this.formFields = {
        name: this.inhibitor.name,
        price: this.inhibitor.price,
        density: this.inhibitor.density,
        date_from: this.formatDate()
      }
      this.minDate = this.inhibitor.minDate
    }
  },
  methods: {
    formatDate(date = null) {
      if (date) {
        return moment(date).format('YYYY-MM-DD')
      }
      return moment().format('YYYY-MM-DD')
    }
  }
};
</script>
<style scoped>
.form-label-group {
  padding-bottom: 30px;
}
</style>
