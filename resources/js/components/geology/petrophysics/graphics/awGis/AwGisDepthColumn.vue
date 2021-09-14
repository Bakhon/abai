<template>
  <AwGisColumn
      v-bind="$attrs"
      :context.sync="context"
      @resized="initAxis"
      :header-height="headerHeight"
      :depth-column-width="depthColumnWidth"
      :offset-y="offsetY"
  />
</template>
<script>
import AwGisColumn from "./AwGisColumn";
export default {
  name: "AwGisDepthColumn",
  components: {
    AwGisColumn
  },
  props: {
    headerHeight: Number,
    depthColumnWidth: Number,
    offsetY: Number
  },
  data() {
    return {
      context: null,
      offsetDepth: this.offsetY,
      scaleY: 10,
      scrollSpeed: 10
    }
  },
  computed: {
    getOffsetDepth: {
      get() {
        return this.offsetDepth;
      },
      set(val) {
        this.offsetDepth = val;
      }
    }
  },
  watch: {
    offsetDepth() {
      this.$emit('update:changeOffsetY', this.getOffsetDepth)
      this.initAxis();
    }
  },
  mounted() {
    this.context.canvas.onwheel = (e) => {
      e.preventDefault();
      this.getOffsetDepth += e.deltaY > 1 ? this.scaleY/**this.scrollSpeed*/ : -this.scaleY/**this.scrollSpeed*/;
    }

    this.context.canvas.onmousedown = () => {
      this.context.canvas.onmousemove = this.mouseMove;
    }

    this.context.canvas.onmouseup = () => {
      this.context.canvas.onmousemove = null;
    }
  },
  methods: {
    mouseMove(e){
      e.preventDefault();
      this.getOffsetDepth -= e?.movementY;
    },
    initAxis() {
      this.clearCanvas();
      this.drawAxis();
    },

    drawAxis() {
      let ctx = this.context;
      let axisSize = this.scaleY;
      let offsetY = this.getOffsetDepth;
      let canvasHeight = ctx.canvas.height / axisSize;
      canvasHeight = canvasHeight += offsetY;
      ctx.beginPath();
      for (let i = offsetY; i < canvasHeight; i++) {
        let y = (i * axisSize) - offsetY * axisSize;
        ctx.textAlign = 'right';
        ctx.textBaseline = 'middle';
        ctx.moveTo(this.depthColumnWidth, y);
        if (!(i % 10) || i === 0) {
          ctx.fillStyle = 'red'
          ctx.font = '12px serif'
          ctx.lineTo(this.depthColumnWidth - 5, y);
        } else {
          ctx.fillStyle = 'black'
          ctx.font = '8px serif'
          ctx.lineTo(this.depthColumnWidth - 3, y);
        }
        ctx.fillText(i.toString(), this.depthColumnWidth - 10, y);
      }
      ctx.stroke();
    },
    clearCanvas() {
      this.context.clearRect(0, 0, this.context.canvas.width, this.context.canvas.height);
    }
  }
}
</script>

<style scoped>

</style>
