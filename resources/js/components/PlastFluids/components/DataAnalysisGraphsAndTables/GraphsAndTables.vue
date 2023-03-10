<template>
  <div class="data-analysis-graphs-and-tables">
    <template v-if="currentSubsoilField[0] && currentSubsoilField[0].field_id">
      <div
        class="graph-holder"
        :style="
          tableState === 'hidden'
            ? 'height: calc(100% - 38px);'
            : tableState === 'expanded'
            ? 'height: 38px;'
            : 'height: calc(100% - 360px);'
        "
      >
        <div
          :class="[
            'heading-title',
            { 'extra-padding': tableState === 'expanded' },
          ]"
        >
          <div>
            <img src="/img/PlastFluids/graphs.svg" />
            <p>{{ trans("plast_fluids.graphs") }}</p>
          </div>
        </div>
        <div
          v-if="isDataReady"
          v-show="tableState !== 'expanded'"
          class="content"
        >
          <div
            v-for="graph in sortedCurrentGraphics"
            :key="graph.order"
            class="content-child"
            :style="
              currentGraphics.length > 2
                ? 'height: calc(50% - 3px);'
                : 'height: calc(100% - 6px);'
            "
          >
            <ScatterGraph
              :series="
                graphData[graph.key] ? graphData[graph.key] : emptySeriesObject
              "
              :title="trans(`plast_fluids.${graphType}_graph_${graph.key}`)"
              :graphType="graph.key"
              :currentGraphs="sortedCurrentGraphics"
              :defaultIntersection="
                defaultIntersection[graph.key.toLowerCase()]
              "
            />
          </div>
        </div>
        <SmallCatLoader :loading="loading" v-else />
      </div>
      <DataAnalysisDataTable
        imagePath="/img/PlastFluids/tableIcon.svg"
        tableTitle="sampling_quality_table"
        :items="analysisTableRows"
        :fields="analysisTableFields"
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
  data() {
    return {
      emptySeriesObject: {
        name: "????????????",
        data: [],
        data2: [],
        type: "scatter",
        config: { minX: "auto", maxX: "auto", minY: "auto", maxY: "auto" },
      },
    };
  },
  computed: {
    ...mapState("plastFluids", [
      "currentSubsoil",
      "currentSubsoilField",
      "currentSubsoilHorizon",
      "currentBlocks",
      "analysisTableFields",
      "analysisTableRows",
    ]),
    ...mapState("plastFluidsLocal", [
      "tableState",
      "graphType",
      "loading",
      "currentGraphics",
      "defaultIntersection",
    ]),
    graphData() {
      const zeroX = ["Ps", "Bs", "Ds", "Ms"];
      const zeroY = ["Ps", "Rs"];
      const keys = Object.keys(this.analysisTableRows[0] ?? "");
      let allGraphData = {};
      for (let i = 0; i < keys.length; i++) {
        if (keys[i] === "key" || keys[i] === "table_data") {
          continue;
        }
        allGraphData[keys[i]] = {};
        allGraphData[keys[i]].name = "????????????";
        allGraphData[keys[i]].data = [];
        allGraphData[keys[i]].data2 = [];
        allGraphData[keys[i]].type = "scatter";
        allGraphData[keys[i]].config = {
          minX: zeroX.includes(keys[i]) ? 0 : "auto",
          maxX: "auto",
          minY: zeroY.includes(keys[i]) ? 0 : keys[i] === "Bs" ? 1 : "auto",
          maxY: "auto",
        };
        const conf = this.getFloatNumber(keys[i]);
        allGraphData[keys[i]].config = {
          ...allGraphData[keys[i]].config,
          ...conf,
        };
      }
      const fKeys = Object.keys(allGraphData);
      this.analysisTableRows.forEach((row) => {
        for (let i = 0; i < fKeys.length; i++) {
          const sample = { wellName: row.table_data[4], ...row[fKeys[i]] };
          if (sample.x2) {
            allGraphData[fKeys[i]].data2.push({
              x: sample.x2,
              y: sample.y,
              wellName: sample.wellName,
              key: sample.key,
            });
          }
          allGraphData[fKeys[i]].data.push(sample);
        }
      });
      return allGraphData;
    },
    isDataReady() {
      return (
        Object.keys(this.graphData).length &&
        !Object.keys(this.graphData).some(
          (key) => !this.graphData[key].data.length
        ) &&
        !this.loading
      );
    },
    sortedCurrentGraphics() {
      return this.currentGraphics.sort((a, b) => a.order - b.order);
    },
  },
  watch: {
    currentSubsoilField: {
      handler(value) {
        this.handleAnalysisTableData({
          field_id: value[0].field_id,
          postUrl: "analytics/pvt-data-analysis",
        });
      },
      deep: true,
    },
    currentSubsoilHorizon() {
      this.handleAnalysisTableData({
        field_id: this.currentSubsoilField[0].field_id,
        postUrl: "analytics/pvt-data-analysis",
      });
    },
    currentBlocks() {
      this.handleAnalysisTableData({
        field_id: this.currentSubsoilField[0].field_id,
        postUrl: "analytics/pvt-data-analysis",
      });
    },
  },
  methods: {
    ...mapActions("plastFluids", ["handleAnalysisTableData"]),
    getFloatNumber(key) {
      const config = {
        x: 1,
        y: 1,
      };
      switch (this.graphType) {
        case "ps_bs_ds_ms":
          config.y =
            key === "Ps"
              ? 2
              : key === "Bs"
              ? 3
              : key === "Ds"
              ? 1
              : key === "Ms"
              ? 0.3
              : 1;
          break;
        case "data_rs_ps_ds":
          config.x = "remain";
          config.y = key === "Ps" ? 2 : key === "Ms" ? 0.3 : 1;
          break;
        case "all_depth":
          config.x = key === "pi_ps" ? 2 : key === "volume_coefficient" ? 3 : 1;
          break;
      }
      return config;
    },
  },
  async mounted() {
    if (this.currentSubsoilField[0]?.field_id) {
      await this.handleAnalysisTableData({
        field_id: this.currentSubsoilField[0].field_id,
        postUrl: "analytics/pvt-data-analysis",
      });
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

.extra-padding {
  padding: 6px;
  height: 44px;
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
  flex: 1 1 calc(50% - 3px);
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
