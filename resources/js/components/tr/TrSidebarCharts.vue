<template>
  <div class="droprightt">
    <div data-toggle="dropdown">
      <a href="#" class="bg-dark list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-start align-items-center">
          <svg
            width="27"
            height="23"
            viewBox="0 0 27 23"
            fill="none"
            style="margin-right: 13px;"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M5.14269 8.93182H7.71417V17.8761H5.14269V8.93182ZM15.4286 12.7647H17.9998V17.8761H15.4286V12.7647ZM10.2854 5.09812H12.8571V17.8761H10.2854V5.09812ZM23.143 5.11115V1.27771H20.5713V5.11115H16.7143V7.66659H20.5713V11.5H23.143V7.66659H27V5.11115H23.143ZM20.5713 20.4446H2.57095V2.55544H17.9998V0H2.57095C1.15709 0 0 1.15022 0 2.55544V20.4446C0 21.8498 1.15709 23 2.57095 23H20.5713C21.986 23 23.143 21.8498 23.143 20.4446V14.0557H20.5713V20.4446Z"
              fill="#FEFEFE"
            />
          </svg>
          <span class="menu-collapsed companyName d-none"></span>
        </div>
      </a>
    </div>
    <div class="dropdown-menu tr-sidebar__chart-menu" style="z-index:12000;    position: relative;">
      <div>
        <li class="tr-sidebar__page">
          <a class="tr-sidebar__link" href="/ru/fa">Факторный анализ</a>
        </li>
        <li
          v-for="(item, index) in chartNamesFA"
          :key="item"
          class="tr-sidebar__graph"
        >
          <a class="tr-sidebar__link" href="/ru/trfa" @click="() => setChartFa(index)">{{ item }}</a>
        </li>

        <li class="tr-sidebar__page">
          <a class="tr-sidebar__link" href="/ru/tr">Тех.режим</a>
        </li>
        <li
          v-for="(item, index) in chartNames"
          :key="item"
          class="tr-sidebar__graph"
        >
          <a class="tr-sidebar__link" href="/ru/tr_charts" @click="() => setChart(index)">{{ item }}</a>
        </li>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {},
  data() {
    return {
      chartNames: [
        "Анализ глубин пластов, спуска насосов и динамического уровня",
        "ТОП-30 скважин. Потенциал прироста дебита нефти",
        "ТОП-30 скважин. Потенциал прироста дебита нефти. Обводненность",
        "ТОП-30 скважин. Потенциал прироста дебита нефти. Газовый фактор",
        "ТОП-30 скважин. Потенциал прироста дебита жидкости",
        "Суммарный дебит нефти и жидкости",
        "Распределение коэффициента продуктивности",
        "Распределение скважин по дебиту нефти",
        "Распределение скважин по обводненности",
        "Распределение скважин по дебиту жидкости",
      ],
      chartNamesFA: [
        "Распределение фонда скважин по основной причине снижения дебита нефти",
        "Распределение суммарных отклонений TP по факторам, т/сут",
      ],
    };
  },
  watch: {},
  methods: {
    setChart(chart) {
      console.log('setChart = ', chart)
      this.$store.commit("tr/SET_CHART", chart);
    },
    setChartFa(chart) {
      console.log('setChartFa = ', chart)
      this.$store.commit("fa/SET_CHART", chart);
    },
  },
};
</script>

<style  scoped>
.tr-sidebar__chart-menu {
  margin: 0;
  padding: 0;
  width: 520px;
  max-width: 80vw;
}
.tr-sidebar__link {
  color: #FFF;
}
.tr-sidebar__page {
  font-weight: bold;
  font-size: 18px;
  padding: 3px 20px;
  background: #3A3D7C;
}
.tr-sidebar__graph {
  background: #40467e;
  padding: 3px 20px;
}
.droprightt.droprightt {
  z-index: 5000;
}
</style>
