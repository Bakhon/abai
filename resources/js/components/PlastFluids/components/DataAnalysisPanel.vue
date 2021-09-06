<template>
  <div class="data-analysis-panel">
    <data-analysis-left-panel />
    <div class="data-analysis-panel__title">
      <i class="fas fa-cog" />
      <span>Настройка</span>
    </div>
    <div class="data-analysis-panel__area">
      <div class="data-analysis-panel__area-setting">
        <span>Газосодержание</span>
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
      <i class="fas fa-map-marked-alt" />
      <span>Настройки карты свойств</span>
    </div>
    <div class="data-analysis-panel__area">
      <accordion title="Данные" :hideIcon="false">
        <template #list>
          <div class="item mb-10px">
            <span>Автор:</span>
            <span>mvmedmedova</span>
          </div>
          <div class="item mb-10px">
            <span>Алгоритм:</span>
            <span>По изолиниям</span>
          </div>
          <div class="item mb-10px">
            <span>Дата:</span>
            <span>30.12.1988</span>
          </div>
          <div class="item">
            <span>Значение бланка:</span>
            <span>1.701551615151</span>
          </div>
        </template>
      </accordion>
      <accordion title="Изолинии-Вид" :hideIcon="false">
        <template #list>
          <div
            class="d-flex align-items-center justify-content-between mb-10px"
          >
            <span>Изолинии-Изменить</span>
            <i class="fas fa-pencil-alt" />
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <span>Изолинии-Показать</span>
            <input type="checkbox" />
          </div>
        </template>
      </accordion>
      <accordion title="Изолинии-Шрифт" :hideIcon="false">
        <template #list>
          <div
            class="d-flex align-items-center justify-content-between mb-10px"
          >
            <span>Шрифт: </span>
            <el-select
              class="data-analysis__select"
              v-model="font"
              placeholder="Шрифт"
              size="small"
            >
              <el-option
                v-for="(item, index) in fontList"
                :key="index"
                :label="item"
                :value="item"
              >
              </el-option>
            </el-select>
          </div>
          <div
            class="d-flex align-items-center justify-content-between mb-10px"
          >
            <span>Размер: </span>
            <el-select
              class="data-analysis__select"
              v-model="size"
              placeholder="Размер"
              size="small"
            >
              <el-option
                v-for="(item, index) in sizes"
                :key="index"
                :label="item"
                :value="item"
              >
              </el-option>
            </el-select>
          </div>
          <div
            class="d-flex align-items-center justify-content-between mb-10px"
          >
            <span>Имя: </span>
            <input type="text" class="data-analysis__input" />
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <span>Интерполлировать</span>
            <input type="checkbox" />
          </div>
        </template>
      </accordion>
      <accordion title="Информация" :hideIcon="false">
        <template #list>
          <div class="d-flex align-items-center justify-content-between">
            <span>Линия сетки</span>
            <input type="checkbox" />
          </div>
        </template>
      </accordion>
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
  name: "DataAnalysisPanel",

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

.data-analysis-dropdown__body {
  padding: 0 !important;
}
.pressure__dropdown ul li:hover {
  background-color: #3366ff;
}
</style>
