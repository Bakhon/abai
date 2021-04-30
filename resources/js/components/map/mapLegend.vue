<template>
  <div class="legend">
    <b-button v-b-toggle.legend variant="main2">Легенда</b-button>
    <b-collapse id="legend" class="mt-2">
      <b-card class="bg-main1 text-light">
        <div class="legend-item" v-for="(legend, index) in getMapLegends(variant)" :key="index">
          <div v-if="legend.type == 'icon-box'"
               class="icon-box"
               :class="legend.icon"></div>

          <div v-if="legend.type == 'color-box'"
               class="color-box"
               :style="{backgroundColor: getColorArray(legend.color)}"></div>

          <span>{{ legend.name }}</span>
        </div>
      </b-card>
    </b-collapse>
  </div>
</template>

<script>
import pipeColors from '~/json/pipe_colors.json'
import mapLegends from '~/json/map_legends.json'

export default {
  name: "mapLegend",
  props: {
    variant: {
      type: String,
      default: 'default',
    },
  },
  methods: {
    getMapLegends () {
      return mapLegends[this.variant];
    },
    getColorArray(colorVariant) {
      return this.colorArrayToRgb(pipeColors[this.variant][colorVariant])
    },
    colorArrayToRgb(colorArr) {
      return 'rgb(' + colorArr[0] + ', ' + colorArr[1] + ', ' + colorArr[2] + ')';
    },
  }
}
</script>

<style scoped lang="scss">
.legend {
  position: relative;
  z-index: 10;
  max-width: 275px;
  padding: 15px 0 0 15px;

  .btn {
    width: 100%;
    border: 1px solid rgba(60, 60, 60, .26);
    border-radius: 5px;
    height: 40px;
  }

  .legend-item {
    display: flex;
    margin-bottom: 15px;

    .color-box {
      width: 20px;
      height: 20px;
    }

    span {
      margin-left: 15px;
    }

    &:last-child {
      margin-bottom: 0px;
    }
  }
}
</style>