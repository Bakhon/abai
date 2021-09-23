<template>
  <div class="data-analysis-property-map">
    <div class="data-analysis__wrapper">
      <div class="data-analysis__wrapper-title">
        <div class="icon-title">
          <img src="/img/PlastFluids/tableIcon.png" alt="" />
        </div>
        <span>Детальная статистика изученности по видам исследований</span>
      </div>
      <div class="data-analysis__wrapper-img" v-bind:class="{ full: cartFull }">
        <img src="/img/PlastFluids/mapProperty.svg" alt="" />
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
      <BaseTable :items="items" :fields="fields" />
    </div>
  </div>
</template>

<script>
import BaseTable from "../BaseTable.vue";

export default {
  name: "DataAnalysisPropertyMap",
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
          "П-2",
          "01.01.1983",
          -3419,
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

<style scoped lang="scss">
.data-analysis {
  display: flex;
  color: #fff;

  &__content {
    width: calc(100% - 340px);
  }
}

.table-holder {
  height: 350px;
} 

.data-analysis__wrapper {
  background: #272953;
  padding: 8px;
  flex: 2 1 auto;
  margin-bottom: 10px;

  &-title {
    display: flex;
    align-items: center;
    background: #323370;
    border: 1px solid #545580;
    padding: 8px;
    height: 30px;
    /*width: calc(100% - 42px);*/

    .icon-title {
      background-color: #b3b6d1;
      border-radius: 5px;
      margin-right: 10px;
      width: 26px;
      text-align: center;
    }

    .fa-sliders-h {
      color: #868bb2;
      font-size: 16px;
    }

    span {
      font-size: 16px;
      color: #fff;
    }
  }

  &-img {
    height: 100%;
    background: #000;
    text-align: center;
    overflow: hidden;
  }

  img {
    display: block;
    width: 100%;
  }
}

.full {
  height: 700px;
}

.full img {
  height: 100%;
}

.next {
  display: flex;
  justify-content: space-between;
  /*align-items: center;*/
}

.next .data-analysis__wrapper-title {
  width: calc(100% - 35px);
}

.data-analysis__wrapper-title img {
  display: block;
  width: 17px;
  height: auto;
  margin-right: 10px;
}

.data-analysis__row_bottom {
  width: 31px;
  height: 30px;
  background: #333975;
  border: 1px solid #545580;
  border-radius: 4px;
  display: flex;
  align-items: center;
  cursor: pointer;
}

.data-analysis__row_bottom img {
  display: block;
  width: 14px;
  height: 6px;
  margin: 0 auto;
  transition: all 0.3s ease-in-out;
}

.data-analysis__row_bottom.active img {
  transform: rotate(180deg);
}

.data-analysis table.defaultTable {
  max-height: 600px;
  position: relative;
  display: block;
  width: 100%;
  font-size: 12px;
  text-align: center;
  color: #ffffff;
  overflow-x: scroll;
}

.data-analysis table.defaultTable tbody {
  width: 120%;
  display: table;
}

.data-analysis table.defaultTable tr:nth-child(even) {
  background: rgba(69, 77, 125, 0.7);
}

.data-analysis table.defaultTable tr:nth-child(odd) {
  background: #34365d;
}

.data-analysis table.defaultTable td,
.data-analysis table.defaultTable th {
  border: 1px solid #454d7d;
  padding: 0.5rem 0.23rem;
  vertical-align: middle !important;
}

.data-analysis table.defaultTable td.head {
  background: #333975;
  height: 26px;
}

.data-analysis table.defaultTable th {
  font-size: 11px;
  background: #333975;
}

.data-analysis table.defaultTable::-webkit-scrollbar-thumb {
  background-color: #000000;
  border: 2px solid #ffffff;
}

.data-analysis table.defaultTable::-webkit-scrollbar {
  width: 4px;
}
</style>
