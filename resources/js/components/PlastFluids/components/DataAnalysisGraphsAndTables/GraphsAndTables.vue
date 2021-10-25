<template>
  <div class="data-analysis-graphs-and-tables">
    <template v-if="currentSubsoilField[0] && currentSubsoilField[0].field_id">
      <div
        class="graph-holder"
        :style="
          tableState === 'hidden'
            ? 'height: calc(100% - 38px);'
            : 'height: calc(100% - 360px);'
        "
      >
        <div class="heading-title">
          <div>
            <img src="/img/PlastFluids/graphs.svg" />
            <p>{{ trans("plast_fluids.graphs") }}</p>
          </div>
        </div>
        <div v-if="isDataReady" class="content">
          <div
            v-for="(graph, key) in graphData"
            :key="key"
            class="content-child"
            :style="
              Object.keys(graphData).length > 2
                ? 'height: calc(50% - 3px);'
                : 'height: calc(100% - 6px);'
            "
          >
            <ScatterGraph
              :series="graph"
              :title="trans(`plast_fluids.${graphType}_graph_${key}`)"
              :graphType="key"
            />
          </div>
        </div>
        <SmallCatLoader :loading="loading" v-else />
      </div>
      <DataAnalysisDataTable
        tableTitle="sampling_quality_table"
        :items="tableRows"
        :fields="tableFields"
      />
    </template>
    <p v-else>{{ trans("plast_fluids.no_field_selected") }}</p>
  </div>
</template>

<script>
import SmallCatLoader from "../SmallCatLoader.vue";
import ScatterGraph from "../ScatterGraph.vue";
import DataAnalysisDataTable from "../DataAnalysisDataTable.vue";
import { mapState, mapActions } from "vuex";

export default {
  name: "DataAnalysisGraphsAndTables",
  components: {
    ScatterGraph,
    DataAnalysisDataTable,
    SmallCatLoader,
  },
  computed: {
    ...mapState("plastFluids", [
      "currentSubsoil",
      "currentSubsoilField",
      "currentSubsoilHorizon",
    ]),
    ...mapState("plastFluidsLocal", [
      "tableFields",
      "tableRows",
      "tableState",
      "loading",
      "graphType",
    ]),
    graphData() {
      const zeroX = ["Ps", "Bs", "Ds", "Ms"];
      const zeroY = ["Ps", "Rs"];
      const keys = Object.keys(this.tableRows[0] ?? "");
      let allGraphData = {};
      for (let i = 0; i < keys.length; i++) {
        if (keys[i] === "key" || keys[i] === "table_data") {
          continue;
        }
        allGraphData[keys[i]] = {};
        allGraphData[keys[i]].name = "Данные";
        allGraphData[keys[i]].data = [];
        allGraphData[keys[i]].type = "scatter";
        allGraphData[keys[i]].config = {
          minX: zeroX.includes(keys[i]) ? 0 : "auto",
          maxX: "auto",
          minY: zeroY.includes(keys[i]) ? 0 : keys[i] === "Bs" ? 1 : "auto",
          maxY: "auto",
        };
      }
      const fKeys = Object.keys(allGraphData);
      this.tableRows.forEach((row) => {
        for (let i = 0; i < fKeys.length; i++) {
          allGraphData[fKeys[i]].data.push(row[fKeys[i]]);
        }
      });
      return allGraphData;
    },
    isDataReady() {
      return (
        Object.keys(this.graphData).length &&
        !Object.keys(this.graphData).some(
          (key) => !this.graphData[key].data.length
        )
      );
    },
  },
  watch: {
    currentSubsoilField: {
      handler(value) {
        this.handleTableGraphData({ field_id: value[0].field_id });
      },
      deep: true,
    },
  },
  methods: {
    ...mapActions("plastFluidsLocal", [
      "handleTableGraphData",
      "handleBlocksFilter",
    ]),
    setConfig() {},
    getMaxMin(arrayData) {
      const max = Math.max(...arrayData);
      const min = Math.min(...arrayData);
      return [min, max];
    },
  },
  async mounted() {
    if (this.currentSubsoilField[0]?.field_id) {
      await this.handleTableGraphData({
        field_id: this.currentSubsoilField[0].field_id,
      });
      this.handleBlocksFilter(this.currentSubsoilHorizon);
    }
  },
};
</script>

<style scoped>
.data-analysis-graphs-and-tables {
  display: flex;
  flex-flow: column;
  width: 100%;
  height: 100%;
  color: #fff;
}

.data-analysis-graphs-and-tables > p {
  font-size: 34px;
  color: #fff;
  align-self: center;
}

.graph-holder {
  display: flex;
  flex-flow: column;
  flex: 2 1 auto;
}

.heading-title {
  height: 38px;
  padding: 6px 6px 0 6px;
  background: #272953;
}

.heading-title > div {
  display: flex;
  align-items: center;
  width: 100%;
  height: 32px;
  border: 1px solid #545580;
  background: #323370;
}

.heading-title > div > img {
  width: 18px;
  height: 18px;
  margin-left: 11px;
}

.heading-title > div > p {
  margin: 0 0 0 9px;
  font-size: 16px;
}

.content {
  display: flex;
  flex-wrap: wrap;
  width: 100%;
  height: calc(100% - 38px);
  border: 6px solid #272953;
  padding: 4px;
  overflow: hidden;
}

.content-child {
  width: calc(50% - 3px);
  overflow: auto;
  padding: 0;
  min-height: 0;
}

.content-child:nth-of-type(1),
.content-child:nth-of-type(2) {
  margin-bottom: 6px;
}

.content-child:nth-of-type(even) {
  margin-left: 6px;
}
</style>
