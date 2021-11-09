<template>
  <div class="data-analysis-panel">
    <div class="main-content-holder">
      <div class="content-holder">
        <div class="content-heading">
          <img
            src="/img/PlastFluids/mapsAndTablesSettings.svg"
            alt="map settings"
          />
          <p>{{ trans("plast_fluids.settings") }}</p>
        </div>
        <div class="content">
          <div class="settings-input-holder">
            <input type="radio" id="field settings" />
            <label for="field settings">Все по месторождению</label>
          </div>
          <div class="settings-input-holder">
            <input type="radio" id="horizon settings" />
            <label for="horizon settings">По Горизонту</label>
          </div>
        </div>
      </div>
      <div class="content-holder">
        <div class="content-heading">
          <img
            src="/img/PlastFluids/mapsAndTablesFileUpload.svg"
            alt="file upload"
          />
          <p>{{ trans("plast_fluids.settings") }}</p>
        </div>
        <div class="content">
          <div class="file-upload-holder">
            <p>Структурная карта</p>
            <Dropdown
              :items="models"
              :dropKey="'description_' + currentLang"
              :selectedValue="currentModel['description_' + currentLang]"
              @dropdown-select="SET_CURRENT_MODEL"
            />
          </div>
          <div class="file-upload-holder">
            <p>Схема разломов</p>
            <Dropdown dropKey="name" />
          </div>
          <div class="file-upload-holder">
            <p>Схема контактов</p>
            <Dropdown dropKey="name" />
          </div>
          <div class="file-upload-holder">
            <p>Тип пробы</p>
            <Dropdown dropKey="name" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Dropdown from "../Dropdown.vue";
import { mapState, mapMutations } from "vuex";
import { getIsohypsumModel } from "../../services/mapService";

export default {
  name: "DataAnalysisMapTablePanel",
  components: {
    Dropdown,
  },
  computed: {
    ...mapState("plastFluids", ["currentSubsoilHorizon"]),
    ...mapState("plastFluidsLocal", ["models", "currentModel"]),
  },
  methods: {
    ...mapMutations("plastFluidsLocal", ["SET_MODELS", "SET_CURRENT_MODEL"]),
    async getModels() {
      const data = await getIsohypsumModel(
        this.currentSubsoilHorizon[0].horizon_id
      );
      this.SET_MODELS(data.models);
    },
  },
  mounted() {
    if (this.currentSubsoilHorizon[0].horizon_id) this.getModels();
  },
};
</script>

<style scoped>
.data-analysis-panel {
  display: flex;
  flex-flow: column;
  justify-content: space-between;
  background: #272953;
  width: 100%;
  height: 100%;
}

.data-analysis-panel__area {
  padding: 4px 8px;
}

.content-holder {
  width: 100%;
  margin-bottom: 10px;
}

.content-heading {
  width: 100%;
  padding: 6px 10px;
  display: flex;
  align-items: center;
  background-color: #323370;
}

.content-heading > img {
  width: 18px;
  height: 18px;
  margin-right: 8px;
}

.content-heading > p {
  margin: 0;
  font-size: 14px;
}

.content {
  padding: 6px;
  width: 100%;
  background: rgba(255, 255, 255, 0.04);
}

.settings-input-holder {
  padding: 8px 10px;
  display: flex;
  align-items: center;
  background: #333975;
  border: 1px solid #545580;
}

.settings-input-holder > input {
  margin-right: 10px;
  cursor: pointer;
}

.settings-input-holder > label {
  margin: 0;
}

.file-upload-holder {
  margin-bottom: 4px;
  padding: 8px 6px 6px 6px;
  background-color: #363b68;
}

.file-upload-holder:last-of-type {
  margin-bottom: 0;
}

.file-upload-holder > p {
  margin: 0 0 8px 4px;
  font-size: 12px;
}
</style>
