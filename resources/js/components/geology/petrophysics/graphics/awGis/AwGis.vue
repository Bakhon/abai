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
          :block-id="well.name"
          :groups="getGroups"
      />
      <canvas ref="infoCanvas" id="awGisCanvas" :height="settings.heightContainer" />
    </div>
  </div>
</template>

<script>
import AwGisBlock from "./AwGisBlock";
import {GET_GIS_GROUPS} from "../../../../../store/modules/geologyGis.const";

export default {
  name: "awGis",
  components: {
    AwGisBlock
  },
  data() {
    return {
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

  computed: {
    getGroups() {
      return this.$store.getters[GET_GIS_GROUPS];
    },
    getWellsBlock() {
      return this.$store.state.geologyGis.gisWells;
    }
  },
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
