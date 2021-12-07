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
          key="gtm_log_id"
          :form="form"
          :fetch-params="{type_id: EconomicDataLogTypeModel.GTM}"
          form-key="gtm_log_id"/>
    </div>

    <div v-show="form.gtm_log_id">
      <h5 class="text-secondary mt-3">
        {{ trans('economic_reference.technical_data') }}
      </h5>

      <select-log
          key="gtm_value_log_id"
          :form="form"
          :fetch-params="{type_id: EconomicDataLogTypeModel.GTM_VALUE}"
          form-key="gtm_value_log_id"/>
    </div>

    <div v-show="form.gtm_value_log_id"
         class="text-center mt-3">
      <save-button @click.native="saveForm"/>
    </div>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import SelectLog from "../../../components/SelectLog";
import SaveButton from "../../../components/SaveButton";

import {EconomicDataLogTypeModel} from "../../../models/EconomicDataLogTypeModel";
import {EcoRefsGtmKitModel} from "../../../models/EcoRefsGtmKitModel";

export default {
  name: "GtmKitForm",
  components: {
    SelectLog,
    SaveButton
  },
  data: () => ({
    EconomicDataLogTypeModel,
    form: new EcoRefsGtmKitModel().form
  }),
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async saveForm() {
      this.SET_LOADING(true)

      try {
        const {data} = await this.axios.post(this.url, this.form)

        this.$emit('created', data)

        this.form = new EcoRefsGtmKitModel().form
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false)
    }
  },
  computed: {
    url() {
      return this.localeUrl('/economic/gtm/kit')
    }
  }
}
</script>

<style scoped>

</style>