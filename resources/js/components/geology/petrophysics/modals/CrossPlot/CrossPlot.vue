<template>
  <div class="cross-plot h-100">
    <div class="d-flex align-items-stretch h-100">
      <LeftSide @setXData="setXData" @setYData="setYData"/>
      <RightSide ref="RightSide"/>
    </div>
  </div>
</template>

<script>
import LeftSide from './components/LeftSide/LeftSide';
import RightSide from './components/RightSide';

export default {
  name: 'CrossPlot',

  components: {
    LeftSide,
    RightSide
  },

  methods: {

    setXData(value) {
      this.$refs.RightSide.draw(value, null);
    },

    setYData(value) {
      this.$refs.RightSide.draw(null, value);
    },
  },
}
</script>

<style scoped lang="scss">
.cross-plot {
  width: 100%;
  background: #272953;

  > div {
    min-height: 794px;
  }

  &__content {
    width: 100%;
    margin-left: 8px;
    background: #363B68;
    border: 1px solid #545580;
  }
}
</style>
