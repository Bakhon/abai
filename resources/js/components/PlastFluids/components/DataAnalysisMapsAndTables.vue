<template>
  <div class="data-analysis-maps-and-tables">
    <div class="data-analysis__wrapper">
      <div class="data-analysis__wrapper-title">
        <div class="icon-title">
          <i><img src="/img/PlastFluids/tableIcon.png" alt=""/></i>
        </div>
        <span>Детальная статистика изученности по видам исследований</span>
      </div>
      <div class="data-analysis__wrapper-img" v-bind:class="{ full: cartFull }">
        <img src="/img/PlastFluids/mapsAndTables.jpg" alt="" />
      </div>
    </div>
    <div class="table-holder">
      <div class="data-analysis__wrapper next">
        <div class="data-analysis__wrapper-title">
          <img src="/img/PlastFluids/sampleDataIcon.png" alt="" />
          <span>Данные по пробам</span>
        </div>
        <div
          class="data-analysis__row_bottom"
          v-bind:class="{ active: cartFull }"
          @click="cartFull = !cartFull"
        >
          <img src="/img/PlastFluids/row_bottom.svg" alt="" />
        </div>
      </div>
      <BaseTable :fields="fields" :items="items" />
    </div>
  </div>
</template>

<script>
import BaseTable from "./BaseTable.vue";

export default {
  name: "DataAnalysisMapsAndTables",
  components: {
    BaseTable,
  },
  data() {
    return {
      cartFull: false,
      fields: [
        "№ скважины",
        "Дата отбора",
        "Абс. отм. середины инт. перф., середина, м",
        "Давление исследования, МПа",
        "Температура исследования, С°",
        "Давление насыщения, МПа",
        "Вязкость пластовой нефти, мПа* с",
        "Вязкость пластовой нефти при Ps, мПа* с",
        "Плотность пластовой нефти при Рисл, кг/м3",
        "Плотность пластовой нефти при Ps, кг/м3",
        "Газосодержание, м3/м3",
        "Газосодержание, м3/т",
        "Объёмный коэффициент при Рисл",
        "Объёмный коэффициент при Рb",
        "Плотность сепарированной нефти, кг/м3",
        "Плотность сепарированного газа, кг/м3",
        "Отклонение от материального баланса, %",
        "Исполнитель",
      ],
      items: [],
    };
  },
  methods: {
    pushData() {
      for (let i = 0; i < 40; i++) {
        this.items.push([
          "П2",
          "01.01.1983",
          "-3419",
          "Pgor",
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
          33.34,
        ]);
      }
    },
  },
  mounted() {
    this.pushData();
  },
};
</script>

<style scoped lang="scss" src="./DataAnalysisMapsAndTablesStyles.scss"></style>
