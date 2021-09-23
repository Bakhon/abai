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

<style scoped lang="scss">
.data-analysis-panel {
  display: flex;
  flex-flow: column;
  justify-content: space-between;
  background: #272953;
  width: 100%;
  height: 100%;
}

.data-analysis-panel__title {
  font-size: 16px;
  padding: 7px 15px;
  background: #323370;
  i {
    color: #868bb2;
    margin-right: 8px;
  }
  .fa-sliders-h {
    transform: rotate(90deg);
  }
}

.data-analysis-panel__area {
  padding: 4px 8px;
}

.settings-holder {
  margin-bottom: 10px;
}

.data-analysis-panel__area-setting {
  background: #363b68;
  padding: 8px;
}

input[type="checkbox"] {
  transform: scale(1.4);
  cursor: pointer;
}

.list {
  margin-bottom: 0;
  li {
    display: flex;
    align-items: center;
    cursor: pointer;
    line-height: 2;
    label {
      margin-bottom: 0;
      margin-left: 10px;
      cursor: pointer;
    }
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

.data-analysis-panel__btns {
  width: 100%;
  padding: 0 6px;
}

.data-analysis-panel__btns > button {
  font-size: 14px;
  padding: 10px 7px;
}

.data-analysis-dropdown__body {
  padding: 0 !important;
}

.pressure__dropdown ul li:hover {
  background-color: #3366ff;
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
</style>
