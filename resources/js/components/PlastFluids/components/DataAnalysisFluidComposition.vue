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
          <img src="/img/PlastFluids/share.svg" alt="" />
        </div>
      </div>
      <div class="data-analysis__wrapper-img" v-bind:class="{ full: cartFull }">
        <img src="/img/PlastFluids/FluidCompositionGraph.svg" alt="" />
      </div>
    </div>
    <br />
    <div class="data-analysis__wrapper-first next">
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
    <div class="data-analysis__wrapper">
      <div class="row">
        <div class="col-sm-12">
          <table class="table defaultTable" v-if="!cartFull">
            <tbody>
              <tr>
                <th>Скважина</th>
                <th>Дата отбора</th>
                <th>H2S</th>
                <th>CO2</th>
                <th>N2</th>
                <th>C1</th>
                <th>C2</th>
                <th>C3</th>
                <th>IC4</th>
                <th>NC4</th>
                <th>IC6</th>
                <th>NC5</th>
                <th v-for="(i, index) in 31">C{{ i + 5 }}</th>
              </tr>
              <tr v-for="i in 10">
                <td class="head">П-2</td>
                <td v-for="i in 42">2.32</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DataAnalysisFluidComposition",
  data() {
    return {
      cartFull: false,
    };
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
.data-analysis__wrapper-first {
  background-color: #272953;
  padding: 4px 4px 0;
  height: 34px;
}
.data-analysis__wrapper {
  background: transparent;
  padding: 4px;
  border: 6px solid #272953;

  &-title {
    display: flex;
    align-items: center;
    background: #323370;
    border: 1px solid #545580;
    padding: 8px;
    margin-bottom: 8px;
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
    }
  }

  &-img {
    height: 454px;
    width: 100%;
    background: #272953;
    border: 1px solid #545580;
    text-align: center;
    padding: 6px;
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
.next {
  display: flex;
  justify-content: space-between;
  /*align-items: center;*/
}
.data-analysis .row {
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
.data-analysis__wrapper-header {
  background: #323370;
  padding: 7px 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.data-analysis__wrapper-header-export {
  display: flex;
  align-items: center;
}
.data-analysis__wrapper-header-export img {
  width: 14px;
  margin-left: 12px;
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
