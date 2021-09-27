<template>
  <div class="data-analysis-panel">
    <div class="main-content-holder">
      <div class="settings-holder">
        <div class="data-analysis-panel__title">
          <i class="fas fa-cog" />
          <span>Настройка</span>
        </div>
        <div class="data-analysis-panel__area">
          <div
            class="data-analysis-panel__area-setting map__table-area-settings"
          >
            <input type="radio" />
            <label for="">Все по месторождению</label>
          </div>
          <div
            class="data-analysis-panel__area-setting map__table-area-settings"
          >
            <input type="radio" />
            <label for="">По Горизонту</label>
          </div>
        </div>
      </div>
      <div class="data-analysis-panel__title">
        <i class="fas fa-download " />
        <span>Загрузка файлов</span>
      </div>
      <div class="data-analysis-panel__area">
        <div class="data-analysis-panel__area-setting">
          <span>Структурная карта</span>
          <Dropdown :items="pressures" dropKey="name" />
        </div>
      </div>
      <div class="data-analysis-panel__area">
        <div class="data-analysis-panel__area-setting">
          <span>Схема разломов 1</span>
          <Dropdown :items="pressures" dropKey="name" />
        </div>
      </div>
      <div class="data-analysis-panel__area">
        <div class="data-analysis-panel__area-setting">
          <span>Схема контактов</span>
          <Dropdown :items="pressures" dropKey="name" />
        </div>
      </div>
    </div>
    <div
      class="d-flex justify-content-around pb-10px data-analysis-panel__btns"
    >
      <button type="button" class="btn-button btn-button--thm-dark-blue">
        <i class="far fa-image pr-5px" />
        <span>Сохранить .jpg</span>
      </button>
      <button class="btn-button btn-button--thm-dark-blue">
        <i class="fas fa-download pr-5px" />
        <span>Выгрузить данные</span>
      </button>
    </div>
  </div>
</template>

<script>
import Dropdown from "../Dropdown.vue";

export default {
  name: "DataAnalysisMapTablePanel",

  components: {
    Dropdown,
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

<style scoped lang="scss" src="./LeftMenuStyles.scss"></style>
