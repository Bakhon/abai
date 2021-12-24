<template>
  <AwGisColumn
      ref="depthCanvas"
      v-bind="$attrs"
      :context.sync="context"
      @resized="initAxis"
      :header-height="headerHeight"
      :depth-column-width="depthColumnWidth"
      :offset-y="offsetY"
      :elements="[{data: {name: 'DEPTH'}}]"
  />
</template>
<script>
import AwGisColumn from "./AwGisColumn";
import {SET_SCROLL_BLOCK_Y} from "../../../../../store/modules/geologyGis.const";
import TCoords from "./utils/TCoords";
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
      scrollSpeed: 10,
      tCoords: new TCoords()
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
    },
    scrollBlock: {
      get() {
        return this.$store.state.geologyGis.blocksScrollY;
      },
      set(y) {
        this.$store.commit(SET_SCROLL_BLOCK_Y, y)
      }
    }
  },
  watch: {
    scrollBlock() {
      this.$emit('update:scrollBlock', this.scrollBlock)
      this.initAxis();
    }
  },
  mounted() {
    this.context.canvas.onwheel = (e) => {
      e.preventDefault();
      this.scrollBlock += e.deltaY > 1 ? this.scaleY : -this.scaleY;
    }

    this.context.canvas.onmousedown = () => {
      this.context.canvas.onmousemove = this.mouseMove;
    }

    this.context.canvas.onmouseup = () => {
      this.context.canvas.onmousemove = null;
    }
  },
  methods: {
    mouseMove(e) {
      e.preventDefault();
      this.scrollBlock -= e?.movementY*10;
    },
    initAxis() {
      if (!this.context)
        this.context = this.$refs.depthCanvas.canvas.getContext('2d');
      this.clearCanvas();
      this.drawAxis();
    },

    drawAxis() {
      let ctx = this.context;
      let offsetY = this.scrollBlock;
      let canvasHeight = ctx.canvas.height + offsetY;
      ctx.beginPath();
      for (let i = offsetY; i < canvasHeight; i++) {
        let y = i - offsetY;
        ctx.textAlign = 'right';
        ctx.textBaseline = 'middle';
        ctx.moveTo(this.depthColumnWidth, y);
        if (!(i % 10) || i === 0) {
          ctx.fillStyle = 'red'
          ctx.font = '12px serif'
          ctx.fillText(i.toString(), this.depthColumnWidth - 10, y);
          ctx.lineTo(this.depthColumnWidth - 5, y);
        }
      }
      ctx.stroke();
    },
    clearCanvas() {
      this.context.clearRect(0, 0, this.context.canvas.width, this.context.canvas.height);
    }
  }
}
</script>
