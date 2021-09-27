<template>
  <div class="search-for-fluids">
    <div class="header">
      <img src="/img/PlastFluids/searchForFluids.svg" alt="" />
      <p>Поиск флюидов со схожими свойствами</p>
    </div>
    <div class="content">
      <div class="forecast-oil-properties">
        <div class="content-header"><p>Прогноз свойств нефти</p></div>
        <SearchForFluidsInput
          :inputData.sync="depthOfOccurrence"
          labelTransKey="depth_of_occurrence"
          :showCheckbox="false"
        />
      </div>
      <div class="custom-properties">
        <div class="content-header"><p>Задать в новой форме</p></div>
        <div class="content-main">
          <SearchForFluidsInput
            :inputData.sync="reservoirPressure"
            labelTransKey="reservoir_pressure"
            :showCheckbox="true"
          />
          <SearchForFluidsInput
            :inputData.sync="reservoirTemperature"
            labelTransKey="reservoir_temperature"
            :showCheckbox="true"
          />
          <SearchForFluidsInput
            :inputData.sync="densityOfOil"
            labelTransKey="density_of_oil"
            :showCheckbox="true"
          />
          <SearchForFluidsInput
            :inputData.sync="gasContent"
            labelTransKey="gas_content"
            :showCheckbox="true"
          />
          <SearchForFluidsInput
            :inputData.sync="reservoirOilViscosity"
            labelTransKey="reservoir_oil_viscosity"
            :showCheckbox="true"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SearchForFluidsInput from "./SearchForFluidsInput.vue";

export default {
  name: "SearchForFluids",
  components: {
    SearchForFluidsInput,
  },
  data() {
    return {
      densityOfOil: 840,
      depthOfOccurrence: 25,
      gasContent: 120,
      reservoirOilViscosity: 5,
      reservoirPressure: 25,
      reservoirTemperature: 86,
    };
  },
};
</script>

<style scoped>
.search-for-fluids {
  width: 100%;
  margin-top: 10px;
}

.header {
  width: 100%;
  background: #323370;
  display: flex;
  align-items: center;
  padding: 7px;
  margin-bottom: 6px;
}

.header > img {
  height: 18px;
  width: 18px;
  margin-right: 8px;
}

.header > p {
  margin: 0;
  font-size: 16px;
  color: #fff;
}

.content {
  padding: 0 6px;
  width: 100%;
}

.forecast-oil-properties {
  margin-bottom: 6px;
  border: 1px solid #545580;
}

.content-header {
  background: #333975;
  border-bottom: 1px solid #545580;
  padding: 11px 8px;
  width: 100%;
}

.content-header > p {
  font-size: 14px;
  color: #fff;
  margin: 0;
}

.content-main {
  background: #363b68;
}

.custom-properties {
  border: 1px solid #545580;
}
</style>
