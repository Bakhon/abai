<template>
  <select
      v-model="form.granularity"
      class="form-control text-white bg-main4-important border-0"
      @change="$emit('change')"
  >
    <option
        v-for="granularity in data"
        :key="granularity.value"
        :value="granularity.value">
      {{ granularity.label }}
    </option>
  </select>
</template>

<script>
export const GRANULARITY_DAY = 'day'
export const GRANULARITY_MONTH = 'month'

export default {
  name: "SelectGranularity",
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
          label: this.trans('economic_reference.granularity_daily'),
          value: GRANULARITY_DAY
        },
        {
          label: this.trans('economic_reference.granularity_monthly'),
          value: GRANULARITY_MONTH
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