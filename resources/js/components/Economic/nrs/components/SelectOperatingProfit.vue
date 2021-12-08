<template>
  <select
      v-model="form.operatingProfit"
      class="form-control"
      @change="$emit('change')"
  >
    <option
        v-for="item in data"
        :key="item.value"
        :value="item.value">
      {{ item.label }}
    </option>
  </select>
</template>

<script>
export default {
  name: "SelectOperatingProfit",
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
          label: 'op_full',
          value: 'Operating_profit'
        },
        {
          label: 'op_variable_prs',
          value: 'Operating_profit_variable_prs'
        },
        {
          label: 'op_variable_prs_nopayrall',
          value: 'Operating_profit_variable_prs_nopayrall'
        }
      ]
    }
  }
}
</script>

<style scoped>
</style>