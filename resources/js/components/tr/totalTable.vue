<template>
  <div class="table-container">
    <div class="table-div">
      <div>
        <table>
            <thead>
                <tr>
                    <th>{{trans('tr.field')}}</th>
                    <th>{{trans('tr.oil_ton')}}</th>
                    <th>{{trans('tr.gas_m3')}}</th>
                    <th>{{trans('tr.liquid_m3')}}</th>
                </tr>
            </thead>
            <tbody>
            
                <tr v-for="(row, row_index) in all_summary_total" :key="row_index">
                <td>{{ row.field }}</td>
                <td>{{ row.planned_monthly_oil }}</td>
                <td>{{ row.planned_monthly_gas }}</td>
                <td>{{ row.planned_monthly_liq }}</td>
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
};
</script>

<style lang="scss" scoped src="./totalTable.scss"></style>