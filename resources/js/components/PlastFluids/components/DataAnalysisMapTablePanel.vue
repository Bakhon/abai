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
      <i class="fas fa-download " />
      <span>Загрузка файлов</span>
    </div>
    <div class="data-analysis-panel__area">
      <div class="data-analysis-panel__area-setting">
        <span>Структурная карта</span>
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
        <span>Схема разломов 1</span>
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
        <span>Схема контактов</span>
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
    <div
      class="d-flex justify-content-around pb-10px data-analysis-panel__btns"
    >
      <button type="button" class="btn-button btn-button--thm-dark-blue">
        <i class="far fa-image pr-5px" />
        <span>Сохранить .jpg</span>
      </button>
      <button type="button" class="btn-button btn-button--thm-dark-blue">
        <i class="fas fa-download pr-5px" />
        <span>Выгрузить данные</span>
      </button>
    </div>
  </div>
</template>

<script>
import Accordion from "../components/Accordion";
import Dropdown from "../components/Dropdown";
import VSelect from "vue-select";

export default {
  name: "DataAnalysisMapTablePanel",

  components: {
    Accordion,
    Dropdown,
    VSelect,
  },

  data() {
    return {
      fields: [
        {
          name: "Кожасай",
          checked: true,
        },
        {
          name: "Алибекмола",
          checked: false,
        },
        {
          name: "Жетибай",
          checked: true,
        },
      ],
      pressures: [
        { name: "Инфо1" },
        { name: "Инфо2" },
        { name: "Инфо3" },
        { name: "Инфо4" },
      ],
      deposits: [
        {
          name: "Гв",
          checked: true,
        },
        {
          name: "Гн",
          checked: false,
        },
        {
          name: "Дв",
          checked: false,
        },
        {
          name: "Дн",
          checked: true,
        },
      ],
      wells: [
        {
          name: 2,
          checked: true,
        },
        {
          name: 5,
          checked: false,
        },
        {
          name: 18,
          checked: true,
        },
      ],
      font: "Arial",
      fontList: ["Arial", "New Times Roman", "Helvetica"],
      sizes: [8, 10, 12, 14, 16],
      size: 14,
    };
  },
};
</script>

<style scoped lang="scss">
@import "./plast_fluids.scss";
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
</style>
