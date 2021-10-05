<template>
  <div class="px-3 py-2 bg-blue-dark position-relative">
    <economic-title
        font-size="26"
        line-height="36"
        class="text-nowrap">
      <span> {{ header.value.toFixed(2) }} </span>

      <span class="text-blue font-size-16px line-height-20px">
             {{ header.dimension }}
      </span>
    </economic-title>

    <subtitle font-size="16" class="line-height-18px"> {{ header.name }}</subtitle>

    <percent-progress v-if="form.scenario_id" :percent="header.percent"/>

    <div v-if="form.scenario_id"
         class="d-flex font-size-12px line-height-14px mb-2">
      <div class="flex-grow-1 text-blue">
        {{ (100 + header.percent).toFixed(2) }} %
      </div>

      <div>{{ header.baseValue.toFixed(2) }}</div>
    </div>

    <div v-if="form.scenario_id"
         class="d-flex align-items-center">
      <percent-badge
          :percent="header.percent.toFixed(2)"
          class="text-nowrap mr-2 font-size-16px line-height-18px"
          reverse/>

      <div class="flex-grow-1 text-blue font-size-12px line-height-16px text-right">
        {{ trans('economic_reference.vs_base_case') }}
      </div>
    </div>
  </div>
</template>

<script>
import EconomicTitle from "./EconomicTitle";
import Subtitle from "./Subtitle";
import PercentProgress from "./PercentProgress";
import PercentBadge from "./PercentBadge";

export default {
  name: "CalculatedHeader",
  components: {
    EconomicTitle,
    Subtitle,
    PercentProgress,
    PercentBadge,
  },
  props: {
    header: {
      required: true,
      type: Object
    },
    form: {
      required: true,
      type: Object
    }
  }
}
</script>

<style scoped>
.bg-blue-dark {
  background: #2B2E5E;
}

.font-size-12px {
  font-size: 12px;
}

.font-size-16px {
  font-size: 16px;
}

.line-height-14px {
  line-height: 14px;
}

.line-height-16px {
  line-height: 16px;
}

.line-height-18px {
  line-height: 18px;
}

.line-height-20px {
  line-height: 20px;
}

.text-blue {
  color: #82BAFF;
}
</style>