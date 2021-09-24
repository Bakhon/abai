<template>
  <div class="data-analysis-graphs-and-tables">
    <template v-if="currentSubsoilField[0] && currentSubsoilField[0].field_id">
      <div class="graph-holder">
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
  data() {
    return {
      graphType: "ps_bs_ds_ms",
    };
  },
  computed: {
    ...mapState("plastFluids", [
      "currentSubsoil",
      "currentSubsoilField",
      "currentSubsoilHorizon",
    ]),
    ...mapState("plastFluidsLocal", ["tableFields", "tableRows", "loading"]),
    graphData() {
      let allGraphData = {
        ps: { name: "Данные", data: [], type: "scatter" },
        bs: { name: "Данные", data: [], type: "scatter" },
        ds: { name: "Данные", data: [], type: "scatter" },
        ms: { name: "Данные", data: [], type: "scatter" },
      };
      this.tableRows.forEach((row) => {
        allGraphData.bs.data.push(row.Bs);
        allGraphData.ms.data.push(row.Ms);
        allGraphData.ps.data.push(row.Ps);
        allGraphData.ds.data.push(row.Ds);
      });
      return allGraphData;
    },
    isDataReady() {
      return !Object.keys(this.graphData).some(
        (key) => !this.graphData[key].data.length
      );
    },
  },
  methods: {
    ...mapActions("plastFluidsLocal", ["handleTableGraphData"]),
    getMaxMin(arrayData) {
      const max = Math.max(...arrayData);
      const min = Math.min(...arrayData);
      return [min, max];
    },
  },
  mounted() {
    if (this.currentSubsoilField[0]?.field_id) {
      this.handleTableGraphData({
        field_id: this.currentSubsoilField[0].field_id,
        graph_type: this.graphType,
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
}

.content-child {
  min-height: 180px;
  width: calc(50% - 3px);
}

.content-child:nth-of-type(1),
.content-child:nth-of-type(2) {
  margin-bottom: 6px;
}

.content-child:nth-of-type(even) {
  margin-left: 6px;
}
</style>
