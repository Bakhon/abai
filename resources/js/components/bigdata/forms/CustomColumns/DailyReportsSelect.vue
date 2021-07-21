<template>
  <div>
    <select v-model="optionId">
      <option v-for="(value, id) in column.values" :value="id" :key="value.id">{{ value }}</option>
    </select>
  </div>
</template>
<script>
  export default {
    props: {
      column: Object,
      allColumns: Array,
      filter: Object,
      updateTableData: Function,
    },
    data() {
      return {
        optionId: 0,
      }
    },
    watch: {
      optionId() {
        let columnsToHide = [
            'fact',
            'daily_deviation',
            'month_fact',
            'month_deviation',
            'year_fact',
            'year_deviation'];
        let columnsToShow = [
            'daily_fact_cits',
            'daily_fact_gs',
            'cits_gs_daily_deviation',
            'month_fact_cits',
            'month_fact_gs',
            'cits_gs_month_deviation',
            'year_fact_cits',
            'year_fact_gs',
            'cits_gs_year_deviation'];
        let optionId = this.optionId;
        switch (optionId) {
            case 1:
                this.allColumns.forEach(function (item) {
                    if (item.code === 'plan' || item.code === 'fact') {
                        item.is_editable = false;
                    }
                });
                break;
            case 2:
                this.allColumns.forEach(function (item) {
                    if (columnsToHide.includes(item.code)) {
                        item.visible = false;
                    }
                    if (columnsToShow.includes(item.code)) {
                        item.visible = true;
                    }
                });
                break;
            default:
                this.allColumns.forEach(function (item) {
                    if (item.code === 'plan' || item.code === 'fact') {
                        item.is_editable = true;
                    }
                    if (columnsToHide.includes(item.code)) {
                        item.visible = true;
                    }
                    if (columnsToShow.includes(item.code)) {
                        item.visible = false;
                    }
                });
        }
        this.filter.optionId = optionId;
        this.updateTableData();
      }
    },
  }
</script>

<style scoped>
  select {
    background-color: #2C44BD;
    color: #fff;
    margin: 0.5rem;
    padding: 0.3rem;
    border-radius: 0.2rem;
  }
</style>