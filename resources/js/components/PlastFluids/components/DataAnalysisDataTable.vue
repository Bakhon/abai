<template>
  <div
    class="data-analysis-data-table"
    :style="tableState === 'hidden' ? 'height: 38px;' : ''"
  >
    <div class="data-analysis-table-header">
      <div>
        <div class="title-holder">
          <img :src="imagePath" />
          <p>{{ trans("plast_fluids." + tableTitle) }}</p>
        </div>
        <img src="/img/PlastFluids/settings.svg" alt="customize table" />
      </div>
      <div class="header-hide-expand-buttons">
        <button @click="SET_TABLE_STATE('default')">
          <img
            src="/img/PlastFluids/tableArrow.svg"
            alt="expand table"
          /></button
        ><button @click="SET_TABLE_STATE('hidden')">
          <img src="/img/PlastFluids/tableArrow.svg" alt="hide table" />
        </button>
      </div>
    </div>
    <div v-show="tableState !== 'hidden'" class="data-analysis-table-holder">
      <SmallCatLoader v-if="loading" :loading="loading" />
      <BaseTable
        v-else
        :fields="fields"
        :items="items"
        tableType="analysis"
        :sticky="true"
        :currentSelectedRow="handleRowSelectState"
        @select-row="selectTableRow"
        :currentRoute="reservoilOilInfo[1]"
      />
    </div>
  </div>
</template>

<script>
import BaseTable from "./BaseTable.vue";
import SmallCatLoader from "./SmallCatLoader.vue";
import { mapState, mapMutations } from "vuex";

export default {
  name: "DataAnalysisDataTable",
  props: {
    imagePath: String,
    tableTitle: String,
    items: [Array, Object],
    fields: [Array, Object],
  },
  inject: { reservoilOilInfo: { default: "template" } },
  components: {
    BaseTable,
    SmallCatLoader,
  },
  computed: {
    ...mapState("plastFluidsLocal", [
      "loading",
      "tableState",
      "currentSelectedSamples",
      "currentModel",
      "currentSelectedWell",
    ]),
    handleRowSelectState() {
      let state = {};
      switch (this.reservoilOilInfo[1]) {
        case "graphs-and-tables":
          state = this.currentSelectedSamples;
          break;
        case "maps-and-tables":
          state = this.currentSelectedWell;
          break;
      }
      return state;
    },
  },
  methods: {
    ...mapMutations("plastFluidsLocal", [
      "SET_TABLE_STATE",
      "SET_CURRENT_SELECTED_SAMPLES",
      "SET_CURRENT_SELECTED_WELL",
    ]),
    selectTableRow(row) {
      switch (this.reservoilOilInfo[1]) {
        case "graphs-and-tables":
          this.SET_CURRENT_SELECTED_SAMPLES(row.item.key);
          break;
        case "maps-and-tables":
          !this.currentModel.id
            ? ""
            : this.SET_CURRENT_SELECTED_WELL({
                id: row.item.key,
                index: row.index,
              });
          break;
      }
    },
  },
};
</script>

<style scoped>
.data-analysis-data-table {
  margin-top: 10px;
  max-height: 350px;
  display: flex;
  flex-flow: column;
  transition: 0.2s ease-in;
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
  align-items: center;
}

.title-holder > img {
  width: 20px;
  height: 18px;
}

.title-holder > p {
  margin: 0;
  margin-left: 8px;
  color: #fff;
  font-size: 16px;
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
