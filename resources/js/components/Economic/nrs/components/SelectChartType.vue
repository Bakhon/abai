<template>
  <select
      v-model="form.chartType"
      class="form-control"
      @change="$emit('change')"
  >
    <option
        v-for="type in types"
        :key="type.value"
        :value="type.value">
      {{ type.label }}
    </option>
  </select>
</template>

<script>
export default {
  name: "SelectChartType",
  props: {
    form: {
      required: true,
      type: Object
    },
  },
  computed: {
    types() {
      return [
        {
          label: 'line',
          value: 'line',
        },
        {
          label: 'bar',
          value: 'bar',
        },
        {
          label: 'area',
          value: 'area',
        }
      ]
    }
  }
}
</script>

<style scoped>
</style>