<template>
  <div class="table-container">
    <div class="table-div">
      <div>
        <table>
            <thead>
                <tr>
                    <th class="total-thead-tr">{{trans('tr.field')}}</th>
                    <th class="total-thead-tr">{{trans('tr.oil_ton')}}</th>
                    <th class="total-thead-tr">{{trans('tr.gas_m3')}}</th>
                    <th class="total-thead-tr">{{trans('tr.liquid_m3')}}</th>
                </tr>
            </thead>
            <tbody>
            
                <tr v-for="(row, row_index) in all_summary_total" :key="row_index">
                <td :class="{'summary_total': isSummaryTotalClass(row)}">{{ row.field }}</td>
                <td :class="{'summary_total': isSummaryTotalClass(row)}">{{ row.planned_monthly_oil }}</td>
                <td :class="{'summary_total': isSummaryTotalClass(row)}">{{ row.planned_monthly_gas }}</td>
                <td :class="{'summary_total': isSummaryTotalClass(row)}">{{ row.planned_monthly_liq }}</td>
                </tr>

            </tbody>
        </table>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "totalTable",
  props: {
    filter: Boolean,
    pagination: Boolean,
    sticky: Boolean,
    allPageCount: Number,
    currentPage: Number,
    fields: Array,
    items: Array,
    handlePageChange: Function,
    all_summary_total: Array,
  },
  data() {
    return {
    };
  },
  methods: {
    isSummaryTotalClass(row) {
      if (row.is_total_row) {
          return true
      } else {
          return false
      }
    },
  }
};
</script>

<style lang="scss" scoped src="./totalTable.scss"></style>