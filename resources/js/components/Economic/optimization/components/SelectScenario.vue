<template>
  <div>
    <label for="scenario">
      {{ trans('economic_reference.scenario') }}
    </label>

    <select
        v-model="form.scenario_id"
        id="scenario"
        class="form-control text-white border-0 bg-dark-blue"
        @change="toggleScenario()">
      <option :value="null" disabled selected>
        {{ trans('economic_reference.select_item') }}
      </option>

      <option
          v-for="scenario in scenarios"
          :key="scenario.id"
          :value="scenario.id">
        {{ scenario.name }}
      </option>
    </select>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

export default {
  name: "SelectScenario",
  props: {
    form: {
      required: true,
      type: Object
    },
    fetchParams: {
      required: false,
      type: Object
    }
  },
  data: () => ({
    scenarios: []
  }),
  created() {
    this.getScenarios()
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getScenarios() {
      this.SET_LOADING(true)

      const {data} = await this.axios.get(this.url, {params: this.fetchParams})

      this.scenarios = data

      this.SET_LOADING(false)
    },

    toggleScenario() {
      this.$emit(
          'change',
          this.scenarios.find(scenario => scenario.id === this.form.scenario_id)
      )
    }
  },
  computed: {
    url() {
      return this.localeUrl('/economic/scenario/get-data')
    },
  }
}
</script>

<style scoped>
.bg-dark-blue {
  background: #333975;
}
</style>