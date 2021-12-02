<template>
  <div class="aw-gis" ref="mainContainer" :style="{ height: `${settings.heightContainer}px` }">
    <div class="block-wrapper d-flex" ref="blockWrapper">
      <AwGisBlock v-for="(well, key) in getWellsBlock" :style="key===0&&{marginLeft: `${stratigraphy.length?settings.offsetColumnsLeft:0}px`}" :ref="`block_${key}`" :alt="`block_${key}`" v-bind="settings"
                  :key="key" :block-name="well.name" :block-id="well.name" :groups="getGroups" />
      <svg ref="infoSvg" id="awGisSvg" :height="settings.heightContainer" />
    </div>
  </div>
</template>

<script>
import AwGisBlock from "./AwGisBlock";
import {GET_GIS_GROUPS} from "../../../../../store/modules/geologyGis.const";
import {MD5} from "./utils/utils";

export default {
  name: "awGis",
  props:{
    stratigraphy: Array
  },
  components: {
    AwGisBlock,
  },
  data() {
    return {
      wellsHash: null,
      groupSettingDefault: {},
      blocksScrollY: 0,
      settings: {
        blocksMargin: 20,
        headerHeight: 60,
        depthColumnWidth: 85,
        offsetY: 0,
        heightContainer: 500,
        columnTopPadding: 30,
        offsetColumnsLeft: 200,
        offsetColumnsRight: 200
      },
    };
  },

  computed: {
    tHorizon() {
      return this.$store.state.geologyGis.tHorizon;
    },
    getGroups() {
      return this.$store.getters[GET_GIS_GROUPS];
    },
    getWellsBlock() {
      return this.$store.state.geologyGis.gisWells;
    },
  },
  watch: {
    settings: {
      deep: true,
      handler() {
        this.tHorizon.settings = this.settings;
        this.initSvg();
      },
    },
    stratigraphy(){
      this.initSvg();
    },
    "$store.state.geologyGis.changeGisData"() {
      this.initSvg();
      this.tHorizon.redrawLastElements();
    },
  },
  mounted() {
    this.tHorizon.settings = this.settings;
    this.tHorizon.svg = this.$refs.infoSvg;
    this.initSvg();
  },
  methods: {
    initSvg() {
      let blocksRef = this.$refs,
          totalWidth = 0;
      let headerHeight = this.settings.headerHeight + this.settings.columnTopPadding;
      let widthBlock = Object.keys(blocksRef)
          .filter((name) => name.match(/block_/))
          .reduce((acc, blockName, index) => {
            let component = blocksRef[blockName][0];
            if (blocksRef[blockName].length && component) {
              let element = component.$el;
              acc.push({
                component,
                element,
                props: {
                  wellName: component.blockName,
                  top: element.offsetTop,
                  left: element.offsetLeft,
                  right: element.offsetWidth + element.offsetLeft,
                  bottom: element.offsetHeight + (element.offsetTop + headerHeight),
                  width: element.offsetWidth,
                  height: element.offsetHeight,
                },
              });
              totalWidth += element?.offsetWidth + (this.getWellsBlock.length - 1 !== index ? this.settings.blocksMargin : 0);
            }
            return acc;
          }, []);

      if (totalWidth > 0) {
        let width = totalWidth + this.settings.offsetColumnsLeft;
        let height = this.$refs.blockWrapper.offsetHeight - headerHeight;
        this.$refs.infoSvg.setAttribute("width", `${width}px`);
        this.$refs.infoSvg.setAttribute("height", `${height}px`);
        this.$refs.infoSvg.setAttribute("viewBox", `0 0 ${width} ${height}`);
        this.$refs.infoSvg.style.top = `${headerHeight}px`;
      }
      this.tHorizon.wells = widthBlock;
      this.tHorizon.calcWells();
      this.tHorizon.updateMaps();
      this.wellsHash = MD5(JSON.stringify(this.getWellsBlock));
    },
  },
};
</script>

<style scoped lang="scss">
.aw-gis {
  position: relative;
  border: 1px solid #f6f6f6;
  font-size: 16px;
  box-sizing: content-box;

  #awGisSvg {
    position: absolute;
    top: 0;
    left: 0;
    pointer-events: none;
  }

  .block-wrapper {
    position: relative;
    overflow-x: auto;
    overflow-y: hidden;
  }
}
</style>
