<template>
  <div class="bg-main1 text-white text-wrap mb-10px">
    <div v-for="(param, index) in params"
         :key="param.name"
         :class="index ? 'border-grey-top' : ''"
         class="d-flex font-size-14px line-height-16px">
      <div class="pl-3 py-2 flex-150px text-wrap">
        {{ param.name }}
      </div>

      <div class="mx-2 p-2 bg-grey flex-120px">
        {{ param.dimension }}
      </div>

      <div class="p-2 flex-120px">
        {{ param.value }}
      </div>
    </div>
  </div>
</template>

<script>
import {formatValueMixin} from "../../mixins/formatMixin";

export default {
  name: "AnalysisBlock",
  mixins: [
    formatValueMixin
  ],
  props: {
    analysisParams: {
      required: true,
      type: Array
    }
  },
  computed: {
    params() {
      let params = this.analysisParams && this.analysisParams.length
          ? this.analysisParams[0]
          : {
            date: '',
            netback_forecast: 0,
            variable_cost: 0,
            permanent_cost: 0,
            avg_prs_cost: 0,
            oil_density: 0,
            days: 0,
            permanent_stop_cost: 0,
          }

      return [
        {
          name: this.trans('economic_reference.month'),
          value: params.date,
          dimension: '',
        },
        {
          name: this.trans('economic_reference.netback_forecast'),
          value: this.localeValue(params.netback_forecast),
          dimension: this.trans('economic_reference.tenge_per_ton'),
        },
        {
          name: this.trans('economic_reference.variable_cost'),
          value: this.localeValue(params.variable_cost),
          dimension: this.trans('economic_reference.tn_per_ton_liquid'),
        },
        {
          name: this.trans('economic_reference.conditional_fixed_costs'),
          value: this.localeValue(params.permanent_cost),
          dimension: this.trans('economic_reference.conditional_fixed_costs_dimension'),
        },
        {
          name: this.trans('economic_reference.avg_cost_prs'),
          value: this.localeValue(params.avg_prs_cost),
          dimension: this.trans('economic_reference.avg_cost_prs_dimension'),
        },
        {
          name: this.trans('economic_reference.oil_density'),
          value: this.localeValue(params.oil_density),
          dimension: `
            ${this.trans('economic_reference.tn')}/
            ${this.trans('economic_reference.cubic_meter')}
          `
        },
        {
          name: this.trans('economic_reference.days_in_month'),
          value: this.localeValue(params.days),
          dimension: this.trans('economic_reference.days'),
        },
        {
          name: this.trans('economic_reference.permanent_stop_cost'),
          value: this.localeValue(params.permanent_stop_cost),
          dimension: ''
        }
      ]
    },
  }
}
</script>

<style scoped>
.bg-grey {
  background: #313560;
}

.border-grey-top {
  border-top: 1px solid #454D7D;
}

.font-size-14px {
  font-size: 12px;
}

.line-height-16px {
  line-height: 16px;
}

.flex-120px {
  flex: 1 0 120px;
}

.flex-150px {
  flex: 1 0 150px;
}
</style>