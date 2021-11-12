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
            <input type="checkbox" id="all-wells" />
            <label for="all-wells">Все скважины</label>
          </div>
          <div class="settings-input-holder">
            <input type="checkbox" id="wells-deep-samples" />
            <label for="wells-deep-samples"
              >Скважины с отбором глубинных проб</label
            >
          </div>
          <div class="settings-input-holder">
            <input type="checkbox" id="wells-recombined-samples" />
            <label for="wells-recombined-samples"
              >Скважины с отбором рекомбинированных проб</label
            >
          </div>
        </div>
      </div>
      <div class="content-holder">
        <div class="content-heading">
          <img
            src="/img/PlastFluids/mapsAndTablesFluidsProperties.svg"
            alt="fluid properties"
          />
          <p>{{ trans("plast_fluids.show_fluid_properties") }}</p>
        </div>
        <div class="content">
          <div class="fluid-inputs">
            <div class="fluid-input-holder">
              <input type="checkbox" id="gas-content" />
              <label for="gas-content">{{
                trans("plast_fluids.gas_content")
              }}</label>
            </div>
            <div class="fluid-input-holder">
              <input type="checkbox" id="density-separation-oil" />
              <label for="density-separation-oil"
                >{{ trans("plast_fluids.density_separation_oil") }}
              </label>
            </div>
            <div class="fluid-input-holder">
              <input type="checkbox" id="pressure-saturation" />
              <label for="pressure-saturation">{{
                trans("plast_fluids.pressure_saturation")
              }}</label>
            </div>
            <div class="fluid-input-holder">
              <input type="checkbox" id="reservoir-oil-viscosity" />
              <label for="reservoir-oil-viscosity">{{
                trans("plast_fluids.reservoir_oil_viscosity")
              }}</label>
            </div>
          </div>
        </div>
      </div>
      <div class="content-holder">
        <div class="content-heading">
          <img
            src="/img/PlastFluids/mapsAndTablesFileUpload.svg"
            alt="file upload"
          />
          <p>{{ trans("plast_fluids.file_upload") }}</p>
        </div>
        <div class="content">
          <div class="file-upload-holder">
            <p>Структурная карта</p>
            <Dropdown
              :items="models"
              dropKey="created_datetime"
              :dropKeyRepeat="true"
              :selectedValue="currentModel.created_datetime"
              @dropdown-select="SET_CURRENT_MODEL"
              :description="true"
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
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Dropdown from "../Dropdown.vue";
import { mapState, mapMutations } from "vuex";

export default {
  name: "DataAnalysisMapTablePanel",
  components: {
    Dropdown,
  },
  computed: {
    ...mapState("plastFluidsLocal", ["models", "currentModel"]),
  },
  methods: {
    ...mapMutations("plastFluidsLocal", ["SET_CURRENT_MODEL"]),
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
  overflow-y: auto;
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

.fluid-inputs {
  background: #363b68;
  border: 1px solid #545580;
  padding: 8px 10px;
}

.fluid-input-holder {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.fluid-input-holder:last-of-type {
  margin-bottom: 0;
}

.fluid-input-holder > input {
  margin-right: 10px;
}

.fluid-input-holder > label {
  margin: 0;
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
  font-size: 12px;
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

::-webkit-scrollbar {
  height: 4px;
  width: 4px;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}
</style>
