<template>
  <div class="column" ref="column" :style="{height: `${heightContainer - columnTopPadding}px`}">
    <div class="column__header d-flex flex-column" :style="{height: `${headerHeight}px`}">
      <div
          v-for="(el, i) in elements.filter((element)=>getElements.includes(element.data.name)||element.data.name === 'DEPTH')"
          :key="i">
        <div class="column__header_info">
          {{ el.data.name }}
        </div>
      </div>
    </div>
    <canvas ref="depthCanvas" :width="depthColumnWidth" />
  </div>
</template>

<script>
import TCanvas from "./utils/TCanvas";

export default {
  name: "AwGisColumn",
  props: {
    depthColumnWidth: Number,
    headerHeight: Number,
    wellName: String,
    columnName: String,
    heightContainer: Number,
    columnTopPadding: Number,
    offsetY: Number,
    elements: Array,
  },
  data() {
    return {
      canvas: null,
      columnElements: this.elements,
      selectedGisCurves: [],
      tCanvas: new TCanvas()
    }
  },
  watch: {
    headerHeight() {
      this.setCanvasSize()
    },
    offsetY(val){
      if(this.elements[0].data.name !== 'DEPTH'){
        this.tCanvas.setOffsetY = val*10;
        this.draw();
      }
    },
    "$store.state.geologyGis.changeGisData"() {
      if(this.elements[0].data.name !== 'DEPTH'){
        this.draw();
      }
    }
  },
  computed: {
    getElements() {
      return this.$store.state.geologyGis.selectedGisCurves;
    },
  },
  mounted() {
    let {depthCanvas} = this.$refs;
    this.tCanvas.setCanvas = this.canvas = depthCanvas;
    this.setCanvasSize();
  },
  methods: {
    draw() {
      this.tCanvas.clearCanvas();
      for (const {data:{name}} of this.elements) {
        let {data: {curves}, options} = this.$store.state.geologyGis.awGis.getElement(name)
        for (const [wellID, curve] of Object.entries(curves)) {
          if(wellID !== this.wellName) continue;
          if((options.isCSAT[wellID]||options.isLithology[wellID])&&(options.max[wellID] <= 4)) this.tCanvas.drawLithology(curve, {options, wellID})
          else this.tCanvas.drawCurve(curve, {options, wellID})
        }
      }
    },
    setCanvasSize() {
      let {depthCanvas} = this.$refs;
      depthCanvas.height = this.heightContainer - this.headerHeight - this.columnTopPadding;
      this.$emit('resized', [depthCanvas, this.columnElements]);
    },
  }
}
</script>

<style scoped lang="scss">
.column {
  background: #fff;

  &:not(:last-child) {
    border-right: 1px solid black;
  }

  &__header {
    text-align: center;
    border-bottom: 1px solid black;
    overflow: hidden;

    &_info {
      font-size: 0.7em;
      color: #212529;
    }
  }
}
</style>
