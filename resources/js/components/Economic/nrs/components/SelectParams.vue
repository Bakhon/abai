<template>
  <div :class="isFullscreen ? 'd-flex align-items-center' : ''"
       class="bg-main1 p-3 text-white text-wrap">
    <div v-if="!isFullscreen"
         class="font-size-16px line-height-14px font-weight-bold mb-3">
      {{ trans('economic_reference.select_data_display_options') }}
    </div>

    <select-interval
        :form="form"
        :class="isFullscreen ? 'flex-shrink-0 mr-1' : 'mb-2'"
        @change="$emit('update')"/>

    <select-granularity
        :form="form"
        :class="isFullscreen ? 'ml-2' : 'mb-2'"
        @change="$emit('update')"/>

    <select-profitability
        :form="form"
        :class="isFullscreen ? 'ml-2' : 'mb-2'"
        @change="$emit('update')"/>

    <select-organization
        :form="form"
        :class="isFullscreen ? 'ml-2' : 'mb-2'"
        hide-label
        @change="$emit('update')"/>

    <div :class="isFullscreen ? 'flex-shrink-0 ml-2' : ''"
         class="d-flex">
      <select-field
          v-if="form.org_id"
          :org_id="form.org_id"
          :form="form"
          @change="$emit('update')"/>

      <input-exclude-uwis :form="form" class="ml-2"/>

      <div class="ml-2">
        <fullscreen-button @click.native="$emit('fullscreen')"/>
      </div>
    </div>

    <button
        v-if="!isFullscreen"
        class="btn btn-primary w-100 border-0 bg-export py-2"
        style="margin-top: 10px;">
      {{ trans('economic_reference.export_excel') }}
    </button>
  </div>
</template>

<script>
import SelectInterval from "./SelectInterval";
import SelectGranularity from "../../components/SelectGranularity";
import SelectProfitability from "./SelectProfitability";
import SelectOrganization from "../../components/SelectOrganization";
import SelectField from "./SelectField";
import InputExcludeUwis from "./InputExcludeUwis";
import FullscreenButton from "./FullscreenButton";

export default {
  name: "SelectParams",
  components: {
    SelectInterval,
    SelectGranularity,
    SelectProfitability,
    SelectOrganization,
    SelectField,
    InputExcludeUwis,
    FullscreenButton,
  },
  props: {
    form: {
      required: true,
      type: Object
    },
    isFullscreen: {
      required: false,
      type: Boolean
    }
  }
}
</script>

<style scoped>
.font-size-16px {
  font-size: 16px;
}

.line-height-14px {
  line-height: 14px;
}

.bg-export {
  background: #213181;
}
</style>