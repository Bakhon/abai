<template>
  <div class="data-analysis-study">
    <div class="study-title">
      <div class="icon-title">
        <img src="/img/PlastFluids/tableIcon.png" alt=""/>
      </div>
      <span>Детальная статистика изученности по видам исследований</span>
    </div>
    <BaseTable :items="items" :fields="fields" />
  </div>
</template>

<script>
import BaseTable from "../BaseTable.vue";

export default {
  name: "DataAnalysisStudy",
  components: {
    BaseTable,
  },
  data() {
    return {
      fields: [
        "№ исследования",
        "Скважина",
        "Дата отбора проб",
        "Вид пробы",
        "Давление насыщения при ТПЛ",
        "Зависимость давления насыщения от температуры",
        "PV-соотношение при Тпл",
        "Стандартная сепарация",
        "Ступенчатая сепарация",
        "Дивверенциальное разгазирование",
        "Определение состава флюидов",
        "Вязкость пластовой нефти при Рпл",
        "Зависимость вязкости пластовой нефти от давления выше Ps",
        "Зависимость вязкости пластовой нефти от давления выше Ps",
        "Зависимость вязкости пластовой нефти от температуры",
      ],
      items: [],
    };
  },
  methods: {
    pushData() {
      for (let i = 0; i < 40; i++) {
        this.items.push([
          i,
          "КТ-I",
          "18.07.06",
          "Pgor",
          1,
          1,
          1,
          1,
          1,
          1,
          1,
          1,
          1,
          1,
          50.3,
        ]);
      }
    },
  },
  mounted() {
    this.pushData();
  },
};
</script>

<style scoped>
.data-analysis-study {
  height: 100%;
}

.icon-title {
  margin-right: 8px;
}

.icon-title > img {
  width: 18px;
  height: 14px;
}

.study-title {
  display: flex;
  align-items: center;
  color: #fff;
  width: 100%;
  background-color: #323370;
  border: 1px solid #545580;
  height: 47px;
  padding: 4px;
}

.study-table {
  height: calc(100% - 30px);
}
</style>
