<template>
  <div class="data-analysis-data-table">
    <div class="data-analysis-table-header">
      <div>
        <div class="title-holder">
          <img src="/img/PlastFluids/tableIcon.svg" />
          <p>{{ tableTitle }}</p>
        </div>
        <img src="/img/PlastFluids/settings.svg" alt="customize table" />
      </div>
      <div class="header-hide-expand-buttons">
        <button>
          <img
            src="/img/PlastFluids/tableArrow.svg"
            alt="expand table"
          /></button
        ><button>
          <img src="/img/PlastFluids/tableArrow.svg" alt="hide table" />
        </button>
      </div>
    </div>
    <div class="data-analysis-table-holder">
      <BaseTable :fields="fields" :items="items" :isAnalysisTable="true" />
    </div>
  </div>
</template>

<script>
import BaseTable from "./BaseTable.vue";

export default {
  name: "DataAnalysisDataTable",
  props: {
    tableTitle: String,
    items: [Array, Object],
    fields: [Array, Object],
  },
  components: {
    BaseTable,
  },
};
</script>

<style scoped>
.data-analysis-data-table {
  margin-top: 10px;
  height: 350px;
  display: flex;
  flex-flow: column;
}

.data-analysis-table-header {
  display: flex;
  align-items: center;
  width: 100%;
  height: 38px;
  padding: 6px 6px 0 6px;
  background-color: #272953;
}

.data-analysis-table-header > div {
  background-color: #323370;
  height: 32px;
}

.data-analysis-table-header > div:nth-of-type(1) {
  display: flex;
  align-items: center;
  width: 100%;
  justify-content: space-between;
  border: 1px solid #545580;
  padding: 0 11px;
}

.title-holder {
  display: flex;
}

.title-holder > img {
  width: 20px;
  height: 18px;
}

.title-holder > p {
  margin: 0;
  margin-left: 8px;
}

.header-hide-expand-buttons {
  width: 42px;
  border: 1px solid #545580;
  border-radius: 4px;
  margin-left: 4px;
}

.header-hide-expand-buttons > button {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 50%;
  border: 1px solid #545580;
  background-color: #333975;
}

.header-hide-expand-buttons > button:nth-of-type(2) > img {
  transform: rotate(180deg);
}

.data-analysis-table-holder {
  height: calc(100% - 38px);
  width: 100%;
  padding: 4px;
  border: 6px solid #272953;
}
</style>
