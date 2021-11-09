<template>
  <div class="data-analysis-maps-and-tables">
    <div
      class="structure-map-holder"
      :style="
        tableState === 'hidden'
          ? 'height: calc(100% - 38px);'
          : 'height: calc(100% - 360px);'
      "
    >
      <div class="heading-title">
        <div>
          <img src="/img/PlastFluids/mapsAndTablesHeadingIcon.svg" />
          <p>{{ trans("plast_fluids.detailed_statistics_by_research") }}</p>
        </div>
      </div>
      <div class="content">
        <StructuralMap />
      </div>
    </div>
    <DataAnalysisDataTable
      imagePath="/img/PlastFluids/sampleDataIcon.png"
      tableTitle="sample_data"
      :fields="fields"
      :items="items"
    />
  </div>
</template>

<script>
import DataAnalysisDataTable from "../DataAnalysisDataTable.vue";
import StructuralMap from "./StructuralMap.vue";
import { mapState } from "vuex";

export default {
  name: "DataAnalysisMapsAndTables",
  components: {
    DataAnalysisDataTable,
    StructuralMap,
  },
  computed: {
    ...mapState("plastFluidsLocal", ["tableState"]),
  },
  data() {
    return {
      cartFull: false,
      fields: [
        "№ скважины",
        "Дата отбора",
        "Абс. отм. середины инт. перф., середина, м",
        "Давление исследования, МПа",
        "Температура исследования, С°",
        "Давление насыщения, МПа",
        "Вязкость пластовой нефти, мПа* с",
        "Вязкость пластовой нефти при Ps, мПа* с",
        "Плотность пластовой нефти при Рисл, кг/м3",
        "Плотность пластовой нефти при Ps, кг/м3",
        "Газосодержание, м3/м3",
        "Газосодержание, м3/т",
        "Объёмный коэффициент при Рисл",
        "Объёмный коэффициент при Рb",
        "Плотность сепарированной нефти, кг/м3",
        "Плотность сепарированного газа, кг/м3",
        "Отклонение от материального баланса, %",
        "Исполнитель",
      ],
      items: [],
    };
  },
  methods: {
    pushData() {
      for (let i = 0; i < 40; i++) {
        this.items.push([
          "П2",
          "01.01.1983",
          "-3419",
          "Pgor",
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
        ]);
      }
    },
  },
  mounted() {
    this.pushData();
  },
};
</script>

<style scoped>
.data-analysis-maps-and-tables {
  display: flex;
  flex-flow: column;
  width: 100%;
  height: 100%;
  color: #fff;
}

.structure-map-holder {
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
</style>
