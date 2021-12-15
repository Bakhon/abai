<template>
  <div class="data-analysis-panel">
    <div class="content-holder">
      <div class="content-heading">
        <img
          src="/img/PlastFluids/tableCustomization.svg"
          alt="table settings"
        />
        <p>{{ trans("plast_fluids.composition_table") }}</p>
      </div>
      <div class="content">
        <div class="table-content">
          <div
            class="table-input-holder"
            v-for="property in compositionTable"
            :key="property.key"
          >
            <input
              :value="property.key"
              v-model="selectedComposition"
              type="radio"
              :id="'composition-table-' + property.key"
            />
            <label :for="'composition-table-' + property.key">{{
              property.label
            }}</label>
          </div>
        </div>
      </div>
    </div>
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
          <p>{{ trans("plast_fluids.separation_type") }}</p>
          <Dropdown
            :items="separationTypes"
            :dropKey="['name']"
            :selectedValue="selectedSeparation.name"
            @dropdown-select="updateSelectedSeparation"
          />
        </div>
        <div class="settings-input-holder">
          <p>{{ trans("plast_fluids.unit") }}</p>
          <Dropdown
            :items="units"
            :dropKey="['name']"
            :selectedValue="selectedUnit.name"
            @dropdown-select="updateSelectedUnit"
          />
        </div>
      </div>
    </div>
    <div class="content-holder">
      <div class="content-heading">
        <img
          src="/img/PlastFluids/graphsCustomization.svg"
          alt="graphs customization"
        />
        <p>{{ trans("plast_fluids.composition_schedule") }}</p>
      </div>
      <div class="content">
        <div class="graph-customization-input-holder">
          <input
            type="checkbox"
            v-model="isGraphCustomizationPf"
            id="graph-customization-plast-fluid"
          /><label for="graph-customization-plast-fluid">{{
            trans("plast_fluids.plast_fluid")
          }}</label>
        </div>
        <div class="graph-customization-input-holder">
          <p>{{ trans("plast_fluids.x_axis_limit_cn") }}</p>
          <div><Dropdown style="margin-bottom: 0" /></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Dropdown from "../Dropdown.vue";

export default {
  name: "DataAnalysisFluidCompositionLeftMenu",
  components: {
    Dropdown,
  },
  data() {
    return {
      selectedComposition: "plastFluid",
      compositionTable: [
        {
          label: this.trans("plast_fluids.plast_fluid"),
          key: "plastFluid",
        },
        {
          label: this.trans("plast_fluids.separation_fluid"),
          key: "separationFluid",
        },
        {
          label: this.trans("plast_fluids.separation_gas"),
          key: "gasSeparation",
        },
      ],
      separationTypes: [
        {
          name: this.trans("plast_fluids.standart"),
        },
        { name: this.trans("plast_fluids.stepped") },
        { name: this.trans("plast_fluids.differential") },
      ],
      selectedSeparation: { name: this.trans("plast_fluids.standart") },
      units: [
        { name: this.trans("plast_fluids.mole") + ".%" },
        { name: this.trans("plast_fluids.mass") + ".%" },
      ],
      selectedUnit: { name: this.trans("plast_fluids.mole") + ".%" },
      isGraphCustomizationPf: false,
    };
  },
  methods: {
    updateSelectedSeparation(value) {
      this.selectedSeparation = value;
    },
    updateSelectedUnit(value) {
      this.selectedUnit = value;
    },
  },
};
</script>

<style scoped>
.data-analysis-panel {
  display: flex;
  flex-flow: column;
  background: #272953;
  width: 100%;
  height: 100%;
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

.table-content {
  width: 100%;
  border: 1px solid #545580;
  background: #363b68;
  padding: 8px 10px;
}

.table-input-holder {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.table-input-holder:last-of-type {
  margin-bottom: 0;
}

.table-input-holder > input {
  margin-right: 10px;
  cursor: pointer;
}

.table-input-holder > label {
  margin: 0;
  font-size: 12px;
}

.settings-input-holder {
  padding: 8px 6px;
  background: #363b68;
  border: 1px solid #545580;
}

.settings-input-holder:nth-of-type(1) {
  margin-bottom: 6px;
}

.settings-input-holder > p {
  font-size: 14px;
  color: #fff;
  margin: 0 0 6px 4px;
}

.graph-customization-input-holder {
  display: flex;
  align-items: center;
  border: 0.5px solid #545580;
  background: #363b68;
}

.graph-customization-input-holder:nth-of-type(1) {
  padding: 8px 10px;
  margin-bottom: 4px;
}

.graph-customization-input-holder:nth-of-type(2) {
  padding: 6px 8px;
  justify-content: space-between;
}

.graph-customization-input-holder:nth-of-type(2) > p {
  margin: 0;
  margin-left: 2px;
}

.graph-customization-input-holder > input {
  margin-right: 10px;
  cursor: pointer;
}

.graph-customization-input-holder > label {
  margin: 0;
  font-size: 12px;
}

.graph-customization-input-holder > div {
  width: 120px;
}
</style>
