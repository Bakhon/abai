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

      <select-log
          key="economic_log_id"
          :form="form"
          :fetch-params="{type_id: EconomicDataLogTypeModel.ANALYSIS_PARAM}"
          form-key="economic_log_id"/>
    </div>

    <div v-show="form.economic_log_id">
      <h5 class="text-secondary mt-3">
        {{ trans('economic_reference.technical_data') }}
      </h5>

      <select-log
          key="technical_log_id"
          :form="form"
          :fetch-params="{type_id: EconomicDataLogTypeModel.WELL_FORECAST, is_processed: 1}"
          form-key="technical_log_id"/>
    </div>

    <div v-show="form.technical_log_id" class="text-center">
      <div class="text-left">
        <h5 class="text-secondary mt-3">
          {{ trans('economic_reference.permanent_stop_coefficient') }}
        </h5>

        <div v-for="(coefficient, index) in form.permanent_stop_coefficients"
             :key="index"
             class="form-group d-flex">
          <input v-model="coefficient.value"
                 :min="0"
                 :max="1"
                 :step="0.01"
                 type="numeric"
                 class="form-control">

          <delete-button
              class="ml-2"
              @click.native="deleteCoefficient(index)"/>
        </div>

        <add-button @click.native="addCoefficient()"/>
      </div>

      <save-button @click.native="saveForm"/>
    </div>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import SelectLog from "../../../components/SelectLog";
import AddButton from "../../../components/AddButton";
import DeleteButton from "../../../components/DeleteButton";
import SaveButton from "../../../components/SaveButton";

import {EconomicDataLogTypeModel} from "../../../models/EconomicDataLogTypeModel";
import {TechnicalWellForecastKitModel} from "../../../models/TechnicalWellForecastKitModel";

export default {
  name: "TechnicalWellForecastKitForm",
  components: {
    SelectLog,
    AddButton,
    DeleteButton,
    SaveButton
  },
  data: () => ({
    EconomicDataLogTypeModel,
    form: new TechnicalWellForecastKitModel().form
  }),
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async saveForm() {
      this.SET_LOADING(true)

      try {
        const {data} = await this.axios.post(this.url, this.form)

        this.$emit('created', data)

        this.form = new TechnicalWellForecastKitModel().form
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false)
    },

    addCoefficient() {
      this.form.permanent_stop_coefficients.push(
          new TechnicalWellForecastKitModel().permanent_stop_coefficient
      )
    },

    deleteCoefficient(index) {
      if (this.form.permanent_stop_coefficients.length < 2) return

      this.form.permanent_stop_coefficients.splice(index, 1)
    },
  },
  computed: {
    url() {
      return this.localeUrl('/economic/technical/well_forecast/kit')
    }
  }
}
</script>

<style scoped>

</style>