<template>
  <div class="correlation-scheme">
    <AwGis />
<!--    <div class="correlation-scheme__item" v-for="(item, idx) in 3">-->
<!--      <div class="correlation-scheme__header">-->
<!--        <div class="correlation-scheme__header-title">-->
<!--          {{ trans('digital_rating.correlationScheme') + idx + 1 }}-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="correlation-scheme__content">-->
<!--        <img src="/img/digital-rating/scheme.svg" alt="">-->
<!--      </div>-->
<!--    </div>-->
  </div>
</template>

<script>
import {globalloadingMutations} from "@store/helpers";
import AwGis from '../../geology/petrophysics/graphics/awGis/AwGis';
import {
  FETCH_WELLS_MNEMONICS,
  SET_WELLS_BLOCKS,
  SET_WELLS,
  FETCH_WELLS_CURVES, SET_GIS_DATA_FOR_GRAPH, SET_SELECTED_WELL_CURVES_FORCE
} from "../../../store/modules/geologyGis.const";

export default {
  name: "Scheme",

  components: {
    AwGis
  },

  async created() {
    await this.fetchGraphs();
  },

  data() {
    return {
      testWells: [
        {sort: 0, value: 'UZN_1428'},
        {sort: 1, value: 'UZN_0144'},
        {sort: 2, value: 'UZN_1027'},
        {sort: 3, value: 'UZN_9093'}
      ],
      wellList: {
        '9313': [
          {sort: 0, value: 'UZN_1291'},
          {sort: 1, value: 'UZN_3313'},
          {sort: 2, value: 'UZN_3314'},
          {sort: 3, value: 'UZN_3505'},
          {sort: 4, value: 'UZN_4140'},
          {sort: 5, value: 'UZN_4439'},
          {sort: 6, value: 'UZN_7272'},
          {sort: 7, value: 'UZN_7296'},
          {sort: 8, value: 'UZN_7934'},
          {sort: 9, value: 'UZN_9133'},
        ],
        '10252': [
          {sort: 0, value: 'UZN_4439'},
          {sort: 1, value: 'UZN_5617'},
        ]
      },
      wells: {
        '9313': [
          {name: 'UZN_1291'},
          {name: 'UZN_3313'},
          {name: 'UZN_3314'},
          {name: 'UZN_3505'},
          {name: 'UZN_4140'},
          {name: 'UZN_4439'},
          {name: 'UZN_7272'},
          {name: 'UZN_7296'},
          {name: 'UZN_7934'},
          {name: 'UZN_9133'},
        ],
        '10252': [
          {name: 'UZN_4439'},
          {name: 'UZN_5617'},
        ]
      }
    }
  },

  computed: {
    getTestWells() {
      return this.testWells.map(el => el.value);
    }
  },

  methods: {
    ...globalloadingMutations(["SET_LOADING"]),
    async fetchGraphs() {
      this.SET_LOADING(true);
      await this.$store.dispatch(FETCH_WELLS_MNEMONICS, this.getTestWells);
      this.$store.commit(SET_WELLS, [{name: 'UZN_1428'}, {name: 'UZN_0144'}, {name: 'UZN_1027'}, {name: 'UZN_9093'}]);
      this.$store.commit(SET_WELLS_BLOCKS, this.testWells);
      this.$store.commit(SET_SELECTED_WELL_CURVES_FORCE, ["GR", "LLD", "SP"]);

      const awGisData = this.$store.state.geologyGis.awGis.getElementsWithData();
      const {
        CURVES_OF_SELECTED_WELLS: loadedCurves,
        selectedGisCurves: awGisSelectedCurves,
        gisWells: awGisSelectedWells
      } = this.$store.state.geologyGis;

      let selectedCurves = awGisSelectedCurves.reduce((acc, element) => {
        let findElement = awGisData.find(({data}) => (element === data.name && awGisSelectedWells.find((w) => data.wellID.includes(w.name))));
        if (findElement?.data) {
          let curves = Object.values(findElement.data.curve_id);
          let hasCurve = curves.every((item) => Object.keys(loadedCurves).includes(item.toString()));
          if (!hasCurve) acc.push(...curves);
        }
        return acc;
      }, []);

      await this.$store.dispatch(FETCH_WELLS_CURVES, selectedCurves);
      this.$store.commit(SET_GIS_DATA_FOR_GRAPH);
      this.SET_LOADING(false);
    },
    getWells(sector) {
      return this.wellList[sector].map(item => item.value);
    }
  }
}
</script>

<style scoped lang="scss">
.correlation-scheme {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.correlation-scheme__item {
  width: calc(33% - 2px);
  background-color: #272953;
  padding: 10px;
  margin-bottom: 10px;
}
.correlation-scheme__header {
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}
.correlation-scheme__content {
  img {
    width: 100%;
  }
}
</style>
