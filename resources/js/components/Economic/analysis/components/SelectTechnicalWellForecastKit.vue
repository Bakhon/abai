<template>
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
        @change="$emit('change')"
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
  }
}
</script>

<style scoped>
</style>