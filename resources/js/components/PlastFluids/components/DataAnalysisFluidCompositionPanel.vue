<template>
  <div class="data-analysis-panel">
    <data-analysis-left-panel />
    <div class="data-analysis-panel__title">
      <i class="fas fa-cog" />
      <span>Настройка</span>
    </div>
    <div class="data-analysis-panel__area">
      <div class="data-analysis-panel__area-setting map__table-area-settings">
        <input type="radio" />
        <label for="">Все по месторождению</label>
      </div>
      <div class="data-analysis-panel__area-setting map__table-area-settings">
        <input type="radio" />
        <label for="">По Горизонту</label>
      </div>
    </div>
    <div class="data-analysis-panel__title">
      <i><img src="/img/PlastFluids/tableSettings.svg" alt=""/></i>
      <span>Настройка таблицы</span>
    </div>
    <div class="data-analysis-panel__area">
      <div class="data-analysis-panel__area-setting">
        <input type="radio" checked />
        <span>Состав пластовой нефти</span>
      </div>
      <div class="data-analysis-panel__area-setting">
        <input type="radio" checked />
        <span>Состав дегазированной нефти</span>
      </div>
    </div>
    <div class="data-analysis-panel__area">
      <div class="data-analysis-panel__area-setting">
        <span>Единица измерения</span>
        <dropdown title="мол" class="pressure__dropdown mt-2">
          <template #list>
            <ul class="list">
              <li v-for="(item, index) in pressures" :key="index">
                <label>{{ item.name }}</label>
              </li>
            </ul>
          </template>
        </dropdown>
      </div>
    </div>
    <div class="data-analysis-panel__area">
      <div class="data-analysis-panel__area-header">
        Вид таблицы
      </div>
      <div class="data-analysis-panel__area-setting type">
        <input type="checkbox" />
        <span class="ml-1">CN-Ln</span>
      </div>
      <div class="data-analysis-panel__area-setting">
        <input type="checkbox" checked />
        <span class="ml-1">XXK</span>
      </div>
    </div>
    <div
      class="d-flex justify-content-around pb-10px data-analysis-panel__btns"
    >
      <button type="button" class="btn-button btn-button--thm-dark-blue">
        <i class="fas fa-download pr-5px" />
        <span>Выгрузить данные</span>
      </button>
    </div>
  </div>
</template>

<script>
import Dropdown from "../components/Dropdown";

export default {
  name: "DataAnalysisFluidCompositionPanel",
  components: {
    Dropdown,
  },

  data() {
    return {
      pressures: [
        { name: "Инфо1" },
        { name: "Инфо2" },
        { name: "Инфо3" },
        { name: "Инфо4" },
      ],
    };
  },
};
</script>

<style scoped lang="scss">
@import "./plast_fluids.scss";
.data-analysis-panel__area-header {
  padding: 8px 10px;
  background: rgba(50, 51, 112, 0.4);
  border: 1px solid #545580;
}
.data-analysis-panel__area-setting:first-child {
  border: 1px solid #545580;
  border-bottom: 0;
}
.data-analysis-panel__area-setting:last-child {
  border: 1px solid #545580;
  border-top: 0;
}
.data-analysis-panel__area-setting.type {
  border-right: 1px solid #545580;
  border-left: 1px solid #545580;
}
.map__table-area-settings {
  display: flex;
  align-items: center;
  background: #1d3583;
  border: 1px solid #545580;
}
.map__table-area-settings label {
  margin: 0 0 0 7px;
  display: block;
}

.data-analysis-panel__btns {
  position: absolute;
  width: 100%;
  padding: 7px;
  bottom: 0;

  button {
    width: 100%;
  }
}

.data-analysis__input {
  background: rgba(31, 33, 66, 0.4);
  border: 0.5px solid #454fa1;
  border-radius: 2px;
  outline: none;
  min-width: 186px;
  padding: 4px 8px;
  color: #fff;
}
</style>
