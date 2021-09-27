<template>
  <div class="">
    <div class="data-analysis__wrapper-first">
      <div class="data-analysis__wrapper-title">
        <div class="icon-title">
          <i><img src="/img/PlastFluids/tableIcon.png" alt=""/></i>
        </div>
        <span>График</span>
      </div>
    </div>
    <div class="data-analysis__wrapper">
      <div class="data-analysis__wrapper-header">
        <div class="data-analysis__wrapper-header-title">
          Углеводородная фракция
        </div>
        <div class="data-analysis__wrapper-header-export">
          <img src="/img/PlastFluids/download.svg" alt="" />
          <img src="/img/PlastFluids/openModal.svg" alt="" />
        </div>
      </div>
      <div class="data-analysis__wrapper-img" v-bind:class="{ full: cartFull }">
        <img src="/img/PlastFluids/fluidComposition.jpg" alt="" />
      </div>
    </div>
    <div class="table-holder">
      <div class="first next">
        <div class="data-analysis__wrapper-title">
          <img src="/img/PlastFluids/sampleDataIcon.png" alt="" />
          <span>Качество состава нефти</span>
        </div>
        <div
          class="data-analysis__row_bottom"
          v-bind:class="{ active: cartFull }"
          @click="cartFull = !cartFull"
        >
          <img src="/img/PlastFluids/row_bottom.svg" alt="" />
        </div>
      </div>
      <BaseTable :items="items" :fields="fields" />
    </div>
  </div>
</template>

<script>
import BaseTable from "../BaseTable.vue";

export default {
  name: "DataAnalysisFluidComposition",
  components: {
    BaseTable,
  },
  data() {
    return {
      cartFull: false,
      items: [],
      fields: [
        "Скважина",
        "Дата отбора",
        "H2S",
        "CO2",
        "N2",
        "C1",
        "C2",
        "C3",
        "IC4",
        "NC4",
        "IC6",
        "NC5",
      ],
    };
  },
  methods: {
    pushData() {
      for (let i = 0; i < 40; i++) {
        this.items.push([
          "П-2",
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
        ]);
      }
    },
  },
  mounted() {
    this.pushData();
  },
};
</script>

<style
  scoped
  lang="scss"
  src="./DataAnalysisFluidCompositionStyles.scss"
></style>
