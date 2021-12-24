<template>
  <div class="d-flex">
    <div class="d-flex flex-column">
      <label for="kit">
        {{ trans('economic_reference.select_kit') }}
      </label>

      <select
          v-show="kits.length"
          id="kit"
          v-model="form[formKey]"
          :multiple="isMultiple"
          data-style="text-white form-control bg-main4 border-0"
          title=""
          class="well-kits"
          @change="form.permanent_stop_coefficient = null"
      >
        <option :value="null" disabled selected>
          {{ trans('economic_reference.select_item') }}
        </option>

        <option
            v-for="kit in kits"
            :key="kit.id"
            :value="kit.id">
          {{ kit.name }}
        </option>
      </select>
    </div>

    <div v-if="isVisiblePermanentCoefficient"
         class="ml-2">
      <label for="permanent_cost_coefficient">
        {{ trans('economic_reference.permanent_stop_coefficient') }}
      </label>

      <select
          id="permanent_cost_coefficient"
          v-model="form.permanent_stop_coefficient"
          class="form-control text-white border-0"
          style="background-color: #333975 !important;"
          @change="$emit('change')"
      >
        <option :value="null" disabled selected>
          {{ trans('economic_reference.select_item') }}
        </option>

        <option
            v-for="(coefficient, index) in permanentCoefficients"
            :key="index"
            :value="coefficient">
          {{ coefficient }}
        </option>
      </select>
    </div>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import 'bootstrap-select/dist/css/bootstrap-select.min.css';
import 'bootstrap-select/dist/js/bootstrap-select.min';
import 'bootstrap-select/dist/js/i18n/defaults-ru_RU.min';

export default {
  name: "SelectTechnicalWellForecastKit",
  props: {
    form: {
      required: true,
      type: Object
    },
    formKey: {
      required: false,
      type: String,
      default: () => 'kit_id'
    },
    fetchParams: {
      required: false,
      type: Object
    },
    isMultiple: {
      required: false,
      type: Boolean
    }
  },
  data: () => ({
    kits: []
  }),
  async mounted() {
    await this.getKits()

    $('.well-kits').selectpicker()
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getKits() {
      this.SET_LOADING(true)

      const {data} = await this.axios.get(this.url, {params: this.fetchParams})

      this.kits = data

      this.SET_LOADING(false)
    },
  },
  computed: {
    url() {
      return this.localeUrl('/economic/technical/well_forecast/kit/get-data')
    },

    isVisiblePermanentCoefficient() {
      if (!this.kits.length) {
        return false
      }

      return this.isMultiple ? this.form[this.formKey].length : this.form[this.formKey]
    },

    permanentCoefficients() {
      if (!this.isMultiple) {
        return this.kits
            .find(kit => kit.id === this.form[this.formKey]).permanent_stop_coefficients
            .map(coefficient => coefficient.value)
      }

      let coefficients = []

      this.kits.forEach(kit => {
        if (!this.form[this.formKey].includes(kit.id)) return

        coefficients.push(kit.permanent_stop_coefficients.map(coefficient => coefficient.value))
      })

      return coefficients.length > 1
          ? coefficients.reduce((a, b) => a.filter(c => b.includes(c)))
          : coefficients[0]
    }
  }
}
</script>

<style scoped>
</style>