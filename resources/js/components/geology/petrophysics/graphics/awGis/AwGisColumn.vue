<template>
  <div class="column" ref="column" :style="{height: `${heightContainer - columnTopPadding}px`}">
    <div class="column__header d-flex flex-column" :style="{height: `${headerHeight}px`}">
      <div class="column__header_info">
        {{ columnName }}
      </div>
      <div class="column__header_info">
        1: 0
      </div>
    </div>
    <canvas ref="depthCanvas" :width="depthColumnWidth" />
  </div>
</template>

<script>
export default {
  name: "AwGisColumn",
  props: {
    depthColumnWidth: Number,
    headerHeight: Number,
    columnName: String,
    heightContainer: Number,
    columnTopPadding: Number,
    offsetY: Number
  },
  data() {
    return {
      ctx: null,
      offsetDepth: this.offsetY,
    }
  },
  watch: {
    headerHeight() {
      this.setCanvasSize()
    }
  },
  computed:{
    getOffsetDepth: {
      get() {
        return this.offsetDepth;
      },
      set(val) {
        this.offsetDepth = val;
      }
    }
  },
  mounted() {
    let {depthCanvas} = this.$refs;
    this.ctx = depthCanvas.getContext('2d');
    this.$emit('update:context', this.ctx)
    this.setCanvasSize();
  },
  methods: {
    setCanvasSize() {
      let {depthCanvas} = this.$refs;
      depthCanvas.height = this.heightContainer - this.headerHeight - this.columnTopPadding;
      this.$emit('resized', {context: this.ctx});
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
    }
  }
}
</style>
