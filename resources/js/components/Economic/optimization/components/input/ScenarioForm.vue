<template>
  <div>
    <h5 class="text-secondary">
      {{ trans('economic_reference.name') }}
    </h5>

    <div class="form-group">
      <input
          v-model="form.name"
          type="text"
          class="form-control">
    </div>

    <div v-show="form.name">
      <h5 class="text-secondary mt-3">
        {{ trans('economic_reference.economic_data') }}
      </h5>

      <select-sc-fa :form="form" is-forecast/>
    </div>

    <div v-show="form.sc_fa_id">
      <h5 class="text-secondary mt-3">
        {{ trans('economic_reference.technical_data') }}
      </h5>

      <select-source :form="form"/>
    </div>

    <div v-show="form.source_id">
      <h5 class="text-secondary mt-3">
        {{ trans('economic_reference.gtm_kit') }}
      </h5>

      <select-gtm-kit :form="form"/>
    </div>

    <div v-show="form.source_id" class="text-center">
      <div v-for="relation in scenarioRelations"
           :key="relation.singleKey"
           class="text-left">
        <h5 class="text-secondary mt-3">
          {{ relation.title }}
        </h5>

        <div v-for="(item, itemIndex) in form.params[relation.multipleKey]"
             :key="`${relation.singleKey}_${itemIndex}`"
             class="form-group d-flex">
          <input v-model="item.value"
                 :min="relation.minValue"
                 :max="relation.maxValue"
                 :step="relation.step"
                 type="numeric"
                 class="form-control">

          <delete-button
              class="ml-2"
              @click.native="deleteRelation(itemIndex, relation.multipleKey)"/>
        </div>

        <add-button @click.native="addRelation(relation)"/>
      </div>

      <save-button @click.native="saveForm"/>
    </div>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import SelectScFa from "../../../components/SelectScFa";
import SelectSource from "../../../components/SelectSource";
import SelectGtmKit from "../SelectGtmKit";
import AddButton from "../../../components/AddButton";
import DeleteButton from "../../../components/DeleteButton";
import SaveButton from "../../../components/SaveButton";

import {EcoRefsScenarioModel} from "../../../models/EcoRefsScenarioModel";

export default {
  name: "ScenarioForm",
  components: {
    SelectScFa,
    SelectSource,
    SelectGtmKit,
    AddButton,
    DeleteButton,
    SaveButton
  },
  data: () => ({
    EcoRefsScenarioModel,
    form: new EcoRefsScenarioModel().form
  }),
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    addRelation({multipleKey, singleKey}) {
      this.form.params[multipleKey].push(new EcoRefsScenarioModel()[singleKey])
    },

    deleteRelation(index, key) {
      if (this.form.params[key].length < 2) return

      this.form.params[key].splice(index, 1)
    },

    async saveForm() {
      this.SET_LOADING(true)

      try {
        const {data} = await this.axios.post(this.localeUrl('/economic/scenario'), this.form)

        this.$emit('created', data.data)

        this.form = new EcoRefsScenarioModel().form
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false)
    }
  },
  computed: {
    scenarioRelations() {
      return [
        {
          title: this.trans('economic_reference.oil_prices'),
          singleKey: 'oil_price',
          multipleKey: 'oil_prices',
          minValue: 0
        },
        {
          title: this.trans('economic_reference.course_prices'),
          singleKey: 'dollar_rate',
          multipleKey: 'dollar_rates',
          minValue: 0
        },
        {
          title: this.trans('economic_reference.salary_optimization'),
          singleKey: 'cost_wr_payroll',
          multipleKey: 'cost_wr_payrolls',
          minValue: 0,
          maxValue: 1,
          step: 0.01
        },
        {
          title: this.trans('economic_reference.retention_percents'),
          singleKey: 'fixed_nopayroll',
          multipleKey: 'fixed_nopayrolls',
          minValue: 0,
          maxValue: 1,
          step: 0.01
        },
      ]
    }
  }
}
</script>

<style scoped>
</style>