<template>
  <div class="data-analysis-study">
    <div class="study-table-title-holder">
      <div class="study-table-title">
        <img
          src="/img/PlastFluids/tableIcon.png"
          alt="detailed research statistics"
        />
        <p>{{ trans("plast_fluids.analysis_study_table_title") }}</p>
      </div>
    </div>
    <div class="study-table-holder">
      <BaseTable tableType="analysis" :fields="fields" :items="items" />
    </div>
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
  display: flex;
  flex-flow: column;
  width: 100%;
  height: 100%;
}

.study-table-title-holder {
  border: 6px solid #272953;
  border-bottom: none;
  width: 100%;
  height: 37px;
}

.study-table-title {
  width: 100%;
  height: 100%;
  background: #323370;
  border: 1px solid #545580;
  padding: 8px 11px;
  display: flex;
  align-items: center;
}

.study-table-title > img {
  width: 18px;
  height: 14px;
  margin-right: 9px;
}

.study-table-title > p {
  margin: 0;
  font-size: 16px;
  color: #fff;
}

.study-table-holder {
  border: 6px solid #272953;
  padding: 4px;
  width: 100%;
  height: calc(100% - 37px);
}
</style>
