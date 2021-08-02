<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      {{ trans('economic_reference.table_specific_indicators_title') }}
    </subtitle>

    <div class="mt-3 text-center border-grey">
      <div class="d-flex bg-blue">
        <div class="flex-50 p-3 border-grey ">
          {{ trans('economic_reference.specific_indicators') }}
        </div>

        <div class="flex-25 p-3 border-grey">
          {{ trans('economic_reference.unit_of_measurement') }}
        </div>

        <div class="flex-25 p-3 border-grey">
          {{ org.name }}
        </div>
      </div>

      <div class="d-flex bg-blue">
        <div class="flex-50 p-3 border-grey border-bottom-0">
          {{ trans('economic_reference.course_prices') }}
        </div>

        <div class="flex-25 p-3 border-grey">
          {{ trans('economic_reference.tenge') }}
        </div>

        <div class="flex-25 p-3 border-grey bg-blue">
          {{ (+scenario.dollar_rate).toLocaleString() }}
        </div>
      </div>

      <div class="d-flex bg-dark-blue">
        <div class="flex-50 p-3 border-grey d-flex align-items-center justify-content-center">
          {{ trans('economic_reference.avg_oil_price_brent') }}
        </div>

        <div class="flex-25 p-3 border-grey d-flex align-items-center justify-content-center">
          $ / bbl
        </div>

        <div class="flex-25 border-grey d-flex flex-column">
          <div v-for="(item, index) in oilPrices"
               :key="index"
               :class="index % 2 === 0 ? 'bg-light-blue' : 'bg-dark-blue'"
               class="px-2 py-3 ">
            {{ (+item).toLocaleString() }}
          </div>
        </div>
      </div>

      <div v-for="(item, index) in sumData"
           :key="index"
           :class="index % 2 === 0 ? 'bg-dark-blue' : 'bg-light-blue'"
           class="d-flex white-space-normal">
        <div class="flex-50 p-3">
          {{ item.label }}
        </div>

        <div
            class="flex-25 p-3 border-grey border-bottom-0 border-top-0 d-flex align-items-center justify-content-center">
          {{ item.dimension }}
        </div>

        <div class="flex-25 p-3">
          {{ (+item.value.toFixed(2)).toLocaleString() }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

export default {
  name: "TableSpecificIndicators",
  components: {
    Subtitle
  },
  props: {
    org: {
      required: true,
      type: Object
    },
    scenario: {
      required: true,
      type: Object
    },
    oilPrices: {
      required: true,
      type: Array
    },
    data: {
      required: true,
      type: Object
    }
  },
  computed: {
    sumData() {
      return [
        {
          label: this.trans('economic_reference.nominally_variable_costs'),
          value: this.data.avg_variable,
          dimension: this.trans('economic_reference.tenge_per_ton_liquid')
        },
        {
          label: this.trans('economic_reference.personnel_costs'),
          value: this.data.avg_fix_payroll * 12 / 1000000,
          dimension: this.trans('economic_reference.million_tenge_per_year')
        },
        {
          label: this.trans('economic_reference.krs'),
          value: this.data.avg_wo,
          dimension: this.trans('economic_reference.million_tenge_per_operation'),
        },
        {
          label: this.trans('economic_reference.conditional_fixed_costs'),
          value: this.data.avg_fix * 12 / 1000000,
          dimension: this.trans('economic_reference.million_tenge_per_year')
        },
        {
          label: this.trans('economic_reference.oar'),
          value: this.data.avg_gaoverheads * 12 / 1000000,
          dimension: this.trans('economic_reference.million_tenge_per_year')
        },
        {
          label: this.trans('economic_reference.avg_cost_prs_with_payroll'),
          value: this.data.avg_wr_nopayroll + this.data.avg_wr_payroll,
          dimension: this.trans('economic_reference.million_tenge_for_operation')
        }
      ]
    }
  }
}
</script>

<style scoped>
.border-grey {
  border: 1px solid #454D7D
}

.border-bottom-0 {
  border-bottom: unset;
}

.border-top-0 {
  border-top: unset;
}

.bg-blue {
  background: #333975;
}

.bg-dark-blue {
  background: #2B2E5E;
}

.bg-light-blue {
  background: #333868;
}

.flex-50 {
  flex: 1 0 50%;
}

.flex-25 {
  flex: 1 0 25%;
}

.white-space-normal {
  white-space: normal;
}

</style>