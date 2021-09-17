<template>
  <div class="aw-gis" ref="mainContainer" :style="{height: `${settings.heightContainer}px`}">
    <div class="block-wrapper d-flex" ref="blockWrapper">
      <AwGisBlock
          v-for="(well, key) in getWellsBlock"
          :ref="`block_${key}`"
          :alt="`block_${key}`"
          v-bind="settings"
          :key="key"
          :block-name="well.name"
      />
      <canvas ref="infoCanvas" id="awGisCanvas" :height="settings.heightContainer" />
    </div>
  </div>
</template>

<script>
import AwGisBlock from "./AwGisBlock";
import AwGisClass from "./utils/AwGisClass";
import {ADD_BLOCK, FETCH_GIS_DATA} from "../../../../../store/modules/geologyGis.const";

export default {
  name: "awGis",
  components: {
    AwGisBlock
  },
  data() {
    return {
      awGis: null,
      gisData: null,
      gisGroups: [],
      gisWells: [],
      groupSettingDefault: {},
      blocksScrollY: 0,
      settings: {
        blocksMargin: 20,
        headerHeight: 60,
        depthColumnWidth: 85,
        offsetY: 0,
        heightContainer: 500,
        columnTopPadding: 30,
      }
    }
  },
  async mounted() {
    this.awGis = new AwGisClass();
    await this.$store.dispatch(FETCH_GIS_DATA);
    for (let i = 0; i <1; i++) {
      this.$store.commit(ADD_BLOCK, `well ${i}`);
    }
    setTimeout(()=>{this.setInfoCanvasSize();}, 1)
  },
  computed: {
    getGroups() {
      return this.gisGroups;
    },
    getWellsBlock(){
      return this.$store.state.geologyGis.gisWells;
    }
  },

  methods: {
    addGroup(bockName, opt){
      this.awGis.addGroup(bockName, {...this.groupSettingDefault, ...opt});
      this.update();
    },

    selectCurve(curveName, curve, groupName) {
      if (groupName) {
        if(this.awGis.hasElementInGroup(groupName, curveName)) this.awGis.removeElementFromGroup(groupName, curveName)
        else this.awGis.addElementToGroup(groupName, curveName, curve)
      }
      this.update();
    },

    getGroupElementsWithData(groupName) {
      return this.awGis.getGroupElementsWithData(groupName)
    },

    getElement(elName) {
      return this.awGis.getElement(elName);
    },

    update() {
      this.gisGroups = this.awGis.getGroupsWithData;
    },

    setInfoCanvasSize() {
      let blocksRef = this.$refs
      let widthBlock = 0;
      let filteredBlocks = Object.keys(blocksRef).filter((name) => name.match(/block_/));
      if (filteredBlocks.length) {
        for (const name of filteredBlocks) {
          let block = blocksRef[name][0].$el;
          widthBlock += block?.offsetWidth + this.settings.blocksMargin
        }
        this.$refs.infoCanvas.width = widthBlock - this.settings.blocksMargin;
        this.$refs.infoCanvas.height = this.$refs.blockWrapper.offsetHeight;
      }
    },
  },
  provide() {
    return {
      awGis: this.awGis,
      update: this.update,
      addGroup: this.addGroup
    }
  }
}
</script>

<style scoped lang="scss">

.aw-gis {
  position: relative;
  border: 1px solid #f6f6f6;
  font-size: 16px;
  box-sizing: content-box;

  canvas#awGisCanvas {
    position: absolute;
    pointer-events: none;
  }

  .block-wrapper {
    position: relative;
    overflow-x: auto;
    overflow-y: hidden;
  }
}
</style>
