<template>
  <div>
    <div class="data-analysis-panel__title">
      <i class="fas fa-sliders-h" />
      <span>Выбор параметров</span>
    </div>
    <div class="data-analysis-panel__area">
      <dropdown title="Месторождение">
        <template #list>
          <ul class="list">
            <li v-for="(item, index) in fields" :key="index">
              <input
                type="checkbox"
                name="checkbox"
                v-model="item.checked"
                :id="`field_${index}`"
              />
              <label :for="`field_${index}`">{{ item.name }}</label>
            </li>
          </ul>
        </template>
      </dropdown>
      <accordion title="Залежь">
        <template #list>
          <ul class="list">
            <li v-for="(item, index) in deposits" :key="index">
              <input
                type="checkbox"
                name="checkbox"
                v-model="item.checked"
                :id="`deposit_${index}`"
              />
              <label :for="`deposit_${index}`">{{ item.name }}</label>
            </li>
          </ul>
        </template>
      </accordion>
      <accordion title="Скважины">
        <template #list>
          <ul class="list">
            <li v-for="(item, index) in wells" :key="index">
              <input
                type="checkbox"
                name="checkbox"
                v-model="item.checked"
                :id="`well_${index}`"
              />
              <label :for="`well_${index}`">{{ item.name }}</label>
            </li>
          </ul>
        </template>
      </accordion>
    </div>
  </div>
</template>

<script>
import Accordion from "../components/Accordion";
import Dropdown from "../components/Dropdown";
import VSelect from "vue-select";

export default {
  name: "DataAnalysisLeftPanel",
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
    };
  },
};
</script>

<style scoped lang="scss">
.data-analysis-panel__title {
  font-size: 16px;
  padding: 15px;
  background: #323370;
  i {
    color: #868bb2;
    margin-right: 8px;
  }
  .fa-sliders-h {
    transform: rotate(90deg);
  }
}
</style>
