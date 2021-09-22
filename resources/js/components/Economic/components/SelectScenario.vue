<template>
  <select
      v-model="form.scenario_id"
      id="scenarios"
      class="form-control text-white border-0 bg-dark-blue"
      @change="$emit('change')">
    <option
        v-for="item in scenarios"
        :key="item.value"
        :value="item.value">
      {{ item.label }}
    </option>
  </select>
</template>

<script>
export default {
  name: "SelectScenario",
  props: {
    form: {
      required: true,
      type: Object
    }
  },
  computed:{
    scenarios() {
      return [
        {
          label: this.trans('economic_reference.basic_variant'),
          value: null,
        },
        {
          label: this.trans('economic_reference.test_scenario'),
          value: 6,
        }
      ]
    },
  }
}
</script>

<style scoped>
.bg-dark-blue {
  background: #333975;
}
</style>