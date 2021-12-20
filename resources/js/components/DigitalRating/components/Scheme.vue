<template>
  <div class="correlation-scheme">
    <div class="well-list">
      <ul>
        <li
          v-for="(well, wellIdx) in wells"
          :key="wellIdx"
          :class="getClass(well)"
          @click="handleSelected(well, wellIdx)"
        >
          <span>{{ well.name }}</span>
        </li>
      </ul>
      <button type="button" class="btn-button btn-button--thm-green minw-200">
        <span>Применить</span>
      </button>
    </div>
    <AwGis :stratigraphy="[]"/>
  </div>
</template>

<script>
import {globalloadingMutations, digitalRatingState} from "@store/helpers";
import AwGis from '../../geology/petrophysics/graphics/awGis/AwGis';
import {
  FETCH_WELLS_MNEMONICS,
  SET_WELLS_BLOCKS,
  SET_WELLS,
  FETCH_WELLS_CURVES, SET_GIS_DATA_FOR_GRAPH, SET_SELECTED_WELL_CURVES_FORCE, FETCH_WELLS_HORIZONS
} from "../../../store/modules/geologyGis.const";

export default {
  name: "Scheme",

  components: {
    AwGis
  },

  async created() {
    await this.fetchWells();
    await this.fetchGraphs()
  },

  data() {
    return {
      wells: [],
      selectedWells: [],
      testWells: [
        {sort: 0, value: 'UZN_1428'},
        {sort: 1, value: 'UZN_0144'},
        {sort: 2, value: 'UZN_1027'},
        {sort: 3, value: 'UZN_9093'}
      ],
    }
  },

  computed: {
    getSelectedWells() {
      return this.selectedWells.map((item) => {
        return item.value
      })
    },

    getTestWells() {
      return this.testWells.map(el => el.value);
    },

    ...digitalRatingState([
      'sectorNumber',
      'horizonNumber'
    ]),
  },

  methods: {
    ...globalloadingMutations(["SET_LOADING"]),

    async fetchWells() {
      const res = await axios.get(
          `${process.env.MIX_TEST_MICROSERVICE}/las-list/${this.horizonNumber}/${this.sectorNumber}`
      );
      this.wells = this.getMapping(res?.data?.wells);
    },

    getMapping(arr) {
      return arr.map((el, index) => {
        return {
          sort: index,
          value: el,
          name: el
        }
      });
    },

    async apply() {
      let arr = this.selectedWells.sort((a, b) => a.sort < b.sort ? -1 : 1);
      await this.$store.dispatch(FETCH_WELLS_MNEMONICS, this.getSelectedWells);
      await this.$store.dispatch(FETCH_WELLS_HORIZONS, arr.map((el) => el.value));
      this.$store.commit(SET_WELLS, arr.map((el) => { return { name: el.name } }));
      this.$store.commit(SET_WELLS_BLOCKS, arr);
      this.$store.commit(SET_SELECTED_WELL_CURVES_FORCE, ["GR", "LLD", "SP"]);
      await this.fetchGraphs();
    },

    handleSelected(item) {
      let index = this.selectedWells.findIndex(el => el.value === item.value);
      if (~index) {
        this.selectedWells.splice(index, 1)
      } else {
        this.selectedWells.push(item);
      }
    },

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

    getClass(well) {
      return {
        'active': this.selectedWells.some(el => el.value === well.value)
      }
    }
  }
}
</script>

<style scoped lang="scss">
.correlation-scheme {
  display: flex;
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

.well-list {
  margin: 0 20px 0 0;
  width: 15%;
  display: block;
  padding: 10px 5px;

  ul {
    list-style: none;
    margin-left: 0;

    li {
      cursor: pointer;
      padding: 5px;

      &.active {
        background-color: #323370;
      }
    }
  }
}

button {
  width: 100%;
}

.aw-gis {
  width: 85%;
}
</style>
