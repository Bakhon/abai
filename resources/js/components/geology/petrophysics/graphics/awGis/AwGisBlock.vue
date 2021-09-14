<template>
  <div class="block" :style="{marginRight: `${blocksMargin}px`}">
    <div class="block__name">
      {{ blockName }}
    </div>
    <div class="block__content d-flex">
      <AwGisDepthColumn :changeOffsetY.sync="offsetY" v-bind="$attrs" />
      <AwGisColumn
          @resized="init"
          v-for="(element, key) in getElements"
          :ref="element.data.name.replace(/ /, '').trim()"
          v-bind="$attrs"
          :key="key"
          :column-name="element.data.name"
      />
    </div>
  </div>
</template>

<script>
import AwGisColumn from "./AwGisColumn";
import AwGisDepthColumn from "./AwGisDepthColumn";

export default {
  name: "AwGisBlock",
  props: {
    blockName: String,
    blocksMargin: Number,
    elements: Array
  },
  components: {
    AwGisDepthColumn,
    AwGisColumn
  },
  data() {
    return {
      context: [],
      offsetY: 0,
      min: 1,
      max: 1,
      offsetX: 0,
    }
  },
  watch: {
    offsetY() {
      this.init();
    },
    min() {
      this.init();
    },
    max() {
      this.init();
    }
  },
  computed: {
    getElements() {
      return this.elements;
    }
  },
  methods: {
    init() {
      for (const columnName of Object.keys(this.$refs)) {
        let column = this.$refs[columnName][0];
        let columnCtx = column.ctx;
        this.getElements.forEach((ee) => {
          if (ee.data.name === columnName && columnCtx) {
            let curve = ee.data.curve;
            this.clearCanvas(columnCtx);
            this.drawCurve(curve, columnCtx, columnName)
          }
        })
      }
    },
    drawCurve(curve = [], ctx, columnName) {
      let axisSize = 10;
      let canvasHeight = ctx.canvas.height / axisSize;
      let offsetY = this.offsetY;
      canvasHeight = canvasHeight += offsetY;
      ctx.beginPath();
      for (let i = offsetY; i < canvasHeight; i++) {
        let y = (i * axisSize) - offsetY * axisSize;
        let x = curve[i];
        if (i === 0) ctx.moveTo(x, y);
        else ctx.lineTo(x, y);
      }
      ctx.stroke();
      ctx.setTransform(1,0,0,1,0,0);
    },
    clearCanvas(ctx) {
      if (ctx) ctx?.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
    }
  }
}
</script>

<style scoped lang="scss">
.block {
  position: relative;
  padding-top: 30px;
  border: 1px solid black;

  &__name {
    min-height: 30px;
    background: #e3e3e3;
    font-size: 0.8em;
    padding: 5px 10px;
    text-align: center;
    position: absolute;
    width: 100%;
    top: 0;
    left: 0;
    overflow: hidden;
    white-space: nowrap;
  }
}
</style>
