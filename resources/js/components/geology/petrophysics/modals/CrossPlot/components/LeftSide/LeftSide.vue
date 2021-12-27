<template>
  <div class="cross-plot__left-panel customScroll d-flex flex-dir-column">

    <div class="d-flex flex-nowrap">
      <div class="cross-plot__left-panel__title cross-plot__left-panel__title-active">Кривые</div>
      <div class="cross-plot__left-panel__title">Палетка</div>
    </div>

    <div class="cross-plot__left-panel__content h-100">

      <WellListBlock @change="updateCurveList"/>
      <div>
        <WellBlock title="Ось Х" placeholder="Выбор кривой" :options="getCurveList" @change="setXData"/>
        <WellBlock title="Ось Y" placeholder="Выбор кривой" :options="getCurveList" @change="setYData"/>
        <WellBlock title="Заливка" placeholder="Выбор заливки"/>
        <WellBlock title="Фильтр" placeholder="Выбор фильтра"/>
      </div>
    </div>

  </div>
</template>

<script>
import dropdown from '../../../../../components/dropdowns/dropdown';
import ToolBlock from '../../../../../components/toolBlock/ToolBlock';
import {
  FETCH_WELLS_CURVES,
  FETCH_WELLS_MNEMONICS,
  GET_WELLS_OPTIONS
} from "../../../../../../../store/modules/geologyGis.const";
import WellBlock from "./components/WellBlock";
import WellListBlock from "./components/WellListBlock";
import {globalloadingMutations} from "../../../../../../../store/helpers";

export default {
  name: 'LeftSide',

  components: {
    dropdown,
    ToolBlock,
    WellListBlock,
    WellBlock,
  },

  data() {
    return {
      curveList: [],
    }
  },

  methods: {

    clearCurveList() {
      this.curveList = [];
    },

    async updateCurveList(wellId) {
      this.SET_LOADING(true);
      this.clearCurveList();

      await this.$store.dispatch(FETCH_WELLS_MNEMONICS, [wellId]);
      let curveListRaw = this.$store.state.geologyGis.awGis.getElementsWithData();
      this.curveList = curveListRaw.map(function (t) {
        return {value: t.data.curve_id[wellId], label: t.data.name};
      });
      this.SET_LOADING(false);
    },

    async setXData(curveId) {
      this.SET_LOADING(true);
      await this.$store.dispatch(FETCH_WELLS_CURVES, [curveId]);
      this.$emit('setXData', this.$store.state.geologyGis.CURVES_OF_SELECTED_WELLS[curveId]);
      this.SET_LOADING(false);
    },

    async setYData(curveId) {
      this.SET_LOADING(true);
      await this.$store.dispatch(FETCH_WELLS_CURVES, [curveId]);
      this.$emit('setYData', this.$store.state.geologyGis.CURVES_OF_SELECTED_WELLS[curveId]);
      this.SET_LOADING(false);
    },

    ...globalloadingMutations(["SET_LOADING"]),
  },

  computed: {
    getCurveList() {
      return this.curveList;
    },

    getWellList() {
      return this.$store.getters[GET_WELLS_OPTIONS];
    }
  }
};
</script>

<style scoped lang="scss">
.cross-plot__left-panel {
  color: white;
  background: #272953;
  border: 1px solid #545580;
  padding: 8px;
  min-width: 474px;
  font-size: 14px;

  &__title {
    padding-top: 4px;
    width: 130px;
    height: 24px;
    margin-top: 2px;
    margin-right: 4px;
    background: #363B68;
    text-align: center;
    font-weight: bold;
    color: #8389AF;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    cursor: pointer;
  }

  &__title-active {
    padding-top: 6px;
    height: 26px;
    margin-top: 0;
    color: white;
  }

  &__content {
    padding: 10px;
    padding-bottom: 0;
    background: #272953;
    border: 10px solid #363B68;
    border-top: 6px solid #363B68;
  }
}
</style>
