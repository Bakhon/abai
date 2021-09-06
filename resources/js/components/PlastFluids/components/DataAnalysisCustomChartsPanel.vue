<template>
  <div class="data-analysis-panel">
    <data-analysis-left-panel />
    <div class="data-analysis-panel__title">
      <i><img src="/img/PlastFluids/chartSettings.svg" alt=""/></i>
      <span>Настройки графиков</span>
    </div>
    <div class="data-analysis-panel__area">
      <div class="data-analysis-panel__area-setting">
        <span>Корреляция Ps-Rs</span>
        <dropdown title="Давление насыщения" class="pressure__dropdown mt-2">
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
    <div class="graph__settings">
      <div class="graph__settings-content" v-for="(i, ind) in 2" :key="ind">
        <div class="graph__settings-content-header">
          <input type="radio" />
          <label for="">Связь с Rs</label>
        </div>
        <div class="graph__settings-content-body">
          <div class="graph__settings-content-body-check">
            <input type="checkbox" />
            <label for="">Ps</label>
          </div>
          <div class="graph__settings-content-body-check">
            <input type="checkbox" />
            <label for="">Bos</label>
          </div>
          <div class="graph__settings-content-body-check">
            <input type="checkbox" />
            <label for="">Dos</label>
          </div>
          <div class="graph__settings-content-body-check">
            <input type="checkbox" />
            <label for="">μ‎os</label>
          </div>
        </div>
      </div>
    </div>
    <div class="data-analysis-panel__area">
      <div class="data-analysis-panel__area-setting">
        <span>Корреляция Bs-Rs</span>
        <dropdown title="Давление насыщения" class="pressure__dropdown mt-2">
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
      <div class="data-analysis-panel__area-setting">
        <span>Корреляция Ps-Rs</span>
        <dropdown title="Давление насыщения" class="pressure__dropdown mt-2">
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
      <div class="data-analysis-panel__area-setting">
        <span>Модель EOS</span>
        <dropdown title="Давление насыщения" class="pressure__dropdown mt-2">
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
    <div class="data-analysis-panel__title">
      <i><img src="/img/PlastFluids/tableSettings.svg" alt=""/></i>
      <span>Настройка таблицы</span>
    </div>
    <div class="data-analysis-panel__area p-1">
      <div class="data-analysis-panel__area-setting">
        <input type="checkbox" checked />
        <span>Свойств</span>
      </div>
      <div class="data-analysis-panel__area-setting">
        <input type="checkbox" checked />
        <span>Отбор проб</span>
      </div>
      <div class="data-analysis-panel__area-setting">
        <input type="checkbox" checked />
        <span>Пользовательски</span>
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
  name: "DataAnalysisCustomChartsPanel",
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
.data-analysis-panel__area-setting {
  border-left: 1px solid #545580;
  border-right: 1px solid #545580;
}
.data-analysis-panel__area-setting:last-child {
  border: 1px solid #545580;
  border-top: 0;
}
.data-analysis-panel__area-setting input {
  margin-right: 10px;
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
.graph__settings {
  padding: 4px 8px;
  display: flex;
  justify-content: space-between;
}
.graph__settings-content {
  border: 1px solid #545580;
  width: calc(50% - 2px);
}
.graph__settings-content-header {
  border-bottom: 1px solid #545580;
  padding: 8px 10px;
}
.graph__settings-content-header label {
  margin-left: 10px;
}
.graph__settings-content-body {
  padding: 10px;
}
label {
  margin-bottom: 0;
}
.graph__settings-content-body-check {
  margin-bottom: 10px;
}
.graph__settings-content-body-check:last-child {
  margin-bottom: 0;
}
.graph__settings-content-body-check label {
  margin-left: 10px;
}
</style>
