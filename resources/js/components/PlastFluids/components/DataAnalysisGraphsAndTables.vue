<template>
  <div class="data-analysis-graphs-and-tables">
    <div class="graph-holder">
      <div class="heading-title">
        <div>
          <img src="/img/PlastFluids/graphs.svg" />
          <p>Графики</p>
        </div>
      </div>
      <div class="content">
        <ScatterGraph
          v-if="graphData.ps.data.length"
          :series="graphData.ps"
          :type="type"
        />
      </div>
    </div>
    <DataAnalysisDataTable
      tableTitle="Таблица качества пробоотбора"
      :items="tableRows"
      :fields="tableFields"
    />
  </div>
</template>

<script>
import ScatterGraph from "./ScatterGraph.vue";
import DataAnalysisDataTable from "./DataAnalysisDataTable.vue";
import { mapState, mapActions } from "vuex";

export default {
  name: "DataAnalysisGraphsAndTables",
  components: {
    ScatterGraph,
    DataAnalysisDataTable,
  },
  data() {
    return {
      graphType: "ps_bs_ds_ms",
      type: "scatter",
    };
  },
  computed: {
    ...mapState("plastFluids", [
      "currentSubsoil",
      "currentSubsoilField",
      "currentSubsoilHorizon",
    ]),
    ...mapState("plastFluidsLocal", ["tableFields", "tableRows"]),
    graphData() {
      let allGraphData = {
        bs: { name: "Данные", data: [] },
        ms: { name: "Данные", data: [] },
        ps: { name: "Данные", data: [] },
        ds: { name: "Данные", data: [] },
      };
      this.tableRows.map((row) => {
        allGraphData.bs.data.push(row.Bs);
        allGraphData.ms.data.push(row.Ms);
        allGraphData.ps.data.push(row.Ps);
        allGraphData.ds.data.push(row.Ds);
      });
      return allGraphData;
    },
  },
  methods: {
    ...mapActions("plastFluidsLocal", ["handleTableGraphData"]),
    getMaxMin(arrayData) {
      const max = Math.max(...arrayData);
      const min = Math.min(...arrayData);
      return [min, max];
    },
    getApproximation(type, series) {
      const response = graphData.approximation;
      const response1 = graphData.approximation1;
      this.type = "line";
      this.gasGraphSeries.graph1.approximation = response;
      this.gasGraphSeries.graph1.approximation1 = response1;
    },
  },
  mounted() {
    this.handleTableGraphData({
      field_id: this.currentSubsoilField[0].field_id,
      graph_type: this.graphType,
    });
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
  width: 100%;
  height: calc(100% - 38px);
  border: 6px solid #272953;
  padding: 4px;
}
</style>
