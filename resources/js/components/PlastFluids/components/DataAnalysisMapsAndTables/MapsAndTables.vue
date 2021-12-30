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
      <div class="heading-title-wrapper">
        <div class="heading-title">
          <img
            @click.stop="isMapSettingsOpen = true"
            src="/img/PlastFluids/mapsAndTablesMapSettings.png"
            alt="map settings"
          />
          <StructuralMapSettingsModal
            v-show="isMapSettingsOpen"
            @close-modal="isMapSettingsOpen = false"
          />
        </div>
      </div>
      <div class="content">
        <StructuralMap />
      </div>
    </div>
    <DataAnalysisDataTable
      imagePath="/img/PlastFluids/sampleDataIcon.png"
      tableTitle="sample_data"
      :fields="analysisTableFields"
      :items="analysisTableRows"
    />
  </div>
</template>

<script>
import DataAnalysisDataTable from "../DataAnalysisDataTable.vue";
import StructuralMap from "./StructuralMap.vue";
import StructuralMapSettingsModal from "./StructuralMapSettingsModal.vue";
import { mapState, mapActions, mapMutations } from "vuex";
import { getModels } from "../../services/mapService";

export default {
  name: "DataAnalysisMapsAndTables",
  components: {
    DataAnalysisDataTable,
    StructuralMap,
    StructuralMapSettingsModal,
  },
  data() {
    return {
      isMapSettingsOpen: false,
    };
  },
  computed: {
    ...mapState("plastFluids", [
      "currentSubsoilField",
      "currentSubsoilHorizon",
      "analysisTableFields",
      "analysisTableRows",
    ]),
    ...mapState("plastFluidsLocal", ["tableState", "currentModel"]),
  },
  watch: {
    currentSubsoilField: {
      handler(value) {
        this.handleAnalysisTableData({
          field_id: value[0].field_id,
          postUrl: "map/isogyps-wells-table",
        });
      },
      deep: true,
    },
    currentSubsoilHorizon: {
      handler(value) {
        if (value.length) {
          this.getHorizonModels(value);
          return;
        }
        this.SET_MODELS([]);
      },
      deep: true,
    },
  },
  methods: {
    ...mapMutations("plastFluidsLocal", ["SET_MODELS", "SET_CURRENT_MODEL"]),
    ...mapActions("plastFluids", ["handleAnalysisTableData"]),
    async getHorizonModels(horizons) {
      const horizonIDs = horizons.map((horizon) => horizon.horizon_id);
      const data = await getModels(horizonIDs);
      this.SET_MODELS(data.models);
      if (
        (!horizonIDs.includes(this.currentModel.horizon_id) ||
          !this.currentModel.id) &&
        data.models.length
      )
        this.SET_CURRENT_MODEL(data.models[0]);
    },
  },
  async mounted() {
    if (this.currentSubsoilField[0]?.field_id) {
      await this.handleAnalysisTableData({
        field_id: this.currentSubsoilField[0].field_id,
        postUrl: "map/isogyps-wells-table",
      });
      if (this.currentSubsoilHorizon.length)
        this.getHorizonModels(this.currentSubsoilHorizon);
    }
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

.heading-title-wrapper {
  height: 38px;
  padding: 6px 6px 0 6px;
  background: #272953;
  display: flex;
  align-items: center;
}

.heading-title {
  display: flex;
  position: relative;
  align-items: center;
  justify-content: flex-end;
  width: 100%;
  height: 32px;
  border: 1px solid #545580;
  background: #323370;
  padding: 0 11px;
}

.heading-title > img {
  cursor: pointer;
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
