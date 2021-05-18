<template>
  <select
      v-model="form.profitability"
      class="form-control text-white bg-main4-important border-0"
      @change="$emit('change')"
  >
    <option
        v-for="profitability in data"
        :key="profitability.value"
        :value="profitability.value">
      {{ profitability.label }}
    </option>
  </select>
</template>

<script>
export const PROFITABILITY_FULL = 'profitability'
export const PROFITABILITY_DIRECT = 'profitability_kbm'
export const PROFITABILITY_DIRECT_FROM_DATE = 'profitability_kbm_date'

export default {
  name: "SelectProfitability",
  props: {
    form: {
      required: true,
      type: Object
    },
  },
  computed: {
    data() {
      return [
        {
          label: this.trans('economic_reference.profitability_full'),
          value: PROFITABILITY_FULL
        },
        {
          label: this.trans('economic_reference.profitability_direct'),
          value: PROFITABILITY_DIRECT
        },
        {
          label: this.trans('economic_reference.profitability_direct_from_date'),
          value: PROFITABILITY_DIRECT_FROM_DATE
        }
      ]
    }
  }
}
</script>

<style scoped>
.bg-main4-important {
  background-color: #333975;
}
</style>